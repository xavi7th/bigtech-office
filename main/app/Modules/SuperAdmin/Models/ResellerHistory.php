<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\Reseller;
use App\Modules\SuperAdmin\Models\ActivityLog;

/**
 * App\Modules\SuperAdmin\Models\ResellerHistory
 *
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $handler
 * @property-read \App\Modules\SuperAdmin\Models\Product $product
 * @property-read \App\Modules\SuperAdmin\Models\Reseller $reseller
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ResellerHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ResellerHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ResellerHistory query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $reseller_id
 * @property int $product_id
 * @property string $product_status
 * @property int $handled_by
 * @property string $handler_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ResellerHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ResellerHistory whereHandledBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ResellerHistory whereHandlerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ResellerHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ResellerHistory whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ResellerHistory whereProductStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ResellerHistory whereResellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ResellerHistory whereUpdatedAt($value)
 */
class ResellerHistory extends Model
{
  protected $fillable = [
    'product_id',
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
    return $this->belongsTo(Product::class);
  }

  public function reseller()
  {
    return $this->belongsTo(Reseller::class);
  }

  protected static function boot()
  {
    parent::boot();
    static::creating(function (ResellerHistory $reseller_history) {
      $reseller_history->load('product', 'reseller');
      if (is_null($reseller_history->product_status)) {
        ActivityLog::notifyAdmins(auth(auth()->getDefaultDriver())->user()->email . ' gave product with UUID: ' . $reseller_history->product->product_uuid . ' to reseller:  "' . $reseller_history->reseller->business_name . '"');
      } else {
        ActivityLog::notifyAdmins($reseller_history->reseller->business_name . ' has ' . $reseller_history->product_status . ' product with UUID: ' . $reseller_history->product->product_uuid . '. Handler: ' . auth(auth()->getDefaultDriver())->user()->email);
      }
    });
    static::retrieved(function (ResellerHistory $reseller_history) {
      $reseller_history->load('handler', 'reseller', 'product');
    });
  }
}
