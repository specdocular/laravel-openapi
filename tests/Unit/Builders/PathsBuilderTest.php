<?php

use Illuminate\Support\Facades\Route;
use Specdocular\LaravelOpenAPI\Builders\PathsBuilder;
use Specdocular\LaravelOpenAPI\Support\RouteCollector;
use Specdocular\LaravelOpenAPI\Support\RouteInfo;
use Tests\Support\Doubles\Stubs\Builders\ControllerWithExplicitOperationIdStub;
use Tests\Support\Doubles\Stubs\Builders\ControllerWithPathItemAndOperationStub;

describe(class_basename(PathsBuilder::class), function (): void {
    it('can be created', function (): void {
        Route::get('/has-both-pathItem-and-operation', ControllerWithPathItemAndOperationStub::class);
        $routeCollector = app(RouteCollector::class);
        $routeInfo = $routeCollector->whereShouldBeCollectedFor('Another');
        $pathsBuilder = app(PathsBuilder::class);

        $paths = $pathsBuilder->build($routeInfo);

        expect($paths->compile())->toHaveCount(1)
            ->and($paths->compile()['/has-both-pathItem-and-operation'])
            ->toHaveKey('get');
    });

    it('explodes a trailing optional parameter into present-prefix path keys', function (): void {
        Route::get('/example/{id?}', ControllerWithPathItemAndOperationStub::class);
        $routeCollector = app(RouteCollector::class);
        $routeInfo = $routeCollector->whereShouldBeCollectedFor('Another');
        $pathsBuilder = app(PathsBuilder::class);

        $paths = $pathsBuilder->build($routeInfo);

        expect($paths->compile())->toHaveKeys(['/example', '/example/{id}'])
            ->and($paths->compile())->not->toHaveKey('/example/{id?}');
    });

    it('suppresses explosion for a route with an explicit operationId', function (): void {
        Route::get('/comments/{comment?}', ControllerWithExplicitOperationIdStub::class);
        $routeCollector = app(RouteCollector::class);
        $routeInfo = $routeCollector->whereShouldBeCollectedFor('Another');
        $pathsBuilder = app(PathsBuilder::class);

        $paths = $pathsBuilder->build($routeInfo);

        expect($paths->compile())->toHaveKey('/comments/{comment}')
            ->and($paths->compile())->not->toHaveKey('/comments')
            ->and($paths->compile())->toHaveCount(1);
    });

    it('suppresses explosion for a route with an engine-injected explicit operationId', function (): void {
        $routeInfo = RouteInfo::create(Route::get('/comments/{comment?}', static fn (): string => ''))
            ->withExplicitOperationId('injectedId');
        $pathsBuilder = app(PathsBuilder::class);

        $paths = $pathsBuilder->build(collect([$routeInfo]));

        expect($paths->compile())->toHaveKey('/comments/{comment}')
            ->and($paths->compile())->not->toHaveKey('/comments')
            ->and($paths->compile())->toHaveCount(1);
    });

    it('still explodes a trailing-optional route with no explicit operationId from any source', function (): void {
        $routeInfo = RouteInfo::create(Route::get('/comments/{comment?}', static fn (): string => ''));
        $pathsBuilder = app(PathsBuilder::class);

        $paths = $pathsBuilder->build(collect([$routeInfo]));

        expect($paths->compile())->toHaveKeys(['/comments', '/comments/{comment}'])
            ->and($paths->compile())->toHaveCount(2);
    });
})->covers(PathsBuilder::class);
