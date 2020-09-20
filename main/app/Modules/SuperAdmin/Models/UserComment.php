<?php

namespace App\Modules\SuperAdmin\Models;

use Inertia\Inertia;
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
 * @property int $id
 * @property int $user_id
 * @property string $user_type
 * @property int $subject_id
 * @property string $subject_type
 * @property string $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read Model|\Eloquent $subject
 * @property-read Model|\Eloquent $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserComment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserComment query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserComment whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserComment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserComment whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserComment whereSubjectType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserComment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserComment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserComment whereUserType($value)
 * @mixin \Eloquent
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
    $userComments = ((new UserCommentTransformer)->adminViewAllComments(self::with('user', 'subject')->get(), 'detailed'));

    if ($request->isApi()) return response()->json($userComments, 200);
    return Inertia::render('SuperAdmin,Miscellaneous/ViewUsersComments', compact('userComments'));
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
