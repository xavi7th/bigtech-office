<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\ErrLog;
use App\Modules\SuperAdmin\Models\QATest;
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
 */
class ProductModel extends Model
{
  protected $fillable = [
    'name', 'product_brand_id', 'product_category_id', 'img_url'
  ];

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

  public static function routes()
  {
    Route::group(['prefix' => 'product-models'], function () {
      $gen = function ($namespace, $name = null) {
        return 'superadmin.product_' . $namespace . $name;
      };
      Route::get('', [self::class, 'getProductModels'])->name($gen('models'))->defaults('ex', __e('git-branch', false));
      Route::get('detailed', [self::class, 'getProductFullModels'])->name($gen('models', '.view_detailed_models'))->defaults('ex', __e('git-branch', false));
      Route::post('create', [self::class, 'createProductModel'])->name($gen('models', '.create_product_model'))->defaults('ex', __e('git-branch', true));
      Route::put('{model}/edit', [self::class, 'editProductModel'])->name($gen('models', '.edit_product_model'))->defaults('ex', __e('git-branch', true));
      Route::get('{model}/qa-tests', [self::class, 'getProductModelQATests'])->name($gen('models', '.model_qa_tests'))->defaults('ex', __e('git-branch', true));
      Route::put('{model}/qa-tests', [self::class, 'updateProductModelQATests'])->name($gen('models', '.update_model_qa_tests'))->defaults('ex', __e('git-branch', true));
      Route::get('{model}/images', [self::class, 'getProductModelImages'])->name($gen('models', '.model_images'))->defaults('ex', __e('git-branch', true));
      Route::post('{model}/images/create', [self::class, 'createProductModelImage'])->name($gen('models', '.create_model_image'))->defaults('ex', __e('git-branch', true));
      Route::delete('images/{image}/delete', [self::class, 'deleteProductModelImage'])->name($gen('models', '.delete_model_image'))->defaults('ex', __e('git-branch', true));
    });
  }

  public function getProductModels()
  {
    return response()->json((new ProductModelTransformer)->collectionTransformer(self::all(), 'basic'), 200);
  }

  public function getProductFullModels()
  {
    return response()->json((new ProductModelTransformer)->collectionTransformer(self::with('product_category', 'product_brand')->get(), 'transformWithCategoryAndBrand'), 200);
  }

  public function createProductModel(CreateProductModelValidation $request)
  {

    try {
      $product_model = self::create([
        'name' => $request->name,
        'product_brand_id' => $request->product_brand_id,
        'product_category_id' => $request->product_category_id,
        'img_url' => $request->img_url,
      ]);

      return response()->json((new ProductModelTransformer)->basic($product_model), 201);
    } catch (\Throwable $th) {
      dd($th);
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Product model not created');
      return response()->json(['err' => 'Product model not created'], 500);
    }
  }


  public function editProductModel(CreateProductModelValidation $request, self $model)
  {

    try {
      foreach ($request->validated() as $key => $value) {
        $model->$key = $value;
      }

      $model->save();

      return response()->json([], 204);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Model not updated');
      return response()->json(['err' => 'Model not updated'], 500);
    }
  }

  public function getProductModelQATests(Request $request, self $model)
  {
    return response()->json((new ProductModelTransformer)->collectionTransformer($model->qa_tests, 'transformQATest'), 200);
  }

  public function updateProductModelQATests(Request $request, self $model)
  {
    if (!$request->qa_tests) {
      return generate_422_error('Specify valid QA tests');
    }

    $tests = $model->qa_tests()->sync($request->qa_tests);

    return response()->json($tests, 201);
  }

  public function getProductModelImages(Request $request, self $model)
  {
    return response()->json((new ProductModelTransformer)->collectionTransformer($model->product_model_images, 'transformImage'), 200);
  }

  public function createProductModelImage(Request $request, self $model)
  {
    if (!$request->img) {
      return generate_422_error('Specify valid image');
    }

    $image = $model->product_model_images()->create([
      'img_url' => $request->img
    ]);

    return response()->json((new ProductModelTransformer)->transformImage($image), 201);
  }

  public function deleteProductModelImage(Request $request, ProductModelImage $model_image)
  {

    return response()->json($model_image->delete(), 204);
  }
}
