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

  public function sales_records_amount()
  {
    return $this->sales_records()->sum('amount');
  }

  static function cash_transaction_id(): int
  {
    return optional(self::where('bank', 'Cash')->first())->id ?? 0;
  }

  public static function routes()
  {
    Route::group(['prefix' => 'company-bank-accounts'], function () {
      $misc = function ($name) {
        return 'superadmin.miscellaneous.' . $name;
      };
      Route::get('', [self::class, 'getCompanyBankAccounts'])->name($misc('bank_accounts'))->defaults('ex', __e('ss', 'refresh-cw', false));
      Route::post('create', [self::class, 'createCompanyBankAccount'])->name($misc('create_bank_account'))->defaults('ex', __e('ss', 'refresh-cw', true));
      Route::put('{companyBankAccount}/edit', [self::class, 'editCompanyBankAccount'])->name($misc('edit_bank_account'))->defaults('ex', __e('ss', 'refresh-cw', true));
      Route::delete('{companyBankAccount}/suspend', [self::class, 'suspendCompanyBankAccount'])->name($misc('suspend_bank_account'))->defaults('ex', __e('ss', 'refresh-cw', true));
      Route::delete('{id}/restore', [self::class, 'restoreCompanyBankAccount'])->name($misc('restore_bank_account'))->defaults('ex', __e('ss', 'refresh-cw', true));
    });
  }


  public function getCompanyBankAccounts(Request $request)
  {
    $bankAccounts = Cache::rememberForever('bankAccounts', function () {
      return (new CompanyBankAccountTransformer)->collectionTransformer(self::withTrashed()->get(), 'basic');
    });

    if ($request->isApi())  return response()->json($bankAccounts, 200);
    return Inertia::render('SuperAdmin,Miscellaneous/ManageBankAccounts', compact('bankAccounts'));
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
      return back()->withSuccess('Bank Account created. <br/> Payments can now be created under this bank account');
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Company Account not created');

      if ($request->isApi()) return response()->json(['err' => 'Account details NOT updated'], 500);
      return back()->withError('Account creation failed');
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
      return back()->withSuccess('Bank Account updated. <br/> Payments can now be created under this bank account');
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Account details NOT updated');

      if ($request->isApi()) return response()->json(['err' => 'Account details NOT updated'], 500);
      return back()->withError('Account creation failed');
    }
  }

  public function suspendCompanyBankAccount(Request $request, self $companyBankAccount)
  {
    $companyBankAccount->delete();

    if ($request->isApi()) return response()->json([], 204);
    return back()->withSuccess('Account suspended and will no longer be available to users as a payment option');

  }

  public function restoreCompanyBankAccount(Request $request, $id)
  {
    self::onlyTrashed()
      ->where('id', $id)
      ->restore();



    if ($request->isApi()) {
      return response()->json([], 204);
    } else {
      return back()->withSuccess('Account restored and has become available to users as a payment option');
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

    static::saved(function ($product) {
      Cache::forget('bankAccounts');
    });
  }
}
