<?php

namespace Specdocular\LaravelOpenAPI\Builders\ComponentsBuilder\FilterStrategies;

use Illuminate\Support\Collection;
use Specdocular\LaravelOpenAPI\Contracts\Interface\FilterStrategy;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;

final readonly class ComponentFilter implements FilterStrategy
{
    /**
     * @param class-string $factoryClass
     */
    public function __construct(
        private string $factoryClass,
    ) {
    }

    public function apply(Collection $data): Collection
    {
        return $data->filter(
            fn (string $class): bool => is_a($class, $this->factoryClass, true)
                && is_a($class, ShouldBeReferenced::class, true),
        );
    }
}
