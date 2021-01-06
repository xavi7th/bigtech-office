<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Modules\SuperAdmin\Models\LocalProductPrice
 *
 * @property int $id
 * @property int $product_id
 * @property float $cost_price
 * @property float $proposed_selling_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|LocalProductPrice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalProductPrice newQuery()
 * @method static \Illuminate\Database\Query\Builder|LocalProductPrice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalProductPrice query()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalProductPrice whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalProductPrice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalProductPrice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalProductPrice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalProductPrice whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalProductPrice whereProposedSellingPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalProductPrice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|LocalProductPrice withTrashed()
 * @method static \Illuminate\Database\Query\Builder|LocalProductPrice withoutTrashed()
 * @mixin \Eloquent
 */
class LocalProductPrice extends Model
{
  use SoftDeletes;

  protected $fillable = ['product_id', 'cost_price', 'proposed_selling_price',];

  public function product()
  {
    return $this->belongsTo(Product::class);
  }

  protected static function boot()
  {
    parent::boot();

    static::saved(function ($product) {
      Cache::forget('products');
    });
  }
}
