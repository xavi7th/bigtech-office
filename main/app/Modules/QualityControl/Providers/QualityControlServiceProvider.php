<?php

namespace App\Modules\QualityControl\Providers;

use Illuminate\Support\Str;
use Illuminate\Auth\SessionGuard;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use App\Modules\QualityControl\Models\QualityControl;

class QualityControlServiceProvider extends ServiceProvider
{
  /**
   * @var string $moduleName
   */
  protected $moduleName = 'QualityControl';

  /**
   * @var string $moduleNameLower
   */
  protected $moduleNameLower = 'qualitycontrol';

  /**
   * Boot the application events.
   *
   * @return void
   */
  public function boot()
  {
    if ((Str::contains(request()->url(), QualityControl::DASHBOARD_ROUTE_PREFIX)) || Str::contains(request()->url(), 'login') || App::runningInConsole()) {
      $this->registerTranslations();
      $this->registerConfig();
      $this->registerViews();
      $this->registerFactories();
      $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

      // app()->make('router')->aliasMiddleware('quality_controls', OnlyQualityControls::class);
      // app()->make('router')->aliasMiddleware('verified', VerifiedQualityControls::class);
    }
  }

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register()
  {
    if ((Str::contains(request()->url(), QualityControl::DASHBOARD_ROUTE_PREFIX)) || Str::contains(request()->url(), 'login') || $this->app->runningInConsole()) {
      $this->app->register(RouteServiceProvider::class);
      SessionGuard::macro('quality_control', function () {
        return QualityControl::find(Auth::guard('quality_control')->id());
      });
    }
  }

  /**
   * Register config.
   *
   * @return void
   */
  protected function registerConfig()
  {
    $this->publishes([
      module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
    ], 'config');
    $this->mergeConfigFrom(
      module_path($this->moduleName, 'Config/config.php'),
      $this->moduleNameLower
    );
  }

  /**
   * Register views.
   *
   * @return void
   */
  public function registerViews()
  {
    $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

    $sourcePath = module_path($this->moduleName, 'Resources/views');

    $this->publishes([
      $sourcePath => $viewPath
    ], ['views', $this->moduleNameLower . '-module-views']);

    $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
  }

  /**
   * Register translations.
   *
   * @return void
   */
  public function registerTranslations()
  {
    $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

    if (is_dir($langPath)) {
      $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
    } else {
      $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
    }
  }

  /**
   * Register an additional directory of factories.
   *
   * @return void
   */
  public function registerFactories()
  {
    if (!app()->environment('production') && $this->app->runningInConsole()) {
      app(Factory::class)->load(module_path($this->moduleName, 'Database/factories'));
    }
  }

  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides()
  {
    return [];
  }

  private function getPublishableViewPaths(): array
  {
    $paths = [];
    foreach (\Config::get('view.paths') as $path) {
      if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
        $paths[] = $path . '/modules/' . $this->moduleNameLower;
      }
    }
    return $paths;
  }
}
