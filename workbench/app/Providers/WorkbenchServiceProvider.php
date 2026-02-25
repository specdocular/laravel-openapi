<?php

namespace Workbench\App\Providers;

use Illuminate\Support\ServiceProvider;
use Workbench\App\Documentation\Workbench;

class WorkbenchServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->app['config']->set('openapi.scopes.Workbench', [
            'openapi' => Workbench::class,
        ]);
        config(['cors.allowed_origins' => ['*']]);

        $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/console.php');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'workbench');
    }
}
