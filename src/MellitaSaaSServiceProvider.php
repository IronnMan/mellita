<?php

namespace Mellita\SaaS;

use Illuminate\Console\Application;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Mellita\SaaS\Http\Controllers\DomainController;

class MellitaSaaSServiceProvider extends ServiceProvider
{
    /**
     * @var string[] 自定义命令清单
     */
    protected $commands = [
        Console\InitAdminMenuCommand::class,
        Console\InstallCommand::class,
    ];

    /**
     * 启动入口
     */
    public function boot()
    {
        $this->commands($this->commands);
        $this->registerRoutes();
    }

    /**
     * 注册自定义命令至Laravel的命令中
     *
     * @param array|mixed $commands
     * @return void
     */
    public function commands($commands)
    {
        $commands = is_array($commands) ? $commands : func_get_args();

        Application::starting(function ($artisan) use ($commands) {
            $artisan->resolveCommands($commands);
        });
    }

    /**
     * 应用管理.
     */
    public static function app()
    {
        return app('admin.app');
    }

    public function registerRoutes()
    {
        $attributes = [
            'prefix' => config('admin.route.prefix'),
            'as' => static::app()->getName() . '.',
        ];
        app('router')->group($attributes, function ($router) {
            /* @var Router $router */
            $router->resource('/', DomainController::class);
        });
    }
}
