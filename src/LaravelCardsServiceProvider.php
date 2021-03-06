<?php

namespace DavideCasiraghi\LaravelCards;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class LaravelCardsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-cards');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-cards');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->app['router']->aliasMiddleware('admin', \DavideCasiraghi\LaravelCards\Http\Middleware\Admin::class);

        if (! class_exists('CreateCardsTable')) {
            $this->publishes([
                __DIR__.'/../database/migrations/create_cards_table.php.stub' => database_path('migrations/'.Carbon::now()->format('Y_m_d_Hmsu').'_create_cards_table.php'),
            ], 'migrations');
        }
        if (! class_exists('CreateCardTranslationsTable')) {
            $this->publishes([
                __DIR__.'/../database/migrations/create_card_translations_table.php.stub' => database_path('migrations/'.Carbon::now()->format('Y_m_d_Hmsu').'_create_card_translations_table.php'),
            ], 'migrations');
        }

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-cards.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../resources/assets/sass' => resource_path('sass/vendor/laravel-cards/'),
            ], 'sass');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-cards'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-cards'),
            ], 'assets');*/

            // Publishing the translation files.
            $this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-cards'),
            ], 'lang');

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-cards');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-cards', function () {
            return new LaravelCards;
        });
    }
}
