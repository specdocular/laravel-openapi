<?php

namespace Specdocular\LaravelOpenAPI\Builders;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Specdocular\LaravelOpenAPI\Support\OperationIdGenerator;
use Specdocular\LaravelOpenAPI\Support\PathTemplateExpander;
use Specdocular\LaravelOpenAPI\Support\RouteInfo;
use Specdocular\OpenAPI\Schema\Objects\Paths\Fields\Path;
use Specdocular\OpenAPI\Schema\Objects\Paths\Paths;

final readonly class PathsBuilder
{
    public function __construct(
        private PathItemBuilder $pathItemBuilder,
        private PathTemplateExpander $pathTemplateExpander,
        private OperationIdGenerator $operationIdGenerator,
    ) {
    }

    /**
     * @param Collection<int, RouteInfo> $routeInfo
     */
    public function build(Collection $routeInfo): Paths
    {
        $projected = $routeInfo->flatMap(
            function (RouteInfo $routeInfo): Collection {
                // An explicit operationId is a single developer-assigned identity that
                // every exploded variant would duplicate (invalid OAS), so suppress
                // trailing explosion for such routes — ADR 0146 Decision 2 amendment.
                // The signal is source-neutral: a native attribute id (kernel-visible)
                // OR an engine-injected docblock/compat id (ADR 0146 #397.9e).
                $explodeTrailingOptionals = is_null($routeInfo->explicitOperationId());

                return collect($this->pathTemplateExpander->expand($routeInfo->uri(), $explodeTrailingOptionals))
                    ->map(static fn (string $template): RouteInfo => $routeInfo->withUri($template));
            },
        );

        $this->assertDistinctOperationIds($projected);

        $paths = $projected->groupBy(
            static function (RouteInfo $routeInfo): string {
                return $routeInfo->uri();
            },
        )->map(
            function (Collection $routeInfo, string $url): Path {
                return Path::create(
                    $url,
                    $this->pathItemBuilder->build(...$routeInfo),
                );
            },
        )->values();

        return Paths::create(...$paths);
    }

    /**
     * OAS requires every operationId in a document to be unique. That invariant is
     * document-scoped, so it cannot be discharged by the route-scoped derivation in
     * OperationIdGenerator::generate — which is deliberately lossy for readability and
     * therefore not injective. ADR 0144's Decision 3 claimed otherwise and is RETIRED;
     * see its row #751 Amendment. The check runs on the PROJECTED route set so a
     * collision involving an exploded trailing-optional variant is caught too.
     *
     * Uniqueness ranges over OPERATIONS, and an operation's identity in the document is
     * its (verb, path) pair, so the id set is indexed by that identity. Two projected
     * routes sharing one identity are a single operation described twice — a violation of
     * route→(path, verb) injectivity, which the Operations map's own key assertion owns —
     * not two operations sharing an id, so they must not be reported as one here.
     *
     * The failure is a bare throw, NOT a `Webmozart\Assert` call: `Assert::isEmpty`'s
     * `$message` parameter is a printf FORMAT STRING (it is passed to `sprintf` with
     * `valueToString($value)` as the argument), and the reported operationId is
     * developer-controlled data. A `%`-bearing id therefore corrupts the message, and a
     * `%2$s`-bearing one raises `ArgumentCountError` — an `Error`, outside this guard's
     * documented failure type — purely as a function of the data being reported. The id is
     * not exotic: `Str::studly` does not strip `%`, so a plain route URI can derive one.
     * A bare throw of the same exception type is the package's idiom for a domain-message
     * failure (see Attributes\Extension and Console\SchemaFactoryMakeCommand); the
     * `Assert::` sites are type/contract checks on collaborators.
     *
     * @param Collection<int, RouteInfo> $projected
     */
    private function assertDistinctOperationIds(Collection $projected): void
    {
        $operationIds = $projected
            ->mapWithKeys(
                static fn (RouteInfo $routeInfo): array => [
                    Str::upper($routeInfo->method()) . ' ' . $routeInfo->uri() => $routeInfo,
                ],
            )
            ->map(fn (RouteInfo $routeInfo): string => $this->operationIdGenerator->resolve($routeInfo));

        // Keys are sorted so the reported collision does not depend on registration order.
        $collisions = $operationIds
            ->groupBy(static fn (string $operationId): string => $operationId, true)
            ->filter(static fn (Collection $operations): bool => $operations->count() > 1)
            ->sortKeys();

        if ($collisions->isEmpty()) {
            return;
        }

        /** @var Collection<string, string> $collision */
        $collision = $collisions->first();

        $message = 'Duplicate operationId [' . $collisions->keys()->first() . '] for operations ['
            . $collision->keys()->sort()->implode(', ') . ']. '
            . 'Set a distinct #[Operation(operationId: ...)] on one of them.';

        throw new \InvalidArgumentException($message);
    }
}
