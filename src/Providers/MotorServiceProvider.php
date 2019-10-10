<?php

namespace Motor\CMS\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Motor\CMS\Console\Commands\MotorMakeComponentCommand;
use Motor\CMS\Console\Commands\MotorMakeComponentClassCommand;
use Motor\CMS\Console\Commands\MotorMakeComponentInfoCommand;
use Motor\CMS\Http\Middleware\Frontend\Navigation;

/**
 * Class MotorServiceProvider
 * @package Motor\CMS\Providers
 */
class MotorServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        app('router')->pushMiddlewareToGroup('frontend', Navigation::class);

        $this->config();
        $this->routes();
        $this->routeModelBindings();
        $this->translations();
        $this->views();
        $this->navigationItems();
        $this->permissions();
        $this->migrations();
        $this->components();
        $this->templates();
        $this->vueRoutes();
        $this->publishResourceAssets();
        $this->registerCommands();
    }


    /**
     * Register artisan commands
     */
    public function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MotorMakeComponentCommand::class,
                MotorMakeComponentClassCommand::class,
                MotorMakeComponentInfoCommand::class,
            ]);
        }
    }


    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //$this->mergeConfigFrom(__DIR__ . '/../../config/laravel-menu/settings.php', 'laravel-menu.settings');
    }


    /**
     * Set assets to be published
     */
    public function publishResourceAssets()
    {
        //$assets = [
        //    //__DIR__ . '/../../resources/assets/sass'   => resource_path('assets/sass'),
        //    __DIR__ . '/../../resources/assets/js'     => resource_path('assets/js'),
        //    //__DIR__ . '/../../resources/assets/images' => resource_path('assets/images'),
        //    __DIR__ . '/../../resources/assets/npm'    => resource_path('assets/npm'),
        //];
        //
        //$this->publishes($assets, 'motor-cms-install-resources');
    }


    /**
     * Set migration path
     */
    public function migrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }


    /**
     * Merge permission config file
     */
    public function permissions()
    {
        $config = $this->app['config']->get('motor-backend-permissions', []);
        $this->app['config']->set(
            'motor-backend-permissions',
            array_replace_recursive(require __DIR__ . '/../../config/motor-backend-permissions.php', $config)
        );
    }


    /**
     * Set routes for vue.js integration
     */
    public function vueRoutes()
    {
        $config = $this->app['config']->get('ziggy', []);
        $this->app['config']->set(
            'ziggy',
            array_replace_recursive(require __DIR__ . '/../../config/ziggy.php', $config)
        );
    }


    /**
     * Register components from config file
     */
    public function components()
    {
        $config = $this->app['config']->get('motor-cms-page-components', []);
        $this->app['config']->set(
            'motor-cms-page-components',
            array_replace_recursive(require __DIR__ . '/../../config/motor-cms-page-components.php', $config)
        );
    }


    /**
     * Register templates from config file
     */
    public function templates()
    {
        $config = $this->app['config']->get('motor-cms-page-templates', []);
        $this->app['config']->set(
            'motor-cms-page-templates',
            array_replace_recursive(require __DIR__ . '/../../config/motor-cms-page-templates.php', $config)
        );
    }


    /**
     * Set routes
     */
    public function routes()
    {
        if (! $this->app->routesAreCached()) {
            require __DIR__ . '/../../routes/web.php';
            require __DIR__ . '/../../routes/api.php';
        }
    }


    /**
     * Set configuration files for publishing
     */
    public function config()
    {
        //$this->publishes([
        //    __DIR__ . '/../../config/motor-backend-project.php'          => config_path('motor-backend-project.php'),
        //], 'motor-backend-install');
    }


    /**
     * Set translation path
     */
    public function translations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'motor-cms');

        $this->publishes([
            __DIR__ . '/../../resources/lang' => resource_path('lang/vendor/motor-cms'),
        ], 'motor-cms-translations');
    }


    /**
     * Set view path
     */
    public function views()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'motor-cms');

        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/motor-cms'),
        ], 'motor-cms-views');
    }


    /**
     * Add route model bindings
     */
    public function routeModelBindings()
    {
        // Modules
        Route::bind('navigation', static function ($id) {
            return \Motor\CMS\Models\Navigation::findOrFail($id);
        });

        Route::bind('page', static function ($id) {
            return \Motor\CMS\Models\Page::findOrFail($id);
        });

        Route::bind('page_version_component', static function ($id) {
            return \Motor\CMS\Models\PageVersionComponent::findOrFail($id);
        });

        // Components
        Route::bind('component_text', static function ($id) {
            return \Motor\CMS\Models\Component\ComponentText::findOrFail($id);
        });
    }


    /**
     * Merge backend navigation items from configuration file
     */
    public function navigationItems()
    {
        $config = $this->app['config']->get('motor-backend-navigation', []);
        $this->app['config']->set(
            'motor-backend-navigation',
            array_replace_recursive(require __DIR__ . '/../../config/motor-backend-navigation.php', $config)
        );
    }
}
