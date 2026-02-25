<?php

use Illuminate\Support\Facades\Route;
use Specdocular\LaravelOpenAPI\Support\ScopeMatcher;
use Specdocular\LaravelOpenAPI\Support\RouteInfo;
use Tests\Support\Doubles\Stubs\Objects\ControllerWithExtensions;

describe(class_basename(ScopeMatcher::class), function (): void {
    it('can check if route is in scope when action overrides controller', function (): void {
        // Default config: action_attribute_overrides_controller_attribute = true
        $routeInfo = RouteInfo::create(
            Route::get('/example', [ControllerWithExtensions::class, 'withExtensions']),
        );
        $matcher = new ScopeMatcher($routeInfo);

        expect($matcher->isInScope('action-collection'))->toBeTrue()
            ->and($matcher->isInScope('test'))->toBeFalse()
            ->and($matcher->isInScope('example'))->toBeFalse();
    });

    it('can check if route is in scope when action does not override controller', function (): void {
        config()->set('openapi.scope.action_attribute_overrides_controller_attribute', false);

        $routeInfo = RouteInfo::create(
            Route::get('/example', [ControllerWithExtensions::class, 'withExtensions']),
        );
        $matcher = new ScopeMatcher($routeInfo);

        expect($matcher->isInScope('action-collection'))->toBeTrue()
            ->and($matcher->isInScope('test'))->toBeTrue()
            ->and($matcher->isInScope('example'))->toBeTrue();
    });

    it('can check if route is in scope using controller attribute when action has none', function (): void {
        $routeInfo = RouteInfo::create(
            Route::get('/example', [ControllerWithExtensions::class, 'withoutExtensions']),
        );
        $matcher = new ScopeMatcher($routeInfo);

        expect($matcher->isInScope('test'))->toBeTrue()
            ->and($matcher->isInScope('example'))->toBeTrue()
            ->and($matcher->isInScope('non-existent'))->toBeFalse();
    });

    it('can check if route has scope attribute', function (): void {
        $routeInfo = RouteInfo::create(
            Route::get('/example', [ControllerWithExtensions::class, 'withExtensions']),
        );
        $matcher = new ScopeMatcher($routeInfo);

        expect($matcher->hasScopeAttribute())->toBeTrue();
    });

    it('returns false when route has no scope attribute', function (): void {
        $routeInfo = RouteInfo::create(
            Route::get('/example', static fn (): string => 'example'),
        );
        $matcher = new ScopeMatcher($routeInfo);

        expect($matcher->hasScopeAttribute())->toBeFalse();
    });

    it('can get all scope attributes', function (): void {
        $routeInfo = RouteInfo::create(
            Route::get('/example', [ControllerWithExtensions::class, 'withExtensions']),
        );
        $matcher = new ScopeMatcher($routeInfo);

        $scopes = $matcher->getScopeAttributes();

        expect($scopes)->toHaveCount(2);
    });
})->covers(ScopeMatcher::class);
