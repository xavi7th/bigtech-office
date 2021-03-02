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


  static function superAdminRoutes()
  {
    Route::group(['prefix' => 'user-comments'], function () {
      Route::name('user_comments.')->group(function () {
        Route::delete('{userComment}/delete', [self::class, 'deleteUserComments'])->name('delete');
      });
    });
  }



  static function routes()
  {
    Route::name('user_comments')->prefix('user-comments')->group(function () {
      Route::get('', [self::class, 'getUserComments'])->name('')->defaults('ex', __e('ss', 'message-circle', false));
      Route::get('product-batch/{batch}', [self::class, 'getProductBatchComments'])->name('.batch')->defaults('ex', __e('ss', 'message-circle', true));
      Route::get('product/{product}', [self::class, 'getProductComments'])->name('.product')->defaults('ex', __e('ss', 'message-circle', true));
    });
  }

  public function getUserComments(Request $request)
  {
    $userComments = ((new UserCommentTransformer)->adminViewAllComments(self::with('user', 'subject')->get(), 'detailed'));

    if ($request->isApi()) return response()->json($userComments, 200);
    return Inertia::render('SuperAdmin,Miscellaneous/ViewUsersComments', compact('userComments'));
  }

  public function deleteUserComments(Request $request, self $userComment)
  {
    $userComment->delete();

    return back()->withlash(['success'=>'Comment deleted']);
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
