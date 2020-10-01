<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\Reseller;
use App\Modules\SuperAdmin\Models\ActivityLog;

class ResellerHistory extends Model
{
  protected $fillable = [
    'product_id',
    'product_type',
    'handled_by',
    'handler_type',
    'product_status'
  ];

  public function handler()
  {
    return $this->morphTo('handler', 'handler_type', 'handled_by');
  }

  public function product()
  {
    return $this->morphTo();
  }

  public function reseller()
  {
    return $this->belongsTo(Reseller::class);
  }

  protected static function boot()
  {
    parent::boot();

    static::created(function (self $reseller_history) {
      $reseller_history->load('product', 'reseller');
      if (is_null($reseller_history->product_status)) {
        ActivityLog::notifySuperAdmins(request()->user()->email . ' gave product with ' . $reseller_history->product->primary_identifier() . ' to reseller:  "' . $reseller_history->reseller->business_name . '"');
      } else {
        ActivityLog::notifySuperAdmins($reseller_history->reseller->business_name . ' has ' . $reseller_history->product_status . ' product with ' . $reseller_history->product->primary_identifier() . '. Handler: ' . request()->user()->email);
      }
    });

    static::retrieved(function (ResellerHistory $reseller_history) {
      $reseller_history->load('handler', 'reseller', 'product');
    });
  }
}
