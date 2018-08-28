<?php

namespace VueGenerators;

use VueGenerators\Commands\MakeView;
use VueGenerators\Commands\MakeMixin;
use VueGenerators\Commands\MakeComponent;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands();
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config.php' => config_path('vue-generators.php'),
        ], 'config');
    }

    /**
     * Register Artisan commands.
     */
    protected function registerCommands()
    {
        $this->app->singleton('command.vue.component', function ($app) {
            return $app[MakeComponent::class];
        });

        $this->app->singleton('command.vue.mixin', function ($app) {
            return $app[MakeMixin::class];
        });

        $this->app->singleton('command.vue.view', function ($app) {
            return $app[MakeView::class];
        });

        $this->commands('command.vue.component');

        $this->commands('command.vue.mixin');

        $this->commands('command.vue.view');
    }
}
