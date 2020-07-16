<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\ErrLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use Awobaz\Compoships\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\ProductSaleRecord;
use App\Modules\SuperAdmin\Models\SalesRecordBankAccount;
use App\Modules\SuperAdmin\Transformers\CompanyBankAccountTransformer;
use App\Modules\SuperAdmin\Http\Validations\CreateBankAccountValidation;

/**
 * App\Modules\SuperAdmin\Models\CompanyBankAccount
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\ProductSaleRecord[] $sales_records
 * @property-read int|null $sales_records_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\CompanyBankAccount cashTransactions()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\CompanyBankAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\CompanyBankAccount newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\CompanyBankAccount onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\CompanyBankAccount query()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\CompanyBankAccount withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\CompanyBankAccount withoutTrashed()
 * @mixin \Eloquent
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\CompanyBankAccount whereAccountDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\CompanyBankAccount whereAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\CompanyBankAccount whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\CompanyBankAccount whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\CompanyBankAccount whereBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\CompanyBankAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\CompanyBankAccount whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\CompanyBankAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\CompanyBankAccount whereImgUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\CompanyBankAccount whereUpdatedAt($value)
 */
class CompanyBankAccount extends Model
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
      Route::post('create', [self::class, 'createCompanyBankAccount'])->name($misc('create_account'))->defaults('ex', __e('ss', 'refresh-cw', true));
      Route::put('{company_bank_account}/edit', [self::class, 'editCompanyBankAccount'])->name($misc('edit_account'))->defaults('ex', __e('ss', 'refresh-cw', true));
    });
  }


  public function getCompanyBankAccounts()
  {
    return response()->json((new CompanyBankAccountTransformer)->collectionTransformer(self::all(), 'basic'), 200);
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
        'img_url' => $request->img_url,
      ]);

      return response()->json((new CompanyBankAccountTransformer)->basic($account), 201);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Company Account not created');
      return response()->json(['err' => 'Company Account not created'], 500);
    }
  }


  public function editCompanyBankAccount(CreateBankAccountValidation $request, self $company_bank_account)
  {
    try {
      foreach ($request->validated() as $key => $value) {
        $company_bank_account->$key = $value;
      }

      $company_bank_account->save();

      return response()->json([], 204);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Account details NOT updated');
      return response()->json(['err' => 'Account details NOT updated'], 500);
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
}
