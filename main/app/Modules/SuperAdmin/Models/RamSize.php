<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Modules\SuperAdmin\Models\RamSize
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\RamSize newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\RamSize newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\RamSize onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\RamSize query()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\RamSize withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\RamSize withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string $size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\RamSize whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\RamSize whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\RamSize whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\RamSize whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\RamSize whereUpdatedAt($value)
 */
class RamSize extends Model
{
  use SoftDeletes;

  protected $fillable = ['size'];
  protected $table = 'storage_sizes';
}
