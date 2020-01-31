<?php

namespace Uccello\Comment\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * App Service Provider
 */
class AppServiceProvider extends ServiceProvider
{
  /**
   * Indicates if loading of the provider is deferred.
   *
   * @var bool
   */
  protected $defer = false;

  public function boot()
  {
    // Views
    $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'comment');

    // Translations   // TODO: Not working...
    $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'comment');

    // Routes
    $this->loadRoutesFrom(__DIR__ . '/../Http/routes.php');
    
    // Migrations
    $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations/');


    // // Publish assets
    // $this->publishes([
    //   __DIR__ . '/../../public' => public_path('vendor/uccello/crm'),
    // ], 'crm-assets');

    // // Publish config
    // $this->publishes([
    //   __DIR__ . '/../../config/crm.php' => config_path('crm.php')
    // ], 'crm-config');
  }

  public function register()
  {
    // // Config
    // $this->mergeConfigFrom(
    //   __DIR__ . '/../../config/comment.php',
    //   'crm'
    // );
  }
}
