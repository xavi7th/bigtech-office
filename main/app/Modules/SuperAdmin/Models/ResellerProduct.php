<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Modules\SuperAdmin\Models\ResellerProduct
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ResellerProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ResellerProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ResellerProduct query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $reseller_id
 * @property int $product_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ResellerProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ResellerProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ResellerProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ResellerProduct whereResellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ResellerProduct whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ResellerProduct whereUpdatedAt($value)
 */
class ResellerProduct extends Pivot
{
  protected $fillable = [];

  /**
   * Indicates if the IDs are auto-incrementing.
   *
   * @var bool
   */
  public $incrementing = true;
}
