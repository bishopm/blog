<?php

namespace Bishopm\Blog\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Form;
use Bishopm\Blog\Repositories\SettingsRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Gate;

class BlogServiceProvider extends ServiceProvider
{
    private $settings;

    protected $commands = [
    ];

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(Dispatcher $events, SettingsRepository $settings)
    {
        $this->settings=$settings;
        Schema::defaultStringLength(255);
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/../Http/api.routes.php';
            require __DIR__.'/../Http/web.routes.php';
        }
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'blog');
        $this->loadMigrationsFrom(__DIR__.'/../Database/migrations');
        $this->publishes([__DIR__.'/../Assets' => public_path('vendor/bishopm'),], 'public');
        Form::component('bsText', 'blog::components.text', ['name', 'label' => '', 'placeholder' => '', 'value' => null, 'attributes' => []]);
        Form::component('bsPassword', 'blog::components.password', ['name', 'label' => '', 'placeholder' => '', 'value' => null, 'attributes' => []]);
        Form::component('bsTextarea', 'blog::components.textarea', ['name', 'label' => '', 'placeholder' => '', 'value' => null, 'attributes' => []]);
        Form::component('bsThumbnail', 'blog::components.thumbnail', ['source', 'width' => '100', 'label' => '']);
        Form::component('bsImgpreview', 'blog::components.imgpreview', ['source', 'width' => '200', 'label' => '']);
        Form::component('bsHidden', 'blog::components.hidden', ['name', 'value' => null]);
        Form::component('bsSelect', 'blog::components.select', ['name', 'label' => '', 'options' => [], 'value' => null, 'attributes' => []]);
        Form::component('pgHeader', 'blog::components.pgHeader', ['pgtitle', 'prevtitle', 'prevroute']);
        Form::component('pgButtons', 'blog::components.pgButtons', ['actionLabel', 'cancelRoute']);
        Form::component('bsFile', 'blog::components.file', ['name', 'attributes' => []]);
        config(['auth.providers.users.model'=>'Bishopm\Blog\Models\User']);
        if (Schema::hasTable('settings')) {
            /*$finset=$settings->makearray();
            if (($settings->getkey('site_name'))<>"Invalid") {
                config(['app.name'=>$settings->getkey('site_name')]);
            }*/
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
        $this->app->bind('setting', function () {
            return new \Bishopm\Blog\Repositories\SettingsRepository(new \Bishopm\Blog\Models\Setting());
        });
        AliasLoader::getInstance()->alias("Setting", 'Bishopm\Blog\Models\Facades\Setting');
        AliasLoader::getInstance()->alias("Socialite", 'Laravel\Socialite\Facades\Socialite');
        AliasLoader::getInstance()->alias("JWTFactory", 'Tymon\JWTAuth\Facades\JWTFactory');
        AliasLoader::getInstance()->alias("JWTAuth", 'Tymon\JWTAuth\Facades\JWTAuth');
        AliasLoader::getInstance()->alias("Form", 'Collective\Html\FormFacade');
        AliasLoader::getInstance()->alias("HTML", 'Collective\Html\HtmlFacade');
        AliasLoader::getInstance()->alias("Share", 'Jorenvh\Share\ShareFacade');
        $this->app['router']->aliasMiddleware('isverified', 'Bishopm\Blog\Middleware\IsVerified');
        $this->app['router']->aliasMiddleware('handlecors', 'Barryvdh\Cors\HandleCors');
        $this->app['router']->aliasMiddleware('jwt.auth', 'Tymon\JWTAuth\Middleware\GetUserFromToken');
        $this->app['router']->aliasMiddleware('role', 'Spatie\Permission\Middlewares\RoleMiddleware');
        $this->app['router']->aliasMiddleware('permission', 'Spatie\Permission\Middlewares\PermissionMiddleware');
        $this->registerBindings();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Bishopm\Blog\Repositories\BlogsRepository',
            function () {
                $repository = new \Bishopm\Blog\Repositories\BlogsRepository(new \Bishopm\Blog\Models\Blog());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Blog\Repositories\SettingsRepository',
            function () {
                $repository = new \Bishopm\Blog\Repositories\SettingsRepository(new \Bishopm\Blog\Models\Setting());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Blog\Repositories\UsersRepository',
            function () {
                $repository = new \Bishopm\Blog\Repositories\UsersRepository(new \Bishopm\Blog\Models\User());
                return $repository;
            }
        );
    }
}
