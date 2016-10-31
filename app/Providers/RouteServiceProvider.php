<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';
    protected $homeNamespace = 'App\Http\HomeControllers';
    protected $adminNamespace = 'App\Http\AdminControllers';
    protected $apiNamespace = 'App\Http\ApiControllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        //

        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Http/routes.php');
        });
        $router->group(['namespace' => $this->homeNamespace], function ($router) {
            require app_path('Http/Routers/HomeRoutes.php');
        });
        $router->group(['namespace' => $this->adminNamespace], function ($router) {
            require app_path('Http/Routers/AdminRoutes.php');
        });
        $router->group(['namespace' => $this->apiNamespace], function ($router) {
            require app_path('Http/Routers/ApiRoutes.php');
        });
    }
}
