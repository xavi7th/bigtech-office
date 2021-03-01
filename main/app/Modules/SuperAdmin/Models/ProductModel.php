<?php

namespace App\Modules\SuperAdmin\Models;

use App\BaseModel;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\ErrLog;
use App\Modules\SuperAdmin\Models\QATest;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Traits\Commentable;
use App\Modules\SuperAdmin\Models\ProductBrand;
use App\Modules\SuperAdmin\Models\ProductCategory;
use App\Modules\SuperAdmin\Models\ProductModelImage;
use App\Modules\SuperAdmin\Models\ProductDescriptionSummary;
use App\Modules\SuperAdmin\Transformers\UserCommentTransformer;
use App\Modules\SuperAdmin\Transformers\ProductBrandTransformer;
use App\Modules\SuperAdmin\Transformers\ProductModelTransformer;
use App\Modules\SuperAdmin\Transformers\ProductCategoryTransformer;
use App\Modules\SuperAdmin\Http\Validations\CreateProductModelValidation;

class ProductModel extends BaseModel
{

  use Commentable;

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

  public function products()
  {
    return $this->hasMany(Product::class);
  }

  public function product_description_summary()
  {
    return $this->hasOne(ProductDescriptionSummary::class);
  }

  public function primary_identifier(): string
  {
    return 'product model: ' . $this->name;
  }

  public function getImgThumbUrlAttribute(): string
  {
    return Str::of($this->img_url)->replace(Str::of($this->img_url)->dirname(), Str::of($this->img_url)->dirname() . '/thumb');
  }

  public static function multiAccessRoutes()
  {
    Route::group(['prefix' => 'product-models'], function () {
      $gen = function ($namespace, $name = null) {
        return 'multiaccess.product_' . $namespace . $name;
      };
      Route::get('', [self::class, 'getProductModels'])->name($gen('models.manage_product_models'))->defaults('ex', __e('ss,a,w', 'git-branch', false))->middleware('auth:super_admin,auditor,web_admin');
      Route::match(['post', 'get'], 'create', [self::class, 'createProductModel'])->name($gen('models', '.create_product_model'))->defaults('ex', __e('ss,a,w', 'git-branch', true))->middleware('auth:super_admin,auditor,web_admin');
      Route::get('{productModel}', [self::class, 'getProductModelDetails'])->name($gen('models', '.details'))->defaults('ex', __e('ss,a,w', 'git-branch', true))->middleware('auth:super_admin,auditor,web_admin');
      Route::put('{productModel}/edit', [self::class, 'editProductModel'])->name($gen('models', '.edit_product_model'))->defaults('ex', __e('ss,a,w', 'git-branch', true))->middleware('auth:super_admin,auditor,web_admin');
      // Route::get('{productModel}/qa-tests', [self::class, 'getProductModelQATests'])->name($gen('models', '.model_qa_tests'))->defaults('ex', __e('ss', 'git-branch', true))->middleware('auth:super_admin');
      Route::put('{productModel}/qa-tests', [self::class, 'updateProductModelQATests'])->name($gen('models', '.update_model_qa_tests'))->defaults('ex', __e('ss,a,w', 'git-branch', true))->middleware('auth:super_admin,auditor,web_admin');
      // Route::get('{productModel}/images', [self::class, 'getProductModelImages'])->name($gen('models', '.model_images'))->defaults('ex', __e('ss', 'git-branch', true))->middleware('auth:super_admin');
      Route::post('{productModel}/images/create', [self::class, 'createProductModelImage'])->name($gen('models', '.create_model_image'))->defaults('ex', __e('a,w', 'git-branch', true))->middleware('auth:auditor,web_admin');
      Route::delete('images/{id}/delete', [self::class, 'deleteProductModelImage'])->name($gen('models', '.delete_model_image'))->defaults('ex', __e('ss,a,w', 'git-branch', true))->middleware('auth:super_admin,auditor,web_admin');
      Route::post('{productModel}/comment', [self::class, 'commentOnProductModel'])->name($gen('models', '.comment_on_model'))->defaults('ex', __e('ss,a,w', null, true))->middleware('auth:super_admin,auditor,web_admin');
    });
  }

  public function getProductModels(Request $request)
  {
    $productModels =  Cache::rememberForever('modelsWithCount', function () {
      return (new ProductModelTransformer)->collectionTransformer(self::withCount('products')->with('product_category', 'product_brand')->get(), 'transformWithCategoryAndBrand');
    });

    if ($request->isApi()) {
      return response()->json($productModels, 200);
    }
    return Inertia::render('SuperAdmin,ProductModels/List', [
      'productModels' => $productModels,
      'productBrands' => Cache::rememberForever('brandsWithProductCount', fn () => (new ProductBrandTransformer)->collectionTransformer(ProductBrand::withCount('products')->get(), 'basic')),
      'productCategories' => Cache::rememberForever('productCategories', fn () => (new ProductCategoryTransformer)->collectionTransformer(ProductCategory::withCount('products')->get(), 'basic')),
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
          'img_url' => compress_image_upload('img', 'product_models_images/', 'product_models_images/thumb/', 800, true, 150)['img_url'],
        ]);
        if ($request->isApi()) {
          # code...
          return response()->json((new ProductModelTransformer)->basic($product_model), 201);
        } else return back()->withFlash(['success'=>'New product model created. Add some images to it']);
      } catch (\Throwable $th) {
        dd($th);
        ErrLog::notifyAuditor($request->user(), $th, 'Product model not created');
        return response()->json(['err' => 'Product model not created'], 500);
      }
    }
  }

  public function editProductModel(CreateProductModelValidation $request, self $productModel)
  {
    try {
      foreach (collect($request->validated())->except('img') as $key => $value) {
        $productModel->$key = $value;
      }

      if ($request->hasFile('img')) {
        $productModel->img_url = compress_image_upload('img', 'product_models_images/', 'product_models_images/thumb/', 800, true, 150)['img_url'];
      }

      $productModel->save();

      cache()->flush();

      if ($request->isApi()) {
        return response()->json([], 204);
      }
      return back()->withFlash(['success'=>'Updated']);
    } catch (\Throwable $th) {
      ErrLog::notifyAuditor($request->user(), $th, 'Model not updated');
      return response()->json(['err' => 'Model not updated'], 500);
    }
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
      return back()->withFlash(['error'=>['Nothing was updated']]);
    } else {
      return back()->withFlash(['success'=>'Product tests were updated successfully']);
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

    return back()->withFlash(['success'=>'Image created']);
  }

  public function deleteProductModelImage(Request $request,  $id)
  {
    ProductModelImage::destroy($id);
    if ($request->isApi()) {
      return response()->json([], 204);
    }
    return back()->withFlash(['success'=>'Deleted']);
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
    return back()->withFlash(['success'=>'Created']);
  }


  protected static function boot()
  {
    parent::boot();

    static::saved(function () {
      Cache::forget('modelsWithCount');
      Cache::forget('models');
    });
  }
}
