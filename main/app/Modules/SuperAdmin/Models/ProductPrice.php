<?php

namespace App\Modules\SuperAdmin\Models;

use App\BaseModel;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Awobaz\Compoships\Compoships;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\ErrLog;
use App\Modules\SuperAdmin\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Models\StorageSize;
use App\Modules\SuperAdmin\Models\ProductBatch;
use App\Modules\SuperAdmin\Models\ProductBrand;
use App\Modules\SuperAdmin\Models\ProductColor;
use App\Modules\SuperAdmin\Models\ProductGrade;
use App\Modules\SuperAdmin\Models\ProductModel;
use App\Modules\SuperAdmin\Models\ProductSupplier;
use App\Modules\SuperAdmin\Transformers\StorageSizeTransformer;
use App\Modules\SuperAdmin\Transformers\ProductBrandTransformer;
use App\Modules\SuperAdmin\Transformers\ProductColorTransformer;
use App\Modules\SuperAdmin\Transformers\ProductGradeTransformer;
use App\Modules\SuperAdmin\Transformers\ProductModelTransformer;
use App\Modules\SuperAdmin\Transformers\ProductPriceTransformer;
use App\Modules\SuperAdmin\Transformers\ProductSupplierTransformer;
use App\Modules\SuperAdmin\Http\Validations\CreateProductPriceValidation;

/**
 * App\Modules\SuperAdmin\Models\ProductPrice
 *
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
 * @property-read ProductBatch $product_batch
 * @property-read ProductColor $product_color
 * @property-read ProductGrade $product_grade
 * @property-read ProductModel $product_model
 * @property-read ProductSupplier $product_supplier
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $products
 * @property-read int|null $products_count
 * @property-read StorageSize $storage_size
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice newQuery()
 * @method static \Illuminate\Database\Query\Builder|ProductPrice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereProductBatchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereProductBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereProductColorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereProductGradeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereProductModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereProductSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereProposedSellingPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereStorageSizeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ProductPrice withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ProductPrice withoutTrashed()
 * @mixin \Eloquent
 */
class ProductPrice extends BaseModel
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

  static function accountantRoutes()
  {
    Route::group(['prefix' => 'product-prices'], function () {
      $p = function ($name) {
        return 'accountant.prices.' . $name;
      };
      // Route::get('', [self::class, 'getProductPrices'])->name($p('view_prices', null))->defaults('ex', __e('ss', 'dollar-sign', false));
      Route::post('create', [self::class, 'createProductPrice'])->name($p('create'))->defaults('ex', __e('ss', 'dollar-sign', true));
      Route::get('{productPrice}/edit', [self::class, 'showEditProductPricePage'])->name($p('edit_page'))->defaults('ex', __e('ss', 'dollar-sign', true));
      Route::put('{productPrice}/edit', [self::class, 'editProductPrice'])->name($p('edit'))->defaults('ex', __e('ss', 'dollar-sign', true));
    });
  }

  public function getProductPrices()
  {
    return response()->json((new ProductPriceTransformer)->collectionTransformer(
      self::with('product_color', 'product_grade', 'product_model', 'product_supplier', 'storage_size', 'product_batch')->get(),
      'basic'
    ), 200);
  }

  public function createProductPrice(CreateProductPriceValidation $request)
  {
    try {
      $product_price = self::create($request->validated());

      if ($request->isApi()) return response()->json((new ProductPriceTransformer)->basic(
        $product_price->load('product_color', 'product_grade', 'product_model', 'product_supplier', 'storage_size', 'product_batch')
      ), 201);

      return back()->withFlash(['success'=>'Product Price created for this batch']);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Product price not created');

      if ($th->getCode() == 23000) {
        if ($request->isApi()) return response()->json(['err' => 'This item´s price has been created for this batch already. If you want to make corrections, edit it instead.'], 500);
        return back()->withFlash(['error'=>['This item´s price has been created for this batch already. If you want to make corrections, edit it instead.']]);
      }

      if ($request->isApi()) return response()->json(['err' => 'Product price not created'], 500);
      return back()->withFlash(['error'=>['Product price not created']]);
    }
  }

  public function showEditProductPricePage(Request $request, self $productPrice)
  {

    // dd($productPrice);

    return Inertia::render('SuperAdmin,Products/EditPrice', [
      'price' => $productPrice->load('product_batch'),
      'models' => fn () => Cache::rememberForever('models', fn () => (new ProductModelTransformer)->collectionTransformer(ProductModel::all(), 'basic')),
      'brands' => fn () => Cache::rememberForever('brands', fn () => (new ProductBrandTransformer)->collectionTransformer(ProductBrand::all(), 'basic')),
      'colors' => fn () => Cache::rememberForever('colors', fn () => (new ProductColorTransformer)->collectionTransformer(ProductColor::all(), 'basic')),
      'grades' => fn () => Cache::rememberForever('grades', fn () => (new ProductGradeTransformer)->collectionTransformer(ProductGrade::all(), 'basic')),
      'suppliers' => fn () => Cache::rememberForever('suppliers', fn () => (new ProductSupplierTransformer)->collectionTransformer(ProductSupplier::all(), 'basic')),
      'storage_sizes' => fn () => Cache::rememberForever('storage_sizes', fn () => (new StorageSizeTransformer)->collectionTransformer(StorageSize::all(), 'basic')),
    ]);
  }


  public function editProductPrice(CreateProductPriceValidation $request, self $productPrice)
  {
    try {
      foreach ($request->validated() as $key => $value) {
        $productPrice->$key = $value;
      }

      $productPrice->save();

      if ($request->isApi()) return response()->json([], 204);
      return back()->withFlash(['success'=>'Updated successfully']);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Batch price not updated');
      if ($request->isApi()) return response()->json(['err' => 'Batch price not updated'], 500);
      return back()->withFlash(['error'=>['Batch Price not updated']]);
    }
  }


  protected static function boot()
  {
    parent::boot();

    static::saved(function ($product) {
      Cache::forget('products');
      Cache::forget('batches');
    });
  }
}
