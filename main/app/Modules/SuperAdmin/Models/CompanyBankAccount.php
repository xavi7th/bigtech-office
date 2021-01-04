<?php

namespace App\Modules\SuperAdmin\Models;

use Cache;
use App\BaseModel;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\ErrLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Models\ProductSaleRecord;
use App\Modules\SuperAdmin\Models\SalesRecordBankAccount;
use App\Modules\SuperAdmin\Transformers\CompanyBankAccountTransformer;
use App\Modules\SuperAdmin\Http\Validations\CreateBankAccountValidation;
use App\Modules\SuperAdmin\Transformers\BankPaymentRecordTransformer;
use Arr;

/**
 * App\Modules\SuperAdmin\Models\CompanyBankAccount
 *
 * @property int $id
 * @property string $bank
 * @property string $account_name
 * @property string $account_number
 * @property string $account_type
 * @property string|null $img_url
 * @property string|null $account_description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|SalesRecordBankAccount[] $payment_records
 * @property-read int|null $payment_records_count
 * @property-read \Illuminate\Database\Eloquent\Collection|ProductSaleRecord[] $sales_records
 * @property-read int|null $sales_records_count
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyBankAccount cashTransactions()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyBankAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyBankAccount newQuery()
 * @method static \Illuminate\Database\Query\Builder|CompanyBankAccount onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyBankAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyBankAccount whereAccountDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyBankAccount whereAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyBankAccount whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyBankAccount whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyBankAccount whereBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyBankAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyBankAccount whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyBankAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyBankAccount whereImgUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyBankAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|CompanyBankAccount withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CompanyBankAccount withoutTrashed()
 * @mixin \Eloquent
 */
class CompanyBankAccount extends BaseModel
{

  use SoftDeletes;

  protected $fillable = [
    'account_name', 'account_number', 'bank', 'account_description', 'account_type', 'img_url'
  ];

  public function sales_records()
  {
    return $this->belongsToMany(ProductSaleRecord::class, $table = 'sales_record_bank_accounts')->using(SalesRecordBankAccount::class)
      ->as('payment_record')->withPivot('amount')->withTimestamps();
  }

  public function payment_records()
  {
    return $this->hasMany(SalesRecordBankAccount::class);
  }

  public function payment_records_sum(): float
  {
    return $this->payment_records()->sum('amount');
  }

  public function total_sales_records_amount()
  {
    return $this->sales_records()->sum('amount');
  }

  public function today_payment_records_sum()
  {
    return $this->sales_records()->today()->sum('amount');
  }

  static function cash_transaction_id(): int
  {
    return optional(self::where('bank', 'Cash')->first())->id ?? 0;
  }

  public static function superAdminRoutes()
  {
    Route::group(['prefix' => 'company-bank-accounts'], function () {
      $misc = function ($name) {
        return 'superadmin.miscellaneous.' . $name;
      };
      Route::get('', [self::class, 'getCompanyBankAccounts'])->name($misc('bank_accounts'))->defaults('ex', __e('ss', 'refresh-cw', false));
      Route::get('daily-transactions', [self::class, 'getAllPaymentTransactionsToday'])->name($misc('bank_accounts_daily_transactions'))->defaults('ex', __e('ss', 'refresh-cw', true));
      Route::get('{companyBankAccount:account_number}/daily-transactions', [self::class, 'getDailyPaymentTransactions'])->name($misc('bank_account_daily_transactions'))->defaults('ex', __e('ss', 'refresh-cw', true));
      Route::get('transaction-history', [self::class, 'getPaymentTransactionsSummary'])->name($misc('payment_records'))->defaults('ex', __e('ss', 'layers', false));
      Route::get('{companyBankAccount:bank}/{date}/transaction-history', [self::class, 'getBankPaymentTransactionsHistory'])->name($misc('bank_payment_records'))->defaults('ex', __e('ss', 'layers', true));
      Route::post('create', [self::class, 'createCompanyBankAccount'])->name($misc('create_bank_account'))->defaults('ex', __e('ss', 'refresh-cw', true));
      Route::put('{companyBankAccount}/edit', [self::class, 'editCompanyBankAccount'])->name($misc('edit_bank_account'))->defaults('ex', __e('ss', 'refresh-cw', true));
      Route::delete('{companyBankAccount}/suspend', [self::class, 'suspendCompanyBankAccount'])->name($misc('suspend_bank_account'))->defaults('ex', __e('ss', 'refresh-cw', true));
      Route::delete('{id}/restore', [self::class, 'restoreCompanyBankAccount'])->name($misc('restore_bank_account'))->defaults('ex', __e('ss', 'refresh-cw', true));
    });
  }

  public function getCompanyBankAccounts(Request $request)
  {
    $bankAccounts = Cache::rememberForever('bankAccounts', function () {
      return (new CompanyBankAccountTransformer)->collectionTransformer(self::withTrashed()->with(['payment_records' => fn ($query) => $query->today()])->get(), 'transformWithPaymentRecordSum');
    });

    if ($request->isApi())  return response()->json($bankAccounts, 200);
    return Inertia::render('SuperAdmin,Miscellaneous/ManageBankAccounts', compact('bankAccounts'));
  }

  public function getDailyPaymentTransactions(Request $request, self $companyBankAccount)
  {
    $companyBankAccountWithTransactions = (new CompanyBankAccountTransformer)->transformWithPaymentRecords($companyBankAccount->load(['payment_records' => fn ($query) => $query->today(), 'payment_records.product_sale_record.product.product_model', 'payment_records.product_sale_record.product.product_price']));

    if ($request->isApi())  return response()->json($companyBankAccountWithTransactions, 200);
    return Inertia::render('SuperAdmin,Miscellaneous/BankAccountTransactions', [
      'companyAccountTransactions' => $companyBankAccountWithTransactions['payment_records'],
      'companyAccount' => Arr::except($companyBankAccountWithTransactions, 'payment_records'),
      'date' => now(),

    ]);
  }

  public function getAllPaymentTransactionsToday(Request $request)
  {
    $companyBankAccountWithTransactions = (new BankPaymentRecordTransformer)->collectionTransformer(SalesRecordBankAccount::today()->with('company_bank_account', 'product_sale_record.product.product_model')->get(), 'fullDetails');

    if ($request->isApi())  return response()->json($companyBankAccountWithTransactions, 200);
    return Inertia::render('SuperAdmin,Miscellaneous/BankAccountTransactions', [
      'companyAccountTransactions' => $companyBankAccountWithTransactions,
      'companyAccount' => [],
      'date' => now(),

    ]);
  }

  public function getPaymentTransactionsSummary(Request $request)
  {
    $paymentRecords = (new BankPaymentRecordTransformer)->collectionTransformer(SalesRecordBankAccount::with('company_bank_account', 'product_sale_record.product.product_model')->get(), 'transformForSummary')
    ->groupBy(['created_at', 'bank'], true)->map(fn ($item, $key) =>  $item->map(fn ($item, $key) =>  $item->sum('amount_paid')));

    if ($request->isApi())  return response()->json($paymentRecords, 200);
    return Inertia::render('SuperAdmin,Miscellaneous/PaymentRecords', [
      'paymentRecords' => $paymentRecords,
    ]);
  }

  public function getBankPaymentTransactionsHistory(Request $request, self $companyBankAccount, string $date)
  {
    $paymentRecords = (new BankPaymentRecordTransformer)->collectionTransformer($companyBankAccount->payment_records()->whereDate('created_at', $date)->get(), 'transformForSummary');

    if ($request->isApi())  return response()->json($paymentRecords, 200);
    return Inertia::render('SuperAdmin,Miscellaneous/BankAccountTransactions', [
      'companyAccountTransactions' => $paymentRecords,
      'companyAccount' => $companyBankAccount,
      'date' => $date,
    ]);
  }

  public function createCompanyBankAccount(CreateBankAccountValidation $request)
  {
    try {
      $account = self::create([
        'account_name' => $request->account_name,
        'account_number' => $request->account_number,
        'bank' => $request->bank,
        'account_description' => $request->account_description,
        'account_type' => $request->account_type,
        'img_url' => compress_image_upload('img', 'bank-logos/', null, 200)['img_url'],
      ]);

      if ($request->isApi()) return response()->json((new CompanyBankAccountTransformer)->basic($account), 201);
      return back()->withFlash(['success'=>'Bank Account created. <br/> Payments can now be created under this bank account']);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Company Account not created');

      if ($request->isApi()) return response()->json(['err' => 'Account details NOT updated'], 500);
      return back()->withFlash(['error'=>['Account creation failed']]);
    }
  }

  public function editCompanyBankAccount(CreateBankAccountValidation $request, self $companyBankAccount)
  {
    try {
      foreach (collect($request->validated())->except('img') as $key => $value) {
        $companyBankAccount->$key = $value;
      }
      if ($request->hasFile('img')) {
        $companyBankAccount->img_url = compress_image_upload('img', 'bank-logos/', null, 200)['img_url'];
      }

      $companyBankAccount->save();

      if ($request->isApi())  return response()->json([], 204);
      return back()->withFlash(['success'=>'Bank Account updated. <br/> Payments can now be created under this bank account']);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Account details NOT updated');

      if ($request->isApi()) return response()->json(['err' => 'Account details NOT updated'], 500);
      return back()->withFlash(['error'=>['Account creation failed']]);
    }
  }

  public function suspendCompanyBankAccount(Request $request, self $companyBankAccount)
  {
    $companyBankAccount->delete();

    if ($request->isApi()) return response()->json([], 204);
    return back()->withFlash(['success'=>'Account suspended and will no longer be available to users as a payment option']);

  }

  public function restoreCompanyBankAccount(Request $request, $id)
  {
    self::onlyTrashed()
      ->find($id)
      ->restore();



    if ($request->isApi()) {
      return response()->json([], 204);
    } else {
      return back()->withFlash(['success'=>'Account restored and has become available to users as a payment option']);
    }
  }

  /**
   * Scope a query to only cash transactions
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeCash_transactions($query)
  {
    return $query->where('id', self::cash_transaction_id());
  }


  protected static function boot()
  {
    parent::boot();

    static::saved(function () {
      Cache::forget('bankAccounts');
      Cache::forget('companyAccounts');
    });
    static::deleted(function () {
      Cache::forget('bankAccounts');
      Cache::forget('companyAccounts');
    });
    static::restored(function () {
      Cache::forget('bankAccounts');
      Cache::forget('companyAccounts');
    });
  }
}
