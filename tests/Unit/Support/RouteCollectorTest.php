<?php

use Illuminate\Support\Facades\Route;
use Specdocular\LaravelOpenAPI\Attributes\Document;
use Specdocular\LaravelOpenAPI\Support\RouteCollector;
use Specdocular\LaravelOpenAPI\Support\RouteInfo;
use Tests\Support\Doubles\Stubs\Builders\ControllerWithPathItemAndOperationStub;
use Tests\Support\Doubles\Stubs\CollectibleClass;
use Tests\Support\Doubles\Stubs\Objects\ExplicitDefaultDocumentController;
use Tests\Support\Doubles\Stubs\Objects\ExplicitDefaultDocumentControllerAction;
use Tests\Support\Doubles\Stubs\Objects\ExplicitOverriddenDefaultDocumentControllerAction;
use Tests\Support\Doubles\Stubs\Objects\ImplicitDefaultDocumentController;

describe(class_basename(RouteCollector::class), function (): void {
    it('can filter routes by document', function (): void {
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
        'can configure default document collecting behavior',
        function (bool $include, int $expectedCount): void {
            config(['openapi.document.default.include_routes_without_attribute' => $include]);
            Route::get('', ExplicitDefaultDocumentController::class);
            Route::delete('', ExplicitDefaultDocumentControllerAction::class);
            Route::put('', ImplicitDefaultDocumentController::class);
            Route::post('', ExplicitOverriddenDefaultDocumentControllerAction::class);
            /** @var RouteCollector $routeCollector */
            $routeCollector = app(RouteCollector::class);

            $routes = $routeCollector->whereShouldBeCollectedFor(Document::DEFAULT);

            expect($routes->count())->toBe($expectedCount)
                ->and($routes)->toContainOnlyInstancesOf(RouteInfo::class);
        },
    )->with([
        'include routes without Document attribute' => [true, 5],
        'do not include routes without Document attribute' => [false, 3],
    ]);
})->covers(RouteCollector::class);
