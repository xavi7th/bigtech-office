<?php

namespace App\Modules\SuperAdmin\Models;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\ErrLog;
use App\Modules\SuperAdmin\Models\QATest;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\ProductBrand;
use App\Modules\SuperAdmin\Models\ProductCategory;
use App\Modules\SuperAdmin\Models\ProductModelImage;
use App\Modules\SuperAdmin\Transformers\ProductModelTransformer;
use App\Modules\SuperAdmin\Http\Validations\CreateProductModelValidation;

/**
 * App\Modules\SuperAdmin\Models\ProductModel
 *
 * @property-read \App\Modules\SuperAdmin\Models\ProductBrand $product_brand
 * @property-read \App\Modules\SuperAdmin\Models\ProductCategory $product_category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\ProductModelImage[] $product_model_images
 * @property-read int|null $product_model_images_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\QATest[] $qa_tests
 * @property-read int|null $qa_tests_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductModel query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $product_brand_id
 * @property int $product_category_id
 * @property string $name
 * @property string|null $img_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductModel whereImgUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductModel whereProductBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductModel whereProductCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductModel whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\Product[] $products
 * @property-read int|null $products_count
 */
class ProductModel extends Model
{
  protected $fillable = [
    'name', 'product_brand_id', 'product_category_id', 'img_url'
  ];
  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    //Helper function
    if (routeHasRootNamespace('appuser.')) {
      Inertia::setRootView('appuser::app');
    } elseif (routeHasRootNamespace('superuser.')) {
      Inertia::setRootView('superuser::app');
    }
  }

  public function qa_tests()
  {
    return $this->belongsToMany(QATest::class, 'product_model_qa_test', 'product_model_id', 'qa_test_id');
  }

  public function product_category()
  {
    return $this->belongsTo(ProductCategory::class);
  }

  public function product_model_images()
  {
    return $this->hasMany(ProductModelImage::class);
  }

  public function product_brand()
  {
    return $this->belongsTo(ProductBrand::class);
  }

  public function products()
  {
    return $this->hasMany(Product::class);
  }

  public static function routes()
  {
    Route::group(['prefix' => 'product-models'], function () {
      $gen = function ($namespace, $name = null) {
        return 'superadmin.product_' . $namespace . $name;
      };
      Route::get('', [self::class, 'getProductModels'])->name($gen('models'))->defaults('ex', __e('ss', 'git-branch', false));
      Route::match(['post', 'get'], 'create', [self::class, 'createProductModel'])->name($gen('models', '.create_product_model'))->defaults('ex', __e('ss', 'git-branch', true));
      Route::get('{productModel}', [self::class, 'getProductModelDetails'])->name($gen('models', '.details'))->defaults('ex', __e('ss', 'git-branch', true));
      Route::put('{productModel}/edit', [self::class, 'editProductModel'])->name($gen('models', '.edit_product_model'))->defaults('ex', __e('ss', 'git-branch', true));
      Route::get('{productModel}/qa-tests', [self::class, 'getProductModelQATests'])->name($gen('models', '.model_qa_tests'))->defaults('ex', __e('ss', 'git-branch', true));
      Route::put('{productModel}/qa-tests', [self::class, 'updateProductModelQATests'])->name($gen('models', '.update_model_qa_tests'))->defaults('ex', __e('ss', 'git-branch', true));
      Route::get('{productModel}/images', [self::class, 'getProductModelImages'])->name($gen('models', '.model_images'))->defaults('ex', __e('ss', 'git-branch', true));
      Route::post('{productModel}/images/create', [self::class, 'createProductModelImage'])->name($gen('models', '.create_model_image'))->defaults('ex', __e('ss', 'git-branch', true));
      Route::delete('images/{image}/delete', [self::class, 'deleteProductModelImage'])->name($gen('models', '.delete_model_image'))->defaults('ex', __e('ss', 'git-branch', true));
    });
  }

  public function getProductModels(Request $request)
  {
    $productModels =  cache()->remember('models', config('cache.product_models_cache_duration'), function () {
      return (new ProductModelTransformer)->collectionTransformer(self::withCount('products')->with('product_category', 'product_brand')->get(), 'transformWithCategoryAndBrand');
    });

    if ($request->isApi()) {
      return response()->json($productModels, 200);
    }
    return Inertia::render('SuperAdmin,ProductModels/List', [
      'productModels' => $productModels
    ]);
  }

  public function getProductModelDetails(ProductModel $productModel)
  {
    return Inertia::render('SuperAdmin,ProductModels/Details', [
      'details' => [
        'images' => (new ProductModelTransformer)->collectionTransformer($productModel->product_model_images, 'transformImage'),
        'qa_tests' => (new ProductModelTransformer)->collectionTransformer($productModel->qa_tests, 'transformQATest'),
      ]
    ]);
  }

  public function createProductModel(CreateProductModelValidation $request)
  {
    if ($request->isMethod('GET')) {
      if ($request->isApi()) {
        return abort(404);
      }
      return Inertia::render('SuperAdmin,ProductModels/Create', [
        'productBrands' => ProductBrand::get(['id', 'name']),
        'productCategories' => ProductCategory::get(['id', 'name']),
      ]);
    } else {
      // dd(compress_image_upload('img', 'product_models_images/', 'product_models_images/thumbs/', 800));
      cache()->flush();
      try {
        $product_model = self::create([
          'name' => $request->name,
          'product_brand_id' => $request->product_brand_id,
          'product_category_id' => $request->product_category_id,
          'img_url' => compress_image_upload('img', 'product_models_images/', 'product_models_images/thumbs/', 800)['img_url'],
        ]);
        if ($request->isApi()) {
          # code...
          return response()->json((new ProductModelTransformer)->basic($product_model), 201);
        } else return back()->withSuccess('New product model created. Add some images to it');
      } catch (\Throwable $th) {
        dd($th);
        ErrLog::notifyAdmin($request->user(), $th, 'Product model not created');
        return response()->json(['err' => 'Product model not created'], 500);
      }
    }
  }


  public function editProductModel(CreateProductModelValidation $request, self $productModel)
  {

    try {
      foreach ($request->validated() as $key => $value) {
        $productModel->$key = $value;
      }

      $productModel->save();

      return response()->json([], 204);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Model not updated');
      return response()->json(['err' => 'Model not updated'], 500);
    }
  }

  public function getProductModelQATests(Request $request, self $productModel)
  {
    return response()->json((new ProductModelTransformer)->collectionTransformer($productModel->qa_tests, 'transformQATest'), 200);
  }

  public function updateProductModelQATests(Request $request, self $productModel)
  {
    if (!$request->qa_tests) {
      return generate_422_error('Specify valid QA tests');
    }

    $tests = $productModel->qa_tests()->sync($request->qa_tests);

    return response()->json($tests, 201);
  }

  public function getProductModelImages(Request $request, self $productModel)
  {
    return response()->json((new ProductModelTransformer)->collectionTransformer($productModel->product_model_images, 'transformImage'), 200);
  }

  public function createProductModelImage(Request $request, self $productModel)
  {
    if (!$request->img) {
      return generate_422_error('Specify valid image');
    }

    $image = $productModel->product_model_images()->create([
      'img_url' => $request->img
    ]);

    return response()->json((new ProductModelTransformer)->transformImage($image), 201);
  }

  public function deleteProductModelImage(Request $request, ProductModelImage $model_image)
  {

    return response()->json($model_image->delete(), 204);
  }
}
