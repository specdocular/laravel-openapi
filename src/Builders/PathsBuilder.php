<?php

namespace Specdocular\LaravelOpenAPI\Builders;

use Illuminate\Support\Collection;
use Specdocular\LaravelOpenAPI\Support\RouteInfo;
use Specdocular\OpenAPI\Schema\Objects\Paths\Fields\Path;
use Specdocular\OpenAPI\Schema\Objects\Paths\Paths;

final readonly class PathsBuilder
{
    public function __construct(
        private PathItemBuilder $pathItemBuilder,
    ) {
    }

    /**
     * @param Collection<int, RouteInfo> $routeInfo
     */
    public function build(Collection $routeInfo): Paths
    {
        $paths = $routeInfo->groupBy(
            function (RouteInfo $routeInfo): string {
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
