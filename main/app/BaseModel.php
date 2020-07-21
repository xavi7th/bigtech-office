<?php

namespace App;

use Inertia\Inertia;
use Illuminate\Database\Eloquent\Model;

/**
 * App\BaseModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel query()
 * @mixin \Eloquent
 */
class BaseModel extends Model
{
  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    if (routeHasRootNamespace('appuser.')) {
      Inertia::setRootView('appuser::app');
    } elseif (routeHasRootNamespace('admin.')) {
      Inertia::setRootView('admin::app');
    }
  }
}
