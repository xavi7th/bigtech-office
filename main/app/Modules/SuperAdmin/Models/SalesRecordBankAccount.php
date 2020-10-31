<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Modules\SuperAdmin\Models\ProductSaleRecord;
use App\Modules\SuperAdmin\Models\CompanyBankAccount;

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

  public function product_sale_record()
  {
    return $this->belongsTo(ProductSaleRecord::class);
  }


  public function scopeToday($query)
  {
    return $query->whereDate('created_at', today());
  }

  public function scopeThisMonth($query)
  {
    return $query->whereMonth('created_at', today());
  }
}
