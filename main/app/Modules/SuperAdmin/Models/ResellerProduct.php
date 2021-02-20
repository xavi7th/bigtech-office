<?php

namespace App\Modules\SuperAdmin\Models;

use App\Modules\SuperAdmin\Models\Reseller;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

/**
 * App\Modules\SuperAdmin\Models\ResellerProduct
 *
 * @property int $id
 * @property int $reseller_id
 * @property int $product_id
 * @property string $product_type
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $product
 * @property-read Reseller $reseller
 * @method static \Illuminate\Database\Eloquent\Builder|ResellerProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResellerProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResellerProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|ResellerProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResellerProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResellerProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResellerProduct whereProductType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResellerProduct whereResellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResellerProduct whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResellerProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ResellerProduct extends MorphPivot
{
  protected $fillable = [];

  /**
   * Indicates if the IDs are auto-incrementing.
   *
   * @var bool
   */
  public $incrementing = true;

  public function reseller()
  {
    return $this->belongsTo(Reseller::class);
  }

  public function product()
  {
    return $this->morphTo('product');
  }


  protected static function boot()
  {
    parent::boot();

    static::saved(function (self $record) {
      if (request()->user()) {
        $record->reseller->reseller_histories()->create([
          'product_id' => $record->product->id,
          'product_type' => get_class($record->product),
          'handled_by' => request()->user()->id,
          'handler_type' => get_class(request()->user()),
          'product_status' => $record->status ?? 'tenured'
        ]);
      }
    });
  }
}
