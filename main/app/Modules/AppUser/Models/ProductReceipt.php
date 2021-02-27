<?php

namespace App\Modules\AppUser\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\AppUser\Http\Controllers\AppUserController;

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
  }
}
