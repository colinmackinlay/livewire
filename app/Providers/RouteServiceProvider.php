<?php

namespace App\Providers;

use Hyn\Tenancy\Environment;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @param Router $router
     *
     * @return void
     */
    public function map(Router $router)
    {
        $this->mapTenantRoutes($router);

        $this->mapWebRoutes();

        $this->mapApiRoutes();

    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "tenant" routes for the application.
     *
     * These routes should be aliased as tenant.x to make it explicit when referring
     * from view. This would help remove confusion in the future when we have
     * "system" routes. Think of it as a namespace for the routes.
     *
     * @param Router $router
     */
    protected function mapTenantRoutes(Router $router)
    {
        if (env('APP_ENV') == "testing")
        {
            $fqdn = 'tenant' . env('APP_URL_BASE');
        } else
        {
            if (is_null(app(Environment::class)->hostname()))
            {
                $router->middleware(['web', 'tenancy.enforce'])
                    ->domain('{account}.' . env('APP_URL_BASE'))
                    ->namespace($this->namespace)
                    ->as('tenant.')
                    ->group(base_path('routes/tenant/auth.php'));
                return;
            }
            $fqdn = app(Environment::class)->hostname()->fqdn;
        }
        $router->middleware(['web', 'tenancy.enforce'])
            ->domain($fqdn)
            ->namespace($this->namespace)
            ->as('tenant.')
            ->group(base_path('routes/tenant/auth.php'));

        $router->middleware(['web', 'staff.verified', 'auth:employee', 'tenancy.enforce'])
            ->domain($fqdn)
            ->namespace($this->namespace)
            ->as('tenant.')
            ->group(base_path('routes/tenant/home.php'));
    }
}
