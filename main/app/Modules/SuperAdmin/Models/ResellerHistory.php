<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\Reseller;
use App\Modules\SuperAdmin\Models\ActivityLog;

/**
 * App\Modules\SuperAdmin\Models\ResellerHistory
 *
 * @property int $id
 * @property int $reseller_id
 * @property int $product_id
 * @property string $product_type
 * @property string $product_status
 * @property int $handled_by
 * @property string $handler_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $handler
 * @property-read Model|\Eloquent $product
 * @property-read Reseller $reseller
 * @method static \Illuminate\Database\Eloquent\Builder|ResellerHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResellerHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResellerHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ResellerHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResellerHistory whereHandledBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResellerHistory whereHandlerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResellerHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResellerHistory whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResellerHistory whereProductStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResellerHistory whereProductType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResellerHistory whereResellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResellerHistory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
        ActivityLog::notifySuperAdmins(optional(request()->user())->email ?? 'Console App' . ' gave product with ' . $reseller_history->product->primary_identifier() . ' to reseller:  "' . $reseller_history->reseller->business_name . '"');
      } else {
        ActivityLog::notifySuperAdmins($reseller_history->reseller->business_name . ' has ' . $reseller_history->product_status . ' product with ' . $reseller_history->product->primary_identifier() . '. Handler: ' . request()->user()->email);
      }
    });

    static::retrieved(function (ResellerHistory $reseller_history) {
      $reseller_history->load('handler', 'reseller', 'product');
    });
  }
}
