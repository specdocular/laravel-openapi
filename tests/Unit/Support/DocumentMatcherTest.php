<?php

use Illuminate\Support\Facades\Route;
use Specdocular\LaravelOpenAPI\Support\DocumentMatcher;
use Specdocular\LaravelOpenAPI\Support\RouteInfo;
use Tests\Support\Doubles\Stubs\Objects\ControllerWithExtensions;

describe(class_basename(DocumentMatcher::class), function (): void {
    it('can check if route is in document when action overrides controller', function (): void {
        // Default config: action_attribute_overrides_controller_attribute = true
        $routeInfo = RouteInfo::create(
            Route::get('/example', [ControllerWithExtensions::class, 'withExtensions']),
        );
        $matcher = new DocumentMatcher($routeInfo);

        expect($matcher->isInDocument('action-collection'))->toBeTrue()
            ->and($matcher->isInDocument('test'))->toBeFalse()
            ->and($matcher->isInDocument('example'))->toBeFalse();
    });

    it('can check if route is in document when action does not override controller', function (): void {
        config()->set('openapi.document.action_attribute_overrides_controller_attribute', false);

        $routeInfo = RouteInfo::create(
            Route::get('/example', [ControllerWithExtensions::class, 'withExtensions']),
        );
        $matcher = new DocumentMatcher($routeInfo);

        expect($matcher->isInDocument('action-collection'))->toBeTrue()
            ->and($matcher->isInDocument('test'))->toBeTrue()
            ->and($matcher->isInDocument('example'))->toBeTrue();
    });

    it('can check if route is in document using controller attribute when action has none', function (): void {
        $routeInfo = RouteInfo::create(
            Route::get('/example', [ControllerWithExtensions::class, 'withoutExtensions']),
        );
        $matcher = new DocumentMatcher($routeInfo);

        expect($matcher->isInDocument('test'))->toBeTrue()
            ->and($matcher->isInDocument('example'))->toBeTrue()
            ->and($matcher->isInDocument('non-existent'))->toBeFalse();
    });

    it('can check if route has document attribute', function (): void {
        $routeInfo = RouteInfo::create(
            Route::get('/example', [ControllerWithExtensions::class, 'withExtensions']),
        );
        $matcher = new DocumentMatcher($routeInfo);

        expect($matcher->hasDocumentAttribute())->toBeTrue();
    });

    it('returns false when route has no document attribute', function (): void {
        $routeInfo = RouteInfo::create(
            Route::get('/example', static fn (): string => 'example'),
        );
        $matcher = new DocumentMatcher($routeInfo);

        expect($matcher->hasDocumentAttribute())->toBeFalse();
    });

    it('can get all document attributes', function (): void {
        $routeInfo = RouteInfo::create(
            Route::get('/example', [ControllerWithExtensions::class, 'withExtensions']),
        );
        $matcher = new DocumentMatcher($routeInfo);

        $documents = $matcher->getDocumentAttributes();

        expect($documents)->toHaveCount(2);
    });
})->covers(DocumentMatcher::class);
