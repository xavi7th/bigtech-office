<?php

namespace App\Modules\AppUser\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\AppUser\Http\Controllers\AppUserController;

/**
 * App\Modules\AppUser\Models\ProductReceipt
 *
 * @property int $id
 * @property int $product_id
 * @property string $user_email
 * @property string $user_phone
 * @property string $user_address
 * @property string $user_city
 * @property string $order_ref
 * @property string $product_type
 * @property float $amount_paid
 * @property float|null $tax_rate
 * @property float|null $delivery_fee
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReceipt newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReceipt newQuery()
 * @method static \Illuminate\Database\Query\Builder|ProductReceipt onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReceipt query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReceipt whereAmountPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReceipt whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReceipt whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReceipt whereDeliveryFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReceipt whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReceipt whereOrderRef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReceipt whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReceipt whereTaxRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReceipt whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReceipt whereUserAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReceipt whereUserCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReceipt whereUserEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReceipt whereUserPhone($value)
 * @method static \Illuminate\Database\Query\Builder|ProductReceipt withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ProductReceipt withoutTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReceipt whereProductType($value)
 * @mixin \Eloquent
 */
class ProductReceipt extends Model
{
  use SoftDeletes;

  protected $fillable = ['user_email', 'user_name', 'user_phone', 'user_address', 'user_city', 'amount_paid'];

  public function product()
  {
    return $this->morphTo();
  }

  public function appUser()
  {
    return $this->product->app_user();
  }

  static function multiAccessRoutes()
  {
    Route::name('multiaccess.products.')->prefix('products')->group(function () {
      Route::get('receipt/{productReceipt:order_ref}', [AppUserController::class, 'previewReceipt'])->name('receipt')->defaults('ex', __e('ss,ac', null, true))->middleware('auth:super_admin,accountant');
      Route::post('receipt/{productReceipt:order_ref}', [AppUserController::class, 'resendReceipt'])->name('resend_receipt')->defaults('ex', __e('ss,ac', null, true))->middleware('auth:super_admin,accountant');
    });
  }


  protected static function boot()
  {
    parent::boot();

    static::creating(function (self $productReceipt) {
      $productReceipt->order_ref = (string)Str::random();
      $productReceipt->product_type = (string)get_class($productReceipt->product);
    });

    // static::saved(function ($product) {
    //   Cache::forget($product->office_branch->city . 'officeBranchProducts');
    //   Cache::forget('products');
    //   Cache::forget('webAdminProducts');
    //   Cache::forget('dispatchAdminProducts');
    //   Cache::forget('stockKeeperProducts');
    //   Cache::forget('salesRepProducts');
    //   Cache::forget('qualityControlProducts');
    //   Cache::forget('brandsWithProductCount');
    // });

  }
}
