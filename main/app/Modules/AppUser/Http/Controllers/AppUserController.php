<?php

namespace App\Modules\AppUser\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Http\Controllers\Auth\LoginController;
use App\Modules\AppUser\Http\Controllers\Auth\RegisterController;

class AppUserController extends Controller
{
  static function routes()
  {
    LoginController::routes();
    RegisterController::routes();
    // ResetPasswordController::routes();
    // ForgotPasswordController::routes();
    // ConfirmPasswordController::routes();
    // VerificationController::routes();

    Route::group(['middleware' => ['web', 'auth'], 'namespace' => '\App\Modules\AppUser\Http\Controllers'], function () {

      Route::get('/preview-product-in-quickview', [self::class, 'previewProduct']);

      Route::prefix(AppUser::DASHBOARD_ROUTE_PREFIX)->group(function () {
        Route::get('/', 'AppUserController@index')->name('appuser.dashboard')->defaults('ex', __e('a', 'home', true));
      });
    });
  }

  /**
   * The card user Api routes
   * @return Response
   */
  public static function apiRoutes()
  {

    Route::group(['prefix' => 'v1'], function () {

      Route::get('/', 'AppUserController@index');

      LoginController::apiRoutes();

      RegisterController::apiRoutes();

      ForgotPasswordController::routes();

      ResetPasswordController::routes();

      AppUser::appUserRoutes();

      Voucher::appUserRoutes();

      Notification::appUserRoutes();
    });
  }



  public function index(Request $request)
  {
    Auth::logout();
    return Inertia::render('AppUser,Welcome');
  }

  public function previewProduct(Request $request)
  {
    return '<div class="quickview"><button class="quickview__close" type="button"><svg width="20px" height="20px"><use xlink:href="/img/sprite.svg#cross-20"></use></svg></button><div class="product product--layout--quickview" data-layout="quickview"><div class="product__content"><!-- .product__gallery --><div class="product__gallery"><div class="product-gallery"><div class="product-gallery__featured"><button class="product-gallery__zoom"><svg width="24px" height="24px"><use xlink:href="/img/sprite.svg#zoom-in-24"></use></svg></button><div class="owl-carousel" id="product-image"><a href="/img/products/product-16.jpg" target="_blank"><img src="/img/products/product-16.jpg" alt=""> </a><a href="/img/products/product-16-1.jpg" target="_blank"><img src="/img/products/product-16-1.jpg" alt=""> </a><a href="/img/products/product-16-2.jpg" target="_blank"><img src="/img/products/product-16-2.jpg" alt=""> </a><a href="/img/products/product-16-3.jpg" target="_blank"><img src="/img/products/product-16-3.jpg" alt=""> </a><a href="/img/products/product-16-4.jpg" target="_blank"><img src="/img/products/product-16-4.jpg" alt=""></a></div></div><div class="product-gallery__carousel"><div class="owl-carousel" id="product-carousel"><a href="/img/products/product-16.jpg" class="product-gallery__carousel-item"><img class="product-gallery__carousel-image" src="/img/products/product-16.jpg" alt=""> </a><a href="/img/products/product-16-1.jpg" class="product-gallery__carousel-item"><img class="product-gallery__carousel-image" src="/img/products/product-16-1.jpg" alt=""> </a><a href="/img/products/product-16-2.jpg" class="product-gallery__carousel-item"><img class="product-gallery__carousel-image" src="/img/products/product-16-2.jpg" alt=""> </a><a href="/img/products/product-16-3.jpg" class="product-gallery__carousel-item"><img class="product-gallery__carousel-image" src="/img/products/product-16-3.jpg" alt=""> </a><a href="/img/products/product-16-4.jpg" class="product-gallery__carousel-item"><img class="product-gallery__carousel-image" src="/img/products/product-16-4.jpg" alt=""></a></div></div></div></div><!-- .product__gallery / end --><!-- .product__info --><div class="product__info"><div class="product__wishlist-compare"><button type="button" class="btn btn-sm btn-light btn-svg-icon" data-toggle="tooltip" data-placement="right" title="Wishlist"><svg width="16px" height="16px"><use xlink:href="/img/sprite.svg#wishlist-16"></use></svg></button> <button type="button" class="btn btn-sm btn-light btn-svg-icon" data-toggle="tooltip" data-placement="right" title="Compare"><svg width="16px" height="16px"><use xlink:href="/img/sprite.svg#compare-16"></use></svg></button></div><h1 class="product__name">Brandix Screwdriver SCREW1500ACC</h1><div class="product__rating"><div class="product__rating-stars"><div class="rating"><div class="rating__body"><svg class="rating__star rating__star--active" width="13px" height="12px"><g class="rating__fill"><use xlink:href="/img/sprite.svg#star-normal"></use></g><g class="rating__stroke"><use xlink:href="/img/sprite.svg#star-normal-stroke"></use></g></svg><div class="rating__star rating__star--only-edge rating__star--active"><div class="rating__fill"><div class="fake-svg-icon"></div></div><div class="rating__stroke"><div class="fake-svg-icon"></div></div></div><svg class="rating__star rating__star--active" width="13px" height="12px"><g class="rating__fill"><use xlink:href="/img/sprite.svg#star-normal"></use></g><g class="rating__stroke"><use xlink:href="/img/sprite.svg#star-normal-stroke"></use></g></svg><div class="rating__star rating__star--only-edge rating__star--active"><div class="rating__fill"><div class="fake-svg-icon"></div></div><div class="rating__stroke"><div class="fake-svg-icon"></div></div></div><svg class="rating__star rating__star--active" width="13px" height="12px"><g class="rating__fill"><use xlink:href="/img/sprite.svg#star-normal"></use></g><g class="rating__stroke"><use xlink:href="/img/sprite.svg#star-normal-stroke"></use></g></svg><div class="rating__star rating__star--only-edge rating__star--active"><div class="rating__fill"><div class="fake-svg-icon"></div></div><div class="rating__stroke"><div class="fake-svg-icon"></div></div></div><svg class="rating__star rating__star--active" width="13px" height="12px"><g class="rating__fill"><use xlink:href="/img/sprite.svg#star-normal"></use></g><g class="rating__stroke"><use xlink:href="/img/sprite.svg#star-normal-stroke"></use></g></svg><div class="rating__star rating__star--only-edge rating__star--active"><div class="rating__fill"><div class="fake-svg-icon"></div></div><div class="rating__stroke"><div class="fake-svg-icon"></div></div></div><svg class="rating__star rating__star--active" width="13px" height="12px"><g class="rating__fill"><use xlink:href="/img/sprite.svg#star-normal"></use></g><g class="rating__stroke"><use xlink:href="/img/sprite.svg#star-normal-stroke"></use></g></svg><div class="rating__star rating__star--only-edge rating__star--active"><div class="rating__fill"><div class="fake-svg-icon"></div></div><div class="rating__stroke"><div class="fake-svg-icon"></div></div></div></div></div></div><div class="product__rating-legend"><a href="">7 Reviews</a><span>/</span><a href="">Write A Review</a></div></div><div class="product__description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ornare, mi in ornare elementum, libero nibh lacinia urna, quis convallis lorem erat at purus. Maecenas eu varius nisi.</div><ul class="product__features"><li>Speed: 750 RPM</li><li>Power Source: Cordless-Electric</li><li>Battery Cell Type: Lithium</li><li>Voltage: 20 Volts</li><li>Battery Capacity: 2 Ah</li></ul><ul class="product__meta"><li class="product__meta-availability">Availability: <span class="text-success">In Stock</span></li><li>Brand: <a href="">Wakita</a></li><li>SKU: 83690/32</li></ul></div><!-- .product__info / end --><!-- .product__sidebar --><div class="product__sidebar"><div class="product__availability">Availability: <span class="text-success">In Stock</span></div><div class="product__prices">$1,499.00</div><!-- .product__options --><form class="product__options"><div class="form-group product__option"><label class="product__option-label">Color</label><div class="input-radio-color"><div class="input-radio-color__list"><label class="input-radio-color__item input-radio-color__item--white" style="color: #fff;" data-toggle="tooltip" title="White"><input type="radio" name="color"> <span></span></label> <label class="input-radio-color__item" style="color: #ffd333;" data-toggle="tooltip" title="Yellow"><input type="radio" name="color"> <span></span></label> <label class="input-radio-color__item" style="color: #ff4040;" data-toggle="tooltip" title="Red"><input type="radio" name="color"> <span></span></label> <label class="input-radio-color__item input-radio-color__item--disabled" style="color: #4080ff;" data-toggle="tooltip" title="Blue"><input type="radio" name="color" disabled="disabled"> <span></span></label></div></div></div><div class="form-group product__option"><label class="product__option-label">Material</label><div class="input-radio-label"><div class="input-radio-label__list"><label><input type="radio" name="material"> <span>Metal</span></label> <label><input type="radio" name="material"> <span>Wood</span></label> <label><input type="radio" name="material" disabled="disabled"> <span>Plastic</span></label></div></div></div><div class="form-group product__option"><label class="product__option-label" for="product-quantity">Quantity</label><div class="product__actions"><div class="product__actions-item"><div class="input-number product__quantity"><input id="product-quantity" class="input-number__input form-control form-control-lg" type="number" min="1" value="1"><div class="input-number__add"></div><div class="input-number__sub"></div></div></div><div class="product__actions-item product__actions-item--addtocart"><button class="btn btn-primary btn-lg">Add to cart</button></div><div class="product__actions-item product__actions-item--wishlist"><button type="button" class="btn btn-secondary btn-svg-icon btn-lg" data-toggle="tooltip" title="Wishlist"><svg width="16px" height="16px"><use xlink:href="/img/sprite.svg#wishlist-16"></use></svg></button></div><div class="product__actions-item product__actions-item--compare"><button type="button" class="btn btn-secondary btn-svg-icon btn-lg" data-toggle="tooltip" title="Compare"><svg width="16px" height="16px"><use xlink:href="/img/sprite.svg#compare-16"></use></svg></button></div></div></div></form><!-- .product__options / end --></div><!-- .product__end --><div class="product__footer"><div class="product__tags tags"><div class="tags__list"><a href="">Mounts</a> <a href="">Electrodes</a> <a href="">Chainsaws</a></div></div><div class="product__share-links share-links"><ul class="share-links__list"><li class="share-links__item share-links__item--type--like"><a href="">Like</a></li><li class="share-links__item share-links__item--type--tweet"><a href="">Tweet</a></li><li class="share-links__item share-links__item--type--pin"><a href="">Pin It</a></li><li class="share-links__item share-links__item--type--counter"><a href="">4K</a></li></ul></div></div></div></div></div>';
  }
}
