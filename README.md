<p align="center">
    <img src="https://chemex.celaraze.com/chemex-blue.png" width="120" height="120"/>
</p>

<p align="center">
<a href="http://chemex.it" target="_blank">梅利塔（Mellita）官方网站</a>
</p>

<p align="center">
    <img src="https://img.shields.io/badge/Latest Release-0.0.1-orange" />
    <img src="https://img.shields.io/badge/PHP-7.3+-green" />
    <img src="https://img.shields.io/badge/License-GPL3.0-blue" />
</p>

## 鸣谢

[JetBrains](https://jetbrains.com) | [Laravel](https://laravel.com) | [Dcat Admin](https://dcatadmin.com)
| [Tenancy](https://tenancyforlaravel.com)

## 简介

Mellita 可以使任何 Laravel 应用具备 SaaS 能力，只需要简单的 composer 安装以及极其少量的改动。无论你是打算使用 Laravel 项目开发新项目，还是将已经付出努力的项目转化为 SaaS 架构，都可以轻松实现。

Mellita 拥有一个控制台，控制台用于管理 SaaS 的租户实例，可以对其进行创建或是删除。对于租户实例则采用了分库的方式来处理，以使用户数据得到最基本的安全隔离保障和更加高效的数据库 I/O 效率。

## 环境要求

`Laravel` 没错，只有它，Mellita 所需的环境依赖正是 Laravel 所需的环境依赖。

## 安装

`composer require celaraze/mellita`

## 配置

1：执行 `php artisan mellita:install`

2：于 `app/Providers/RouteServiceProvider.php` 文件中：

```PHP
<?php

namespace App\Providers;

use Dcat\Admin\Admin;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/home';

    public function boot()
    {
        $this->configureRateLimiting();

        // 注意，Mellita SaaS Console依赖它注册路由，必须。
        Admin::routes();
        // 注意结束
        
        // 注意，这些方法在本类中声明，找到对应的方法查看说明
        // 如果声明了，就必须要加入到本方法内
        $this->mapWebRoutes();
        $this->mapApiRoutes();
        $this->mapAdminRoutes();
        // 注意结束
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
    
    /**
     * 获取根域名 
     * 注意，这个方法是必须的。
     * @return array
    */
    protected function centralDomains(): array
    {
        return config('tenancy.central_domains');
    }

    /**
     * web 路由处理
     * 注意，按照你的想法处理，如果声明此方法，web 路由将无法被租户实例所访问到
     * 只能通过Console访问
    */
    protected function mapWebRoutes()
    {
        foreach ($this->centralDomains() as $domain) {
            Route::middleware(['web'])
                ->domain($domain)
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        }
    }

    /**
     * api 路由处理
     * 注意，按照你的想法处理，如果声明此方法，api 路由将无法被租户实例所访问到
     * 只能通过Console访问
    */
    protected function mapApiRoutes()
    {
        foreach ($this->centralDomains() as $domain) {
            Route::prefix('api')
                ->domain($domain)
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));
        }
    }
    
    /**
     * console 路由处理
     * 注意，这是必须的
    */
    protected function mapAdminRoutes()
    {
        foreach ($this->centralDomains() as $domain) {
            Route::domain($domain)
                ->middleware(['web', 'admin'])
                ->namespace($this->namespace)
                ->group(base_path('app/Admin/routes.php'));
        }
    }
}
```

## 开始使用

租户实例的数据库迁移，移动至：`app/database/migrations/tenant` 文件夹中。

执行租户实例数据库迁移的命令是：`php artisan tenants:migrate`。

为租户定义的路由写在：`app/routes/tenant.php` 文件中。

## 创建租户实例

访问 `http://your-domain/admin` ，在租户实例中可以进行创建。

![Mellita](https://oss.celaraze.com/mellita/mellita-admin.png)

每一个租户实例都有独立的数据库以及其配置。

## 彩蛋

Mellita 可以和 DcatAdmin 完美联动，如果租户实例是通过 DcatAdmin 开发的应用，那么可以直接通过命令 `php artisan admin:app ApplicationName` 来创建多应用，
然后在 `app/admin.php` 文件中做以下配置：

```PHP
return [

    //...我是其它配置内容
    
    'multi_app' => [
        // 与新应用的配置文件名称一致
        // 设置为true启用，false则是停用
        'application_name' => true,
    ],
    
];
```

执行完成之后，`application_name` 的后台应用即为租户实例的应用，无需其它配置，逻辑代码则应该写在`app/ApplicationNmae` 文件夹中。

如果对此有疑问，可以查看 [DcatAdmin 多应用文档](https://learnku.com/docs/dcat-admin/2.x/multi-application-multi-background/8475) 。

## 开源协议

Mellita 遵循 [GPL3.0](https://www.gnu.org/licenses/gpl-3.0.html) 开源协议。
