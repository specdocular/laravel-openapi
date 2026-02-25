<?php

namespace Specdocular\LaravelOpenAPI\Support;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use Specdocular\LaravelOpenAPI\Attributes\Scope as ScopeAlias;
use Webmozart\Assert\Assert;

final readonly class RouteCollector
{
    public function __construct(
        private Router $router,
    ) {
    }

    /**
     * Get all routes that should be collected for the given scope.
     *
     * @param non-empty-string $scope
     *
     * @return Collection<int, RouteInfo>
     */
    public function whereShouldBeCollectedFor(string $scope): Collection
    {
        Assert::stringNotEmpty($scope);

        return $this->all()->filter(
            function (RouteInfo $routeInfo) use ($scope): bool {
                if (config()->boolean('openapi.scope.default.include_routes_without_attribute', false)) {
                    return (!$routeInfo->scope()->hasScopeAttribute() && $this->generatingDefaultScope($scope))
                        || $routeInfo->scope()->isInScope($scope);
                }

                return $routeInfo->scope()->isInScope($scope);
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

    private function generatingDefaultScope(string $scope): bool
    {
        return ScopeAlias::DEFAULT === $scope;
    }
}
