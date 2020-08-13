<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\ProductModel;

/**
 * App\Modules\SuperAdmin\Models\ProductModelImage
 *
 * @property int $id
 * @property int $product_model_id
 * @property string $img_url
 * @property string|null $thumb_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read ProductModel $product_model
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModelImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModelImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModelImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModelImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModelImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModelImage whereImgUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModelImage whereProductModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModelImage whereThumbUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModelImage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductModelImage extends Model
{
  protected $fillable = ['img_url', 'thumb_url'];

  public function product_model()
  {
    return $this->belongsTo(ProductModel::class);
  }
}
