<?php

use Illuminate\Support\Facades\Route;
use Specdocular\LaravelOpenAPI\Support\OperationIdGenerator;
use Specdocular\LaravelOpenAPI\Support\RouteInfo;

describe(class_basename(OperationIdGenerator::class), function (): void {
    it('derives a camelCase id from verb + literal URI segments', function (): void {
        $routeInfo = RouteInfo::create(Route::post('users', static fn (): string => ''));

        expect((new OperationIdGenerator())->generate($routeInfo))->toBe('postUsers');
    });

    it('prefixes a path parameter segment with "By" so it stays distinct from a literal', function (): void {
        $paramRoute = RouteInfo::create(Route::get('api/users/{id}', static fn (): string => ''));
        $literalRoute = RouteInfo::create(Route::get('api/users/id', static fn (): string => ''));

        expect((new OperationIdGenerator())->generate($paramRoute))->toBe('getApiUsersById')
            ->and((new OperationIdGenerator())->generate($literalRoute))->toBe('getApiUsersId');
    });

    it('strips the optional-parameter "?" marker', function (): void {
        $routeInfo = RouteInfo::create(Route::get('api/users/{id?}', static fn (): string => ''));

        expect((new OperationIdGenerator())->generate($routeInfo))->toBe('getApiUsersById');
    });

    it('walks every segment of a nested multi-parameter path', function (): void {
        $routeInfo = RouteInfo::create(Route::get('api/users/{user}/posts/{post}', static fn (): string => ''));

        expect((new OperationIdGenerator())->generate($routeInfo))->toBe('getApiUsersByUserPostsByPost');
    });

    it('falls back to the bare verb for the root path', function (): void {
        $routeInfo = RouteInfo::create(Route::get('/', static fn (): string => ''));

        expect((new OperationIdGenerator())->generate($routeInfo))->toBe('get');
    });
})->covers(OperationIdGenerator::class);
