<?php

namespace App\Modules\SuperAdmin\Models;

use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\ErrLog;
use App\Modules\SuperAdmin\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Models\UserComment;
use App\Modules\SuperAdmin\Models\ProductPrice;
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\Product[] $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\ProductPrice[] $productPrices
 * @property-read int|null $product_prices_count
 */
class ProductBatch extends Model
{
  use SoftDeletes;

  protected $fillable = ['order_date', 'batch_number'];

  protected $dates = ['order_date'];

  public function __construct()
  {
    Inertia::setRootView('superadmin::app');
  }

  public function comments()
  {
    return $this->morphMany(UserComment::class, 'subject')->latest();
  }

  public function products()
  {
    return $this->hasMany(Product::class);
  }

  public function productPrices()
  {
    return $this->hasMany(ProductPrice::class);
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
      $p = function ($name) {
        return 'superadmin.products.' . $name;
      };
      Route::get('', [self::class, 'getProductBatches'])->name($p('batches'))->defaults('ex', __e('ss', 'package', false));
      Route::post('create', [self::class, 'createProductBatch'])->name($p('create_batch'))->defaults('ex', __e('ss', 'package', true));
      Route::post('{batch}/comment', [self::class, 'commentOnProductBatch'])->name($p('create_batch_comment'))->defaults('ex', __e('ss', 'package', true));
      Route::get('{productBatch}/products', [self::class, 'getBatchProducts'])->name($p('by_batch'))->defaults('ex', __e('ss', 'package', true));
    });
  }

  public function getProductBatches(Request $request)
  {
    $productBatches = (new ProductBatchTransformer)->collectionTransformer(self::all(), 'basic');
    if ($request->isApi()) {
      return response()->json($productBatches, 200);
    } else {
      return Inertia::render('Products/ManageBatches', [
        'batches' => $productBatches
      ]);
    }
  }

  public function getBatchProducts(Request $request, ProductBatch $productBatch)
  {
    $batchProducts = $productBatch->products;
    if ($request->isApi()) {
      return response()->json($batchProducts, 200);
    } else {
      return Inertia::render('Products/BatchProducts', [
        'products' => $batchProducts
      ]);
    }
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

  public function commentOnProductBatch(Request $request, ProductBatch $productBatch)
  {
    if (!$request->comment) {
      return generate_422_error('Make a comment');
    }

    $comment =  auth()->user()->comments()->create([
      'subject_id' => $productBatch->id,
      'subject_type' => get_class($productBatch),
      'comment' => $request->comment
    ]);

    return response()->json((new UserCommentTransformer)->basic($comment), 201);
  }
}
