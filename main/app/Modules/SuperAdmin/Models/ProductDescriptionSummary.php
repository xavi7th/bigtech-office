<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\ErrLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Models\ProductModel;
use App\Modules\SuperAdmin\Transformers\ProductDescriptionSummaryTransformer;
use App\Modules\SuperAdmin\Http\Validations\CreateProductDescriptionSummaryValidation;

/**
 * App\Modules\SuperAdmin\Models\ProductDescriptionSummary
 *
 * @property-read \App\Modules\SuperAdmin\Models\ProductModel $product_model
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductDescriptionSummary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductDescriptionSummary newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductDescriptionSummary onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductDescriptionSummary query()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductDescriptionSummary withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductDescriptionSummary withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property int $product_model_id
 * @property string $description_summary
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductDescriptionSummary whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductDescriptionSummary whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductDescriptionSummary whereDescriptionSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductDescriptionSummary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductDescriptionSummary whereProductModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductDescriptionSummary whereUpdatedAt($value)
 */
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

  static function routes()
  {
    Route::group(['prefix' => 'product-description-summary', 'namespace' => '\App\Modules\Admin\Models'], function () {
      $gen = function ($name) {
        return 'superadmin.product_descriptions' . $name;
      };
      Route::get('', [self::class, 'getProductDescriptionSummaries'])->name($gen(''))->defaults('ex', __e('ss', 'edit', true));
      Route::post('create', [self::class, 'createProductDescriptionSummary'])->name($gen('.create_product_desc'));
      Route::put('{productDescriptionSummary}/edit', [self::class, 'editProductDescriptionSummary'])->name($gen('.edit_product_desc'));
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

      return response()->json((new ProductDescriptionSummaryTransformer)->basic($product_desc_summary), 201);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Product description summary not created');
      return response()->json(['err' => 'Product description summary not created'], 500);
    }
  }

  public function editProductDescriptionSummary(CreateProductDescriptionSummaryValidation $request, self $product_desc_summary)
  {

    try {
      foreach ($request->validated() as $key => $value) {
        $product_desc_summary->$key = $value;
      }

      $product_desc_summary->save();

      return response()->json([], 204);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Product description summary not updated');
      return response()->json(['err' => 'Product description summary not updated'], 500);
    }
  }
}
