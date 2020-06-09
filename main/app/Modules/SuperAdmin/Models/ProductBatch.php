<?php

namespace App\Modules\SuperAdmin\Models;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\ErrLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Models\UserComment;
use App\Modules\SuperAdmin\Transformers\UserCommentTransformer;
use App\Modules\SuperAdmin\Transformers\ProductBatchTransformer;

/**
 * App\Modules\SuperAdmin\Models\ProductBatch
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\UserComment[] $comments
 * @property-read int|null $comments_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductBatch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductBatch newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductBatch onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductBatch query()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductBatch withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductBatch withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string $batch_number
 * @property \Illuminate\Support\Carbon $order_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductBatch whereBatchNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductBatch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductBatch whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductBatch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductBatch whereOrderDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductBatch whereUpdatedAt($value)
 */
class ProductBatch extends Model
{
  use SoftDeletes;

  protected $fillable = ['order_date', 'batch_number'];

  protected $dates = ['order_date'];


  public function comments()
  {
    return $this->morphMany(UserComment::class, 'subject')->latest();
  }

  public function primary_identifier(): string
  {
    return 'batch number: ' . $this->batch_number;
  }

  static function local_supplied_id(): int
  {
    return self::where('batch_number', 'LOCAL-SUPPLIER')->first()->id;
  }

  public static function routes()
  {
    Route::group(['prefix' => 'product-batches'], function () {
      $gen = function ($namespace, $name = null) {
        return 'superadmin.product_' . $namespace . $name;
      };
      Route::get('', [self::class, 'getProductBatches'])->name($gen('batches', null))->defaults('ex', __e('package', false));
      Route::post('create', [self::class, 'createProductBatch'])->name($gen('batches', 'create_batch'))->defaults('ex', __e('package', true));
      Route::post('{batch}/comment', [self::class, 'commentOnProductBatch'])->name($gen('batches', 'create_comment'))->defaults('ex', __e('package', true));
    });
  }

  public function getProductBatches()
  {
    return response()->json((new ProductBatchTransformer)->collectionTransformer(self::all(), 'basic'), 200);
  }

  public function createProductBatch(Request $request)
  {
    if (!$request->batch_number && !filter_var($request->auto_generate, FILTER_VALIDATE_BOOLEAN)) {
      return generate_422_error('Enter a batch number or select auto generate');
    }

    if (!$request->order_date) {
      return generate_422_error('Select a date for the order batch');
    }

    if (filter_var($request->auto_generate, FILTER_VALIDATE_BOOLEAN)) {
      $batch_number = unique_random('product_batches', 'batch_number', null, 32);
    } else {
      $batch_number = $request->batch_number;
    }

    try {
      $product_batch = self::create([
        'batch_number' => $batch_number,
        'order_date' => Carbon::parse($request->order_date),
      ]);

      return response()->json((new ProductBatchTransformer)->basic($product_batch), 201);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Product supplier not created');
      return response()->json(['err' => 'Product supplier not created'], 500);
    }
  }

  public function commentOnProductBatch(Request $request, self $product_batch)
  {
    if (!$request->comment) {
      return generate_422_error('Make a comment');
    }

    $comment =  auth()->user()->comments()->create([
      'subject_id' => $product_batch->id,
      'subject_type' => get_class($product_batch),
      'comment' => $request->comment
    ]);

    return response()->json((new UserCommentTransformer)->basic($comment), 201);
  }
}
