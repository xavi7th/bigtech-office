<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Modules\SuperAdmin\Models\CompanyBankAccount;

/**
 * App\Modules\SuperAdmin\Models\SalesRecordBankAccount
 *
 * @property-read \App\Modules\SuperAdmin\Models\CompanyBankAccount $company_bank_account
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SalesRecordBankAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SalesRecordBankAccount newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\SalesRecordBankAccount onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SalesRecordBankAccount query()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\SalesRecordBankAccount withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\SalesRecordBankAccount withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property int $product_sale_record_id
 * @property int $company_bank_account_id
 * @property float $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SalesRecordBankAccount whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SalesRecordBankAccount whereCompanyBankAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SalesRecordBankAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SalesRecordBankAccount whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SalesRecordBankAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SalesRecordBankAccount whereProductSaleRecordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SalesRecordBankAccount whereUpdatedAt($value)
 */
class SalesRecordBankAccount extends Pivot
{
  use SoftDeletes;

  protected $fillable = ['company_bank_account_id', 'amount'];
  protected $casts = [
    'amount' => 'float'
  ];

  protected $table = "sales_record_bank_accounts";

  public function company_bank_account()
  {
    return $this->belongsTo(CompanyBankAccount::class);
  }
}
