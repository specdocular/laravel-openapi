<?php

namespace Specdocular\LaravelOpenAPI\Builders;

use Specdocular\LaravelOpenAPI\Support\RouteInfo;
use Specdocular\OpenAPI\Schema\Objects\PathItem\PathItem;
use Specdocular\OpenAPI\Schema\Objects\PathItem\Support\AvailableOperation;

final readonly class PathItemBuilder
{
    public function __construct(
        private OperationBuilder $operationBuilder,
        private ServerBuilder $serverBuilder,
        private ParametersBuilder $parametersBuilder,
    ) {
    }

    public function build(RouteInfo ...$routeInfo): PathItem
    {
        $operations = collect($routeInfo)
            ->map(
                function (RouteInfo $routeInfo): AvailableOperation {
                    return $this->operationBuilder->build($routeInfo);
                },
            )->all();

        $pathItem = PathItem::create()->operations(...$operations);

        $firstRouteInfo = $routeInfo[0];
        $attribute = $firstRouteInfo->pathItemAttribute();

        $pathItem = $pathItem->parameters(
            $this->parametersBuilder->buildForPathItem(
                $firstRouteInfo,
                $attribute?->parameters,
            ),
        );

        if (!is_null($attribute)) {
            if (!is_null($attribute->summary)) {
                $pathItem = $pathItem->summary($attribute->summary);
            }
            if (!is_null($attribute->description)) {
                $pathItem = $pathItem->description($attribute->description);
            }
            $pathItem = $pathItem->servers(...$this->serverBuilder->build(...$attribute->getServers()));
        }

        return $pathItem;
    }
}
