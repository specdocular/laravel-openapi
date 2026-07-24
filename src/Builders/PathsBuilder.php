<?php

namespace Specdocular\LaravelOpenAPI\Builders;

use Illuminate\Support\Collection;
use Specdocular\LaravelOpenAPI\Support\PathTemplateExpander;
use Specdocular\LaravelOpenAPI\Support\RouteInfo;
use Specdocular\OpenAPI\Schema\Objects\Paths\Fields\Path;
use Specdocular\OpenAPI\Schema\Objects\Paths\Paths;

final readonly class PathsBuilder
{
    public function __construct(
        private PathItemBuilder $pathItemBuilder,
        private PathTemplateExpander $pathTemplateExpander,
    ) {
    }

    /**
     * @param Collection<int, RouteInfo> $routeInfo
     */
    public function build(Collection $routeInfo): Paths
    {
        $paths = $routeInfo->flatMap(
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
        )->groupBy(
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
}
