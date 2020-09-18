<?php

namespace App\Modules\SuperAdmin\Models;

use App\BaseModel;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\ErrLog;
use App\Modules\SuperAdmin\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Traits\Commentable;
use App\Modules\SuperAdmin\Models\ProductModel;
use App\Modules\SuperAdmin\Models\ProductPrice;
use App\Modules\SuperAdmin\Transformers\UserCommentTransformer;
use App\Modules\SuperAdmin\Transformers\ProductBatchTransformer;
use App\Modules\SuperAdmin\Transformers\ProductBrandTransformer;
use App\Modules\SuperAdmin\Transformers\ProductColorTransformer;
use App\Modules\SuperAdmin\Transformers\ProductGradeTransformer;
use App\Modules\SuperAdmin\Transformers\ProductModelTransformer;
use App\Modules\SuperAdmin\Transformers\ProductSupplierTransformer;
use App\Modules\SuperAdmin\Transformers\StorageSizeTransformer;
use Cache;

/**
 * App\Modules\SuperAdmin\Models\ProductBatch
 *
 * @property int $id
 * @property string $batch_number
 * @property \Illuminate\Support\Carbon $order_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\UserComment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|ProductPrice[] $productPrices
 * @property-read int|null $product_prices_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|ProductBatch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductBatch newQuery()
 * @method static \Illuminate\Database\Query\Builder|ProductBatch onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductBatch query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductBatch whereBatchNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductBatch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductBatch whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductBatch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductBatch whereOrderDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductBatch whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ProductBatch withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ProductBatch withoutTrashed()
 * @mixin \Eloquent
 */
class ProductBatch extends BaseModel
{
  use SoftDeletes, Commentable;

  protected $fillable = ['order_date', 'batch_number'];

  protected $dates = ['order_date'];

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
      Route::post('{productBatch}/comment', [self::class, 'commentOnProductBatch'])->name($p('create_batch_comment'))->defaults('ex', __e('ss', 'package', true));
      Route::get('{productBatch:batch_number}/products', [self::class, 'getBatchProducts'])->name($p('by_batch'))->defaults('ex', __e('ss', 'package', true));
      Route::get('{productBatch:batch_number}/price/create', [self::class, 'createProductPricePage'])->name($p('create_batch_price'))->defaults('ex', __e('ss', 'package', true));
      Route::get('{productBatch:batch_number}/prices', [self::class, 'getBatchPrices'])->name($p('prices_by_batch'))->defaults('ex', __e('ss', 'package', true));
    });
  }

  public function getProductBatches(Request $request)
  {
    $productBatches = (new ProductBatchTransformer)->collectionTransformer(self::all(), 'transformWithProductSummaries');

    if ($request->isApi()) return response()->json($productBatches, 200);
    return Inertia::render('SuperAdmin,Products/ManageBatches', [
      'batches' => $productBatches
    ]);
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
      ErrLog::notifyAdmin($request->user(), $th, 'Product supplier not created');
      return response()->json(['err' => 'Product supplier not created'], 500);
    }
  }

  public function commentOnProductBatch(Request $request, ProductBatch $productBatch)
  {
    if (!$request->comment) {
      return generate_422_error('Make a comment');
    }

    $comment =  $request->user()->comments()->create([
      'subject_id' => $productBatch->id,
      'subject_type' => get_class($productBatch),
      'comment' => $request->comment
    ]);

    return response()->json((new UserCommentTransformer)->basic($comment), 201);
  }

  public function getBatchProducts(Request $request, ProductBatch $productBatch)
  {
    $batchWithProducts = (new ProductBatchTransformer)->transformWithBasicProductDetails($productBatch->load('products', 'products.product_color', 'products.product_grade', 'products.product_model', 'products.product_supplier', 'products.storage_size', 'products.product_batch'));

    if ($request->isApi()) return response()->json($batchWithProducts, 200);
    return Inertia::render('SuperAdmin,Products/BatchProducts', compact('batchWithProducts'));
  }

  public function createProductPricePage(Request $request, ProductBatch $productBatch)
  {
    return Inertia::render('SuperAdmin,Products/CreatePrice', [
      'batch' => $productBatch,
      'models' => fn () => Cache::rememberForever('models', fn () => (new ProductModelTransformer)->collectionTransformer(ProductModel::all(), 'basic')),
      'brands' => fn () => Cache::rememberForever('brands', fn () => (new ProductBrandTransformer)->collectionTransformer(ProductBrand::all(), 'basic')),
      'colors' => fn () => Cache::rememberForever('colors', fn () => (new ProductColorTransformer)->collectionTransformer(ProductColor::all(), 'basic')),
      'grades' => fn () => Cache::rememberForever('grades', fn () => (new ProductGradeTransformer)->collectionTransformer(ProductGrade::all(), 'basic')),
      'suppliers' => fn () => Cache::rememberForever('suppliers', fn () => (new ProductSupplierTransformer)->collectionTransformer(ProductSupplier::all(), 'basic')),
      'storage_sizes' => fn () => Cache::rememberForever('storage_sizes', fn () => (new StorageSizeTransformer)->collectionTransformer(StorageSize::all(), 'basic')),
    ]);
  }


  public function getBatchPrices(Request $request, ProductBatch $productBatch)
  {
    // $productBatch->products()->with('product_color', 'product_grade', 'product_model', 'product_supplier', 'storage_size', 'product_batch')->get()
    $productBatchWithPriceDetails = (new ProductBatchTransformer)->transformWithPriceDetails($productBatch->load('productPrices', 'productPrices.product_color', 'productPrices.product_grade', 'productPrices.product_model', 'productPrices.product_supplier', 'productPrices.storage_size', 'productPrices.product_batch'));

    if ($request->isApi()) return response()->json($productBatchWithPriceDetails, 200);
    return Inertia::render('SuperAdmin,Products/Prices', compact('productBatchWithPriceDetails', 'productBatch'));
  }
}
