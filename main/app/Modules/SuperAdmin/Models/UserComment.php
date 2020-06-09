<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\ProductBatch;
use App\Modules\SuperAdmin\Transformers\ProductTransformer;
use App\Modules\SuperAdmin\Transformers\UserCommentTransformer;
use App\Modules\SuperAdmin\Transformers\ProductBatchTransformer;

/**
 * App\Modules\SuperAdmin\Models\UserComment
 *
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $subject
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\UserComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\UserComment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\UserComment query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property string $user_type
 * @property int $subject_id
 * @property string $subject_type
 * @property string $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\UserComment whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\UserComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\UserComment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\UserComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\UserComment whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\UserComment whereSubjectType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\UserComment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\UserComment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\UserComment whereUserType($value)
 */
class UserComment extends Model
{
  protected $fillable = [
    'subject_id',
    'subject_type',
    'comment'
  ];


  public function user()
  {
    return $this->morphTo();
  }


  public function subject()
  {
    return $this->morphTo();
  }

  static function apiRoutes()
  {
    Route::group(['prefix' => 'user-comments', 'namespace' => '\App\Modules\Admin\Models'], function () {
      Route::get('', 'UserComment@getUserComments')->middleware('auth:admin_api');
      Route::get('product_batch/{product_batch}', 'UserComment@getProductBatchComments')->middleware('auth:admin_api');
      Route::get('product/{product}', 'UserComment@getProductComments')->middleware('auth:admin_api');
    });
  }

  public function getUserComments()
  {
    return response()->json((new UserCommentTransformer)->collectionTransformer(self::with('user', 'subject')->get(), 'detailed'), 200);
  }

  public function getProductBatchComments(ProductBatch $product_batch)
  {
    return response()->json((new ProductBatchTransformer)->transformWithComment($product_batch->load('comments')), 200);
  }

  public function getProductComments(Product $product)
  {
    return response()->json((new ProductTransformer)->transformWithComment($product->load('comments')), 200);
  }
}
