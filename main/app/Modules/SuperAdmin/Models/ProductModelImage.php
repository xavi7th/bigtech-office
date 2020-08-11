<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\ProductModel;

/**
 * App\Modules\SuperAdmin\Models\ProductModelImage
 *
 * @property-read \App\Modules\SuperAdmin\Models\ProductModel $product_model
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductModelImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductModelImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductModelImage query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $product_model_id
 * @property string $img_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductModelImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductModelImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductModelImage whereImgUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductModelImage whereProductModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductModelImage whereUpdatedAt($value)
 * @property string|null $thumb_img_url
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModelImage whereThumbImgUrl($value)
 */
class ProductModelImage extends Model
{
  protected $fillable = ['img_url'];

  public function product_model()
  {
    return $this->belongsTo(ProductModel::class);
  }
}
