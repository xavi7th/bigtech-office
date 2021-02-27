<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\ErrLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Models\ProductModel;
use App\Modules\SuperAdmin\Transformers\ProductDescriptionSummaryTransformer;
use App\Modules\SuperAdmin\Http\Validations\CreateProductDescriptionSummaryValidation;

class ProductDescriptionSummary extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'product_model_id',
    'description_summary',
  ];

  public function product_model()
  {
    return $this->belongsTo(ProductModel::class);
  }

  static function multiAccessRoutes()
  {
    Route::group(['prefix' => 'product-description-summary'], function () {
      $gen = function ($name) {
        return 'multiaccess.product_descriptions' . $name;
      };
      Route::get('', [self::class, 'getProductDescriptionSummaries'])->name($gen(''))->defaults('ex', __e('ss,a,', 'edit', true))->middleware('auth:super_admin,auditor,web_admin');
      Route::post('create', [self::class, 'createProductDescriptionSummary'])->name($gen('.create_product_desc'))->middleware('auth:super_admin,auditor,web_admin');
      Route::put('{productModel}/edit', [self::class, 'editProductDescriptionSummary'])->name($gen('.edit_product_desc'))->middleware('auth:super_admin,auditor,web_admin');
    });
  }

  public function getProductDescriptionSummaries()
  {
    return response()->json((new ProductDescriptionSummaryTransformer)->collectionTransformer(self::with('product_model')->get(), 'basic'), 200);
  }

  public function createProductDescriptionSummary(CreateProductDescriptionSummaryValidation $request)
  {
    try {
      $product_desc_summary = self::create($request->validated());
      if ($request->isApi())
        return response()->json((new ProductDescriptionSummaryTransformer)->basic($product_desc_summary), 201);
      return back()->withFlash(['success'=>'Product Model Description has been created']);
    } catch (\Throwable $th) {
      ErrLog::notifyAuditor($request->user(), $th, 'Product description summary not created');
      if ($request->isApi())
        return response()->json(['err' => 'Product description summary not created'], 500);
      return back()->withFlash(['error'=>['Product description summary not created']]);
    }
  }

  public function editProductDescriptionSummary(CreateProductDescriptionSummaryValidation $request, ProductModel $productModel)
  {
    dd($request->all());

    try {
      foreach ($request->validated() as $key => $value) {
        $productModel->product_description_summary->$key = $value;
      }

      $productModel->product_description_summary->save();

      if ($request->isApi())
        return response()->json([], 204);
      return back()->withFlash(['success'=>'Product Model Description has been updated']);
    } catch (\Throwable $th) {
      ErrLog::notifyAuditor($request->user(), $th, 'Product description summary not updated');
      if ($request->isApi())
        return response()->json(['err' => 'Product description summary not updated'], 500);
      return back()->withFlash(['success'=>'Product Model Description not updated']);
    }
  }
}
