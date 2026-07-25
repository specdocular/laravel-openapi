<?php

use Illuminate\Support\Facades\Route;
use Specdocular\LaravelOpenAPI\Support\OperationIdGenerator;
use Specdocular\LaravelOpenAPI\Support\RouteInfo;
use Tests\Support\Doubles\Stubs\Builders\ControllerWithExplicitOperationIdStub;

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

    // CHARACTERIZATION — this pins a RULED DECISION, not an accident, and it is not a
    // test of Str::studly (the framework owns that). ADR 0144 Amendment (row #751) item 1
    // RETAINED Decision 2's lossy derivation deliberately: the id is an intention-revealing
    // SDK-method name, and making the transform injective would degrade every id in the
    // document to encode a separator/case distinction the author's own API surface treats
    // as noise. Uniqueness is therefore NOT the derivation's job — it is a document-scoped
    // invariant asserted in PathsBuilder::build. Do not "fix" this collision.
    it('deliberately derives ONE id for URIs differing only by separator or case (uniqueness is the document invariant, not the derivation)', function (): void {
        $hyphenated = RouteInfo::create(Route::get('blog-posts', static fn (): string => ''));
        $underscored = RouteInfo::create(Route::get('blog_posts', static fn (): string => ''));

        expect((new OperationIdGenerator())->generate($hyphenated))->toBe('getBlogPosts')
            ->and((new OperationIdGenerator())->generate($underscored))->toBe('getBlogPosts');
    });

    // resolve() is the SINGLE OWNER of the operationId precedence rule — ADR 0144
    // Amendment (row #751) item 3. Both OperationBuilder::build and the document-wide
    // uniqueness guard in PathsBuilder::build read it, so one rule has one home.
    describe('resolve (single owner of the precedence rule, ADR 0144 Amendment row #751)', function (): void {
        it('falls back to the derived id when no explicit id exists from any source', function (): void {
            $routeInfo = RouteInfo::create(Route::get('api/users/{id}', static fn (): string => ''));

            expect((new OperationIdGenerator())->resolve($routeInfo))->toBe('getApiUsersById');
        });

        it('returns the native attribute id in preference to the derived id', function (): void {
            $routeInfo = RouteInfo::create(
                Route::get('/example', ControllerWithExplicitOperationIdStub::class),
            );

            expect((new OperationIdGenerator())->resolve($routeInfo))->toBe('fixedOperationId');
        });

        it('returns the engine-injected id in preference to the derived id', function (): void {
            $routeInfo = RouteInfo::create(
                Route::get('/example', static fn (): string => ''),
            )->withExplicitOperationId('injectedId');

            expect((new OperationIdGenerator())->resolve($routeInfo))->toBe('injectedId');
        });
    });
})->covers(OperationIdGenerator::class);
