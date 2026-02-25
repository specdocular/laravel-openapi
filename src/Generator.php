<?php

namespace Specdocular\LaravelOpenAPI;

use Specdocular\LaravelOpenAPI\Builders\ComponentsBuilder\ComponentsBuilder;
use Specdocular\LaravelOpenAPI\Builders\PathsBuilder;
use Specdocular\LaravelOpenAPI\Factories\OpenAPIFactory;
use Specdocular\LaravelOpenAPI\Support\RouteCollector;
use Specdocular\OpenAPI\Schema\Objects\Components\Components;
use Specdocular\OpenAPI\Schema\Objects\OpenAPI\OpenAPI;
use Webmozart\Assert\Assert;

final readonly class Generator
{
    public function __construct(
        private ComponentsBuilder $componentsBuilder,
        private PathsBuilder $pathsBuilder,
        private RouteCollector $routeCollector,
    ) {
    }

    public function generate(string|null $scope = Attributes\Scope::DEFAULT): OpenAPI
    {
        /** @var class-string<OpenAPIFactory> $openApiFactory */
        $openApiFactory = config()->string('openapi.scopes.' . $scope . '.openapi');
        Assert::isAOf($openApiFactory, OpenAPIFactory::class);

        if (is_null($scope)) {
            $routes = $this->routeCollector->all();
        } else {
            $routes = $this->routeCollector->whereShouldBeCollectedFor($scope);
        }

        $paths = $this->pathsBuilder->build($routes);

        $openApi = $openApiFactory::create()->paths($paths);

        $components = $this->componentsBuilder->build($scope);
        if ($components instanceof Components) {
            return $openApi->components($components);
        }

        return $openApi;
    }
}
