<?php

namespace App\Modules\SuperAdmin\Models;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\ErrLog;
use App\Modules\SuperAdmin\Models\QATest;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Traits\Commentable;
use App\Modules\SuperAdmin\Models\ProductBrand;
use App\Modules\SuperAdmin\Models\ProductCategory;
use App\Modules\SuperAdmin\Models\ProductModelImage;
use App\Modules\SuperAdmin\Models\ProductDescriptionSummary;
use App\Modules\SuperAdmin\Transformers\UserCommentTransformer;
use App\Modules\SuperAdmin\Transformers\ProductModelTransformer;
use App\Modules\SuperAdmin\Http\Validations\CreateProductModelValidation;

/**
 * App\Modules\SuperAdmin\Models\ProductModel
 *
 * @property int $id
 * @property int $product_brand_id
 * @property int $product_category_id
 * @property string $name
 * @property string|null $img_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\UserComment[] $comments
 * @property-read int|null $comments_count
 * @property-read ProductBrand $product_brand
 * @property-read ProductCategory $product_category
 * @property-read ProductDescriptionSummary|null $product_description_summary
 * @property-read \Illuminate\Database\Eloquent\Collection|ProductModelImage[] $product_model_images
 * @property-read int|null $product_model_images_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|QATest[] $qa_tests
 * @property-read int|null $qa_tests_count
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModel whereImgUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModel whereProductBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModel whereProductCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductModel extends Model
{

  use Commentable;

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

  public function product_description_summary()
  {
    return $this->hasOne(ProductDescriptionSummary::class);
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
      // Route::get('{productModel}/images', [self::class, 'getProductModelImages'])->name($gen('models', '.model_images'))->defaults('ex', __e('ss', 'git-branch', true));
      Route::post('{productModel}/images/create', [self::class, 'createProductModelImage'])->name($gen('models', '.create_model_image'))->defaults('ex', __e('ss', 'git-branch', true));
      Route::delete('images/{id}/delete', [self::class, 'deleteProductModelImage'])->name($gen('models', '.delete_model_image'))->defaults('ex', __e('ss', 'git-branch', true));
      Route::post('{productModel}/comment', [self::class, 'commentOnProductModel'])->name($gen('models', '.comment_on_model'))->defaults('ex', __e('ss', null, true));
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
      'productModels' => $productModels,
      'productBrands' => ProductBrand::get(['id', 'name']),
      'productCategories' => ProductCategory::get(['id', 'name']),

    ]);
  }

  public function getProductModelDetails(ProductModel $productModel)
  {
    return Inertia::render('SuperAdmin,ProductModels/Details', [
      'productModel' => function () use ($productModel) {
        return (new ProductModelTransformer)->transformForDetailsPage($productModel->load(
          'product_brand',
          'product_category',
          'product_model_images',
          'qa_tests',
          'product_description_summary',
          'comments'
        ));
      },
      'qaTests' => function () {
        return QATest::all();
      }
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
          'img_url' => compress_image_upload('img', 'product_models_images/', null, 800)['img_url'],
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

    // dd($request->validated());

    try {
      foreach (collect($request->validated())->except('img') as $key => $value) {
        $productModel->$key = $value;
      }

      if ($request->img) {
        $productModel->img_url = compress_image_upload('img', 'product_models_images/', null, 800)['img_url'];
      }

      $productModel->save();

      cache()->flush();

      if ($request->isApi()) {
        return response()->json([], 204);
      }
      return back()->withSuccess('Updated');
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

    if ($request->isApi())
      return response()->json($tests, 201);
    if (empty($tests['attached']) && empty($tests['detached']) && empty($tests['updated'])) {
      return back()->withError('Nothing was updated');
    } else {
      return back()->withSuccess('Product tests were updated successfully');
    }
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

    $img_urls = compress_image_upload('img', 'product_models_images/', 'product_models_images/thumbs/', 800);
    $image = $productModel->product_model_images()->create([
      'img_url' => $img_urls['img_url'],
      'thumb_url' => $img_urls['thumb_url'],
    ]);

    if ($request->isApi()) {
      return response()->json((new ProductModelTransformer)->transformImage($image), 201);
    }

    return back()->withSuccess('Image created');
  }

  public function deleteProductModelImage(Request $request,  $id)
  {
    ProductModelImage::destroy($id);
    if ($request->isApi()) {
      return response()->json([], 204);
    }
    return back()->withSuccess('Deleted');
  }

  public function commentOnProductModel(Request $request, self $productModel)
  {
    if (!$request->comment) {
      return generate_422_error('Provide comment');
    }
    $comment =  $request->user()->comments()->create([
      'subject_id' => $productModel->id,
      'subject_type' => get_class($productModel),
      'comment' => $request->comment
    ]);

    if ($request->isApi())
      return response()->json((new UserCommentTransformer)->detailed($comment), 201);
    return back()->withSuccess('Created');
  }
}
