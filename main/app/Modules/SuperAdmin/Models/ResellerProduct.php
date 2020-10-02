<?php

namespace App\Modules\SuperAdmin\Models;

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
}
