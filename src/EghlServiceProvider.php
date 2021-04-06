<?php

namespace Killallskywalker\Eghl;

use Illuminate\Support\ServiceProvider;

class EghlServiceProvider extends ServiceProvider
{
  public function register()
  {
    $this->mergeConfigFrom(__DIR__.'/../config/eghl.php', 'eghl');
    
    $this->app->singleton('eghl', function($app){
      return new Eghl();
    });
  }

  public function boot()
  {
    $this->publishes([
      __DIR__ . '/../config/eghl.php' => config_path('eghl.php')
    ]);
  }
}