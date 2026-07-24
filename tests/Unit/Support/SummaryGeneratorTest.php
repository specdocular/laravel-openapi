<?php

use Illuminate\Support\Facades\Route;
use Specdocular\LaravelOpenAPI\Support\RouteInfo;
use Specdocular\LaravelOpenAPI\Support\SummaryGenerator;

describe(class_basename(SummaryGenerator::class), function (): void {
    it('derives "List <resource>" for a GET on a collection tail', function (): void {
        $routeInfo = RouteInfo::create(Route::get('api/users', static fn (): string => ''));

        expect((new SummaryGenerator())->generate($routeInfo))->toBe('List users');
    });

    it('derives "Show <resource>" (singular) for a GET on an item tail', function (): void {
        $routeInfo = RouteInfo::create(Route::get('api/users/{id}', static fn (): string => ''));

        expect((new SummaryGenerator())->generate($routeInfo))->toBe('Show user');
    });

    it('derives "Create <resource>" (singular) for a POST', function (): void {
        $routeInfo = RouteInfo::create(Route::post('api/users', static fn (): string => ''));

        expect((new SummaryGenerator())->generate($routeInfo))->toBe('Create user');
    });

    it('derives "Update <resource>" (singular) for PUT and PATCH', function (): void {
        $put = RouteInfo::create(Route::put('api/users/{id}', static fn (): string => ''));
        $patch = RouteInfo::create(Route::patch('api/users/{id}', static fn (): string => ''));

        expect((new SummaryGenerator())->generate($put))->toBe('Update user')
            ->and((new SummaryGenerator())->generate($patch))->toBe('Update user');
    });

    it('derives "Delete <resource>" (singular) for a DELETE', function (): void {
        $routeInfo = RouteInfo::create(Route::delete('api/users/{id}', static fn (): string => ''));

        expect((new SummaryGenerator())->generate($routeInfo))->toBe('Delete user');
    });

    it('uses the last non-parameter segment as the resource', function (): void {
        $routeInfo = RouteInfo::create(Route::get('api/users/{user}/posts', static fn (): string => ''));

        expect((new SummaryGenerator())->generate($routeInfo))->toBe('List posts');
    });

    it('humanizes a multi-word resource segment', function (): void {
        $routeInfo = RouteInfo::create(Route::post('api/blog-posts', static fn (): string => ''));

        expect((new SummaryGenerator())->generate($routeInfo))->toBe('Create blog post');
    });
})->covers(SummaryGenerator::class);
