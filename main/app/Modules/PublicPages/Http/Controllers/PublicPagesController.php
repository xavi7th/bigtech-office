<?php

namespace App\Modules\PublicPages\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;

class PublicPagesController extends Controller
{
  public function __construct()
  {
    Inertia::setRootView('publicpages::app');
  }

  static function routes()
  {
    Route::group(['middleware' => 'web', 'namespace' => '\App\Modules\PublicPages\Http\Controllers'], function () {
      Route::get('/', [PublicPagesController::class, 'index'])->name('app.home');
    });
  }

  public function index(Request $request)
  {
    return Inertia::render('Home', [])->withViewData([
      'title' => 'Welcome to the Elects',
      'metaDesc' => 'Sales of phones gadgets etc',
      'ogUrl' => route('app.home')
    ]);
  }
}
