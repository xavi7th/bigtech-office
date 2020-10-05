<?php

namespace App\Providers;

use Inertia\Inertia;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    Builder::defaultStringLength(191);
  }



  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    // URL::forceRootUrl(Config::get('app.url'));
  }
}
