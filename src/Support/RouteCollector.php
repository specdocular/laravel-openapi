<?php

namespace Specdocular\LaravelOpenAPI\Support;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use Specdocular\LaravelOpenAPI\Attributes\Document as DocumentAlias;
use Webmozart\Assert\Assert;

final readonly class RouteCollector
{
    public function __construct(
        private Router $router,
    ) {
    }

    /**
     * Get all routes that should be collected for the given document.
     *
     * @param non-empty-string $document
     *
     * @return Collection<int, RouteInfo>
     */
    public function whereShouldBeCollectedFor(string $document): Collection
    {
        Assert::stringNotEmpty($document);

        return $this->all()->filter(
            function (RouteInfo $routeInfo) use ($document): bool {
                if (config()->boolean('openapi.document.default.include_routes_without_attribute', false)) {
                    return (!$routeInfo->document()->hasDocumentAttribute() && $this->generatingDefaultDocument($document))
                        || $routeInfo->document()->isInDocument($document);
                }

                return $routeInfo->document()->isInDocument($document);
            },
        );
    }

    /** @return Collection<int, RouteInfo> */
    public function all(): Collection
    {
        return collect($this->router->getRoutes())
            ->filter(
                static function (Route $route): bool {
                    return 'Closure' !== $route->getActionName();
                },
            )->map(
                static function (Route $route): RouteInfo {
                    return RouteInfo::create($route);
                },
            );
    }

    private function generatingDefaultDocument(string $document): bool
    {
        return DocumentAlias::DEFAULT === $document;
    }
}
