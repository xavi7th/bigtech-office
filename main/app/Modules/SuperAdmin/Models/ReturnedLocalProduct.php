<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Models\ProductSupplier;

/**
 * App\Modules\SuperAdmin\Models\ReturnedLocalProduct
 *
 * @property int $id
 * @property int $product_supplier_id
 * @property string $product_description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read ProductSupplier $productSupplier
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnedLocalProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnedLocalProduct newQuery()
 * @method static \Illuminate\Database\Query\Builder|ReturnedLocalProduct onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnedLocalProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnedLocalProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnedLocalProduct whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnedLocalProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnedLocalProduct whereProductDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnedLocalProduct whereProductSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnedLocalProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ReturnedLocalProduct withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ReturnedLocalProduct withoutTrashed()
 * @mixin \Eloquent
 */
class ReturnedLocalProduct extends Model
{
  use SoftDeletes;
  protected $fillable = ['product_supplier_id', 'product_description'];

  protected $casts = ['product_supplier_id' => 'int'];

  public function productSupplier()
  {
    return $this->belongsTo(ProductSupplier::class);
  }

  static function findProduct(string $imei): self
  {
    return self::where('product_description', 'LIKE', '%' . $imei . '%')->first();
  }
}
