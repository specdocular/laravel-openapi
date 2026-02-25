<?php

use Illuminate\Support\Facades\Route;
use Specdocular\LaravelOpenAPI\Attributes\Scope;
use Specdocular\LaravelOpenAPI\Support\RouteCollector;
use Specdocular\LaravelOpenAPI\Support\RouteInfo;
use Tests\Support\Doubles\Stubs\Builders\ControllerWithPathItemAndOperationStub;
use Tests\Support\Doubles\Stubs\CollectibleClass;
use Tests\Support\Doubles\Stubs\Objects\ExplicitDefaultScopeController;
use Tests\Support\Doubles\Stubs\Objects\ExplicitDefaultScopeControllerAction;
use Tests\Support\Doubles\Stubs\Objects\ExplicitOverriddenDefaultScopeControllerAction;
use Tests\Support\Doubles\Stubs\Objects\ImplicitDefaultScopeController;

describe(class_basename(RouteCollector::class), function (): void {
    it('can filter routes by scope', function (): void {
        Route::get('/default-scope', ControllerWithPathItemAndOperationStub::class);
        Route::get('/test-scope', CollectibleClass::class);
        Route::put('/another-scope', ControllerWithPathItemAndOperationStub::class);
        Route::patch('/default-scope', ControllerWithPathItemAndOperationStub::class);
        Route::delete('/default-scope', ControllerWithPathItemAndOperationStub::class);
        /** @var RouteCollector $routeCollector */
        $routeCollector = app(RouteCollector::class);

        $routes = $routeCollector->whereShouldBeCollectedFor('TestCollection');

        expect($routes)->toHaveCount(1)
            ->and($routes)->toContainOnlyInstancesOf(RouteInfo::class);
    });

    it(
        'can configure default scope collecting behavior',
        function (bool $include, int $expectedCount): void {
            config(['openapi.scope.default.include_routes_without_attribute' => $include]);
            Route::get('', ExplicitDefaultScopeController::class);
            Route::delete('', ExplicitDefaultScopeControllerAction::class);
            Route::put('', ImplicitDefaultScopeController::class);
            Route::post('', ExplicitOverriddenDefaultScopeControllerAction::class);
            /** @var RouteCollector $routeCollector */
            $routeCollector = app(RouteCollector::class);

            $routes = $routeCollector->whereShouldBeCollectedFor(Scope::DEFAULT);

            expect($routes->count())->toBe($expectedCount)
                ->and($routes)->toContainOnlyInstancesOf(RouteInfo::class);
        },
    )->with([
        'include routes without Scope attribute' => [true, 5],
        'do not include routes without Scope attribute' => [false, 3],
    ]);
})->covers(RouteCollector::class);
