<?php

namespace Specdocular\LaravelOpenAPI\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Specdocular\LaravelOpenAPI\Console\CallbackFactoryMakeCommand;
use Specdocular\LaravelOpenAPI\Console\ExtensionFactoryMakeCommand;
use Specdocular\LaravelOpenAPI\Console\GenerateCommand;
use Specdocular\LaravelOpenAPI\Console\ParametersFactoryMakeCommand;
use Specdocular\LaravelOpenAPI\Console\RequestBodyFactoryMakeCommand;
use Specdocular\LaravelOpenAPI\Console\ResponseFactoryMakeCommand;
use Specdocular\LaravelOpenAPI\Console\SchemaFactoryMakeCommand;
use Specdocular\LaravelOpenAPI\Console\SecuritySchemeFactoryMakeCommand;
use Specdocular\LaravelOpenAPI\Http\OpenApiController;

class OpenApiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/openapi.php',
            'openapi',
        );

        $this->commands([
            GenerateCommand::class,
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                CallbackFactoryMakeCommand::class,
                ExtensionFactoryMakeCommand::class,
                ParametersFactoryMakeCommand::class,
                RequestBodyFactoryMakeCommand::class,
                ResponseFactoryMakeCommand::class,
                SchemaFactoryMakeCommand::class,
                SecuritySchemeFactoryMakeCommand::class,
            ]);
        }
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/openapi.php' => config_path('openapi.php'),
        ], 'openapi-config');

        // Routes can be disabled per-scope by omitting 'route.uri' in config.
        Route::group(['as' => 'openapi.'], static function (): void {
            foreach (config('openapi.scopes', []) as $name => $config) {
                $uri = Arr::get($config, 'route.uri');

                if (!$uri) {
                    continue;
                }

                Route::get($uri, [OpenApiController::class, 'show'])
                    ->name($name . '.specification')
                    ->prefix('/api')
                    ->middleware(['api', ...Arr::get($config, 'route.middleware')]);
            }
        });
    }
}
