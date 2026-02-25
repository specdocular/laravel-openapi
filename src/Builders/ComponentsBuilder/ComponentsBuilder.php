<?php

namespace Specdocular\LaravelOpenAPI\Builders\ComponentsBuilder;

use Illuminate\Support\Collection;
use Specdocular\LaravelOpenAPI\Builders\ComponentsBuilder\FilterStrategies\ComponentFilter;
use Specdocular\LaravelOpenAPI\Support\ComponentCollector;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\CallbackFactory;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\ExampleFactory;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\HeaderFactory;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\LinkFactory;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\ParameterFactory;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\PathItemFactory;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\RequestBodyFactory;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\ResponseFactory;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\SchemaFactory;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use Specdocular\OpenAPI\Schema\Objects\Components\Components;

final readonly class ComponentsBuilder
{
    public function __construct(
        private ComponentCollector $componentCollector,
    ) {
    }

    public function build(string $scope): Components|null
    {
        $componentTypes = [
            'schemas' => SchemaFactory::class,
            'responses' => ResponseFactory::class,
            'parameters' => ParameterFactory::class,
            'examples' => ExampleFactory::class,
            'request_bodies' => RequestBodyFactory::class,
            'headers' => HeaderFactory::class,
            'security_schemes' => SecuritySchemeFactory::class,
            'links' => LinkFactory::class,
            'callbacks' => CallbackFactory::class,
            'path_items' => PathItemFactory::class,
        ];

        $collected = [];
        foreach ($componentTypes as $configKey => $factoryClass) {
            $collected[$configKey] = $this->componentCollector
                ->in($this->getPathsFromConfig($scope, $configKey))
                ->use(new ComponentFilter($factoryClass))
                ->collect($scope);
        }

        $components = Components::create();
        $hasAnyObjects = false;

        foreach ($collected as $configKey => $items) {
            if ($items->isEmpty()) {
                continue;
            }

            $hasAnyObjects = true;
            $components = match ($configKey) {
                'schemas' => $components->schemas(...$items),
                'responses' => $components->responses(...$items),
                'parameters' => $components->parameters(...$items),
                'examples' => $components->examples(...$items),
                'request_bodies' => $components->requestBodies(...$items),
                'headers' => $components->headers(...$items),
                'security_schemes' => $components->securitySchemes(...$items),
                'links' => $components->links(...$items),
                'callbacks' => $components->callbacks(...$items),
                'path_items' => $components->pathItems(...$items),
            };
        }

        return $hasAnyObjects ? $components : null;
    }

    private function getPathsFromConfig(string $scope, string $type): array
    {
        $paths = config("openapi.scopes.{$scope}.components.{$type}", []);

        foreach ($paths as &$path) {
            $path = glob($path, GLOB_ONLYDIR) ?: [];
        }

        return Collection::make($paths)
            ->flatten()
            ->unique()
            ->toArray();
    }
}
