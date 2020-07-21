<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Http\Request;
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

  static function routes()
  {
    Route::group(['prefix' => 'user-comments', 'namespace' => '\App\Modules\Admin\Models'], function () {
      $others = function ($name) {
        return 'superadmin.' . $name;
      };
      Route::get('', [self::class, 'getUserComments'])->name($others('user_comments'))->defaults('ex', __e('ss', 'message-circle', false));
      Route::get('product-batch/{batch}', [self::class, 'getProductBatchComments'])->name($others('user_comments.batch'))->defaults('ex', __e('ss', 'message-circle', true));
      Route::get('product/{product}', [self::class, 'getProductComments'])->name($others('user_comments.product'))->defaults('ex', __e('ss', 'message-circle', true));
    });
  }

  public function getUserComments(Request $request)
  {
    $userComments = (new UserCommentTransformer)->collectionTransformer(self::with('user', 'subject')->get(), 'detailed');
    if ($request->isApi())
      return response()->json($userComments, 200);

    return Inertia::render('SuperAdmin,Miscellaneous/ManageColors', compact('userComments'));
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
