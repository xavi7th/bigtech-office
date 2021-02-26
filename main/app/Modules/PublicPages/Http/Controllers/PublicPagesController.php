<?php

namespace App\Modules\PublicPages\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class PublicPagesController extends Controller
{

  static function routes()
  {
    Route::group(['middleware' => 'web', 'namespace' => '\App\Modules\PublicPages\Http\Controllers'], function () {
      Route::get('/', [PublicPagesController::class, 'index'])->name('app.home');
    });
  }

  public function index(Request $request)
  {
    return redirect()->route('app.login');

    return Inertia::render('PublicPages,Home', [])->withViewData(['title' => 'Welcome to the Bigtech Devices',
      'metaDesc' => 'Sales of phones gadgets etc',
      'ogUrl' => route('app.home')
    ]);
  }
}
