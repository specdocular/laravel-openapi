<?php

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Specdocular\LaravelOpenAPI\Builders\PathsBuilder;
use Specdocular\LaravelOpenAPI\Support\RouteCollector;
use Specdocular\LaravelOpenAPI\Support\RouteInfo;
use Specdocular\OpenAPI\Schema\Objects\Paths\Paths;
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

    // Document-wide operationId uniqueness — ADR 0144 Amendment (row #751). The retired
    // Decision 3 tried to discharge this at the derivation, which is route-scoped and so
    // provably cannot: the constraint ranges over the UNION of derived and explicit ids.
    // The guard runs over the POST-explosion route set so a collision involving an
    // exploded variant is caught too.
    describe('document-wide operationId uniqueness (ADR 0144 Amendment row #751)', function (): void {
        it('rejects a document whose operations do not have distinct operationIds', function (Collection $routes, string $message): void {
            expect(fn (): Paths => app(PathsBuilder::class)->build($routes))
                ->toThrow(InvalidArgumentException::class, $message);
        })->with([
            // (a) intra-segment separator: Str::studly discards `-` and `_`.
            'separator collapse' => fn (): array => [
                'routes' => collect([
                    RouteInfo::create(Route::get('blog-posts', static fn (): string => '')),
                    RouteInfo::create(Route::get('blog_posts', static fn (): string => '')),
                ]),
                'message' => 'Duplicate operationId [getBlogPosts] for operations [GET /blog-posts, GET /blog_posts].'
                    . ' Set a distinct #[Operation(operationId: ...)] on one of them.',
            ],
            // (b) letter case: Str::studly discards case. Laravel's router preserves URI
            // case on registration, so both templates genuinely reach PathsBuilder.
            'case collapse' => fn (): array => [
                'routes' => collect([
                    RouteInfo::create(Route::get('Users', static fn (): string => '')),
                    RouteInfo::create(Route::get('users', static fn (): string => '')),
                ]),
                'message' => 'Duplicate operationId [getUsers] for operations [GET /Users, GET /users].'
                    . ' Set a distinct #[Operation(operationId: ...)] on one of them.',
            ],
            // (c) segment-boundary loss: the `/` separator carries no signal into the id,
            // so a two-segment path and a one-segment hyphenated path fold together.
            'segment-boundary loss' => fn (): array => [
                'routes' => collect([
                    RouteInfo::create(Route::get('a/b', static fn (): string => '')),
                    RouteInfo::create(Route::get('a-b', static fn (): string => '')),
                ]),
                'message' => 'Duplicate operationId [getAB] for operations [GET /a-b, GET /a/b].'
                    . ' Set a distinct #[Operation(operationId: ...)] on one of them.',
            ],
            // (d) THE LOAD-BEARING CASE: two explicit ids collide with no involvement of
            // Str::studly at all. This is what falsifies the retired Decision 3 on its own
            // terms — an injective derivation would not have prevented it.
            'duplicate explicit id' => fn (): array => [
                'routes' => collect([
                    RouteInfo::create(Route::get('first', static fn (): string => ''))
                        ->withExplicitOperationId('sameId'),
                    RouteInfo::create(Route::get('second', static fn (): string => ''))
                        ->withExplicitOperationId('sameId'),
                ]),
                'message' => 'Duplicate operationId [sameId] for operations [GET /first, GET /second].'
                    . ' Set a distinct #[Operation(operationId: ...)] on one of them.',
            ],
        ]);

        // The reported id is developer-controlled data, and `Str::studly` does not strip `%`
        // (`studly('a%b') === 'A%b'`), so a `%`-bearing id is reachable BOTH from an explicit
        // pin and from a plain route URI. A `%2$s` sequence is the strongest case: routed
        // through `sprintf` it raises ArgumentCountError — an Error, not an Exception — so the
        // guard would escape its own documented failure type on legal input.
        it('reports a %-bearing operationId verbatim, without routing it through a format string', function (): void {
            $routes = collect([
                RouteInfo::create(Route::get('first', static fn (): string => ''))
                    ->withExplicitOperationId('get%2$sUsers'),
                RouteInfo::create(Route::get('second', static fn (): string => ''))
                    ->withExplicitOperationId('get%2$sUsers'),
            ]);

            expect(fn (): Paths => app(PathsBuilder::class)->build($routes))
                ->toThrow(
                    InvalidArgumentException::class,
                    'Duplicate operationId [get%2$sUsers] for operations [GET /first, GET /second].'
                    . ' Set a distinct #[Operation(operationId: ...)] on one of them.',
                );
        });

        // Two INDEPENDENT collision groups in one document. `getAaa` sorts before `getZzz`
        // but is registered SECOND, so an implementation reporting the first collision it
        // encounters would name `getZzz` and fail here — the assertion discriminates the
        // sortKeys() ordering, not merely the presence of a collision.
        it('reports the alphabetically-first colliding group when a document has several', function (): void {
            $routes = collect([
                RouteInfo::create(Route::get('zzz-items', static fn (): string => '')),
                RouteInfo::create(Route::get('zzz_items', static fn (): string => '')),
                RouteInfo::create(Route::get('aaa-items', static fn (): string => '')),
                RouteInfo::create(Route::get('aaa_items', static fn (): string => '')),
            ]);

            expect(fn (): Paths => app(PathsBuilder::class)->build($routes))
                ->toThrow(
                    InvalidArgumentException::class,
                    'Duplicate operationId [getAaaItems] for operations [GET /aaa-items, GET /aaa_items].'
                    . ' Set a distinct #[Operation(operationId: ...)] on one of them.',
                );
        });

        it('accepts a document whose operationIds are all distinct', function (): void {
            $routes = collect([
                RouteInfo::create(Route::get('blog-posts', static fn (): string => '')),
                RouteInfo::create(Route::post('blog-posts', static fn (): string => '')),
                RouteInfo::create(Route::get('comments/{comment?}', static fn (): string => '')),
            ]);

            $paths = app(PathsBuilder::class)->build($routes);

            expect($paths->compile())->toHaveKeys(['/blog-posts', '/comments', '/comments/{comment}']);
        });

        // BOUNDARY PIN — follow-up trio round, row #751. Two routes projecting onto the
        // SAME (verb, uri) are ONE operation identity described twice, not two operations
        // sharing an id, so this is NOT an operationId-uniqueness violation. It violates a
        // DIFFERENT invariant — route→(path, verb) injectivity — already enforced
        // structurally by php-openapi's Operations key assertion. Reporting it in this
        // guard's vocabulary would emit a false statement. Row #752 owns making that
        // failure legible; this test stops the guard being widened to annex it.
        it('leaves a same-(verb, uri) duplicate to the path-key invariant, without claiming an operationId collision', function (): void {
            $routes = collect([
                RouteInfo::create(Route::get('comments/{comment?}', static fn (): string => '')),
                RouteInfo::create(Route::get('comments', static fn (): string => '')),
            ]);

            expect(fn (): Paths => app(PathsBuilder::class)->build($routes))
                ->toThrow(InvalidArgumentException::class)
                ->and(fn (): Paths => app(PathsBuilder::class)->build($routes))
                ->not->toThrow(InvalidArgumentException::class, 'Duplicate operationId');
        });
    });
})->covers(PathsBuilder::class);
