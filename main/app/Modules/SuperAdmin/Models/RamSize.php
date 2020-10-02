<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Modules\SuperAdmin\Models\RamSize
 *
 * @property int $id
 * @property string $size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|RamSize newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RamSize newQuery()
 * @method static \Illuminate\Database\Query\Builder|RamSize onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|RamSize query()
 * @method static \Illuminate\Database\Eloquent\Builder|RamSize whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RamSize whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RamSize whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RamSize whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RamSize whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|RamSize withTrashed()
 * @method static \Illuminate\Database\Query\Builder|RamSize withoutTrashed()
 * @mixin \Eloquent
 */
class RamSize extends Model
{
  use SoftDeletes;

  protected $fillable = ['size'];
  protected $table = 'storage_sizes';
}
