<?php

namespace App\Modules\SuperAdmin\Models;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Awobaz\Compoships\Compoships;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\ErrLog;
use App\Modules\SuperAdmin\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Models\StorageSize;
use App\Modules\SuperAdmin\Models\ProductBatch;
use App\Modules\SuperAdmin\Models\ProductColor;
use App\Modules\SuperAdmin\Models\ProductGrade;
use App\Modules\SuperAdmin\Models\ProductModel;
use App\Modules\SuperAdmin\Models\ProductSupplier;
use App\Modules\SuperAdmin\Transformers\ProductPriceTransformer;
use App\Modules\SuperAdmin\Http\Validations\CreateProductPriceValidation;


/**
 * App\Modules\SuperAdmin\Models\ProductPrice
 *
 * @property-read \App\Modules\SuperAdmin\Models\ProductBatch $product_batch
 * @property-read \App\Modules\SuperAdmin\Models\ProductColor $product_color
 * @property-read \App\Modules\SuperAdmin\Models\ProductGrade $product_grade
 * @property-read \App\Modules\SuperAdmin\Models\ProductModel $product_model
 * @property-read \App\Modules\SuperAdmin\Models\ProductSupplier $product_supplier
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\Product[] $products
 * @property-read int|null $products_count
 * @property-read \App\Modules\SuperAdmin\Models\StorageSize $storage_size
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductPrice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductPrice newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductPrice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductPrice query()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductPrice withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductPrice withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property int $product_batch_id
 * @property int $product_brand_id
 * @property int $product_model_id
 * @property int $product_color_id
 * @property int $storage_size_id
 * @property int $product_grade_id
 * @property int $product_supplier_id
 * @property float $cost_price
 * @property float|null $proposed_selling_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductPrice whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductPrice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductPrice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductPrice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductPrice whereProductBatchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductPrice whereProductBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductPrice whereProductColorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductPrice whereProductGradeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductPrice whereProductModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductPrice whereProductSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductPrice whereProposedSellingPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductPrice whereStorageSizeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductPrice whereUpdatedAt($value)
 */
class ProductPrice extends Model
{
  use SoftDeletes;
  use Compoships;

  protected $fillable = [
    'product_batch_id',
    'product_color_id',
    'product_grade_id',
    'product_supplier_id',
    'storage_size_id',
    'product_brand_id',
    'product_model_id',
    'cost_price',
    'proposed_selling_price'
  ];

  public function __construct()
  {
    Inertia::setRootView('superadmin::app');
  }

  public function product_batch()
  {
    return $this->belongsTo(ProductBatch::class);
  }

  public function product_model()
  {
    return $this->belongsTo(ProductModel::class);
  }

  public function product_color()
  {
    return $this->belongsTo(ProductColor::class);
  }

  public function product_grade()
  {
    return $this->belongsTo(ProductGrade::class);
  }

  public function product_supplier()
  {
    return $this->belongsTo(ProductSupplier::class);
  }

  public function storage_size()
  {
    return $this->belongsTo(StorageSize::class);
  }

  public function products()
  {
    return $this->hasMany(
      Product::class,
      ['product_brand_id', 'product_batch_id', 'product_model_id', 'product_color_id', 'storage_size_id', 'product_grade_id', 'product_supplier_id'],
      ['product_brand_id', 'product_batch_id', 'product_model_id', 'product_color_id', 'storage_size_id', 'product_grade_id', 'product_supplier_id']
    );
  }

  static function routes()
  {
    Route::group(['prefix' => 'product-prices'], function () {
      $p = function ($name) {
        return 'superadmin.prices.' . $name;
      };
      // Route::get('', [self::class, 'getProductPrices'])->name($p('view_prices', null))->defaults('ex', __e('ss', 'dollar-sign', false));
      Route::get('/{productBatch:batch_number}', [self::class, 'getProductPricesByBatch'])->name($p('by_batch', null))->defaults('ex', __e('ss', 'dollar-sign', true));
      Route::get('{productBatch:batch_number}/create', [self::class, 'createProductPricePage'])->name($p('create_page'))->defaults('ex', __e('ss', 'dollar-sign', true));
      Route::post('create', [self::class, 'createProductPrice'])->name($p('create'))->defaults('ex', __e('ss', 'dollar-sign', true));
      Route::put('{price}/edit', [self::class, 'editProductPrice'])->name($p('edit'))->defaults('ex', __e('ss', 'dollar-sign', true));
    });
  }

  public function getProductPrices()
  {
    return response()->json((new ProductPriceTransformer)->collectionTransformer(
      self::with('product_color', 'product_grade', 'product_model', 'product_supplier', 'storage_size', 'product_batch')->get(),
      'basic'
    ), 200);
  }

  public function getProductPricesByBatch(Request $request, ProductBatch $productBatch)
  {
    if ($request->isApi()) {
      return response()->json((new ProductPriceTransformer)->collectionTransformer(
        $productBatch->productPrices->load('product_color', 'product_grade', 'product_model', 'product_supplier', 'storage_size', 'product_batch')->get(),
        'basic'
      ), 200);
    } else {
      return Inertia::render('Products/Prices');
    }
  }

  public function createProductPricePage(Request $request, ProductBatch $productBatch)
  {
    return Inertia::render('Products/CreatePrice', [
      'batch' => $productBatch
    ]);
  }

  public function createProductPrice(CreateProductPriceValidation $request)
  {
    try {
      $product_price = self::create($request->validated());

      return response()->json((new ProductPriceTransformer)->basic(
        $product_price->load('product_color', 'product_grade', 'product_model', 'product_supplier', 'storage_size', 'product_batch')
      ), 201);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Product price not created');
      return response()->json(['err' => 'Product price not created'], 500);
    }
  }

  public function editProductPrice(CreateProductPriceValidation $request, self $product_price)
  {

    try {
      foreach ($request->validated() as $key => $value) {
        $product_price->$key = $value;
      }

      $product_price->save();

      return response()->json([], 204);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Product price not updated');
      return response()->json(['err' => 'Product price not updated'], 500);
    }
  }
}
