<?php

namespace Specdocular\LaravelOpenAPI\Support;

use Composer\ClassMapGenerator\ClassMapGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Specdocular\LaravelOpenAPI\Attributes\Scope as ScopeAttribute;
use Specdocular\LaravelOpenAPI\Contracts\Interface\FilterStrategy;

final class ComponentCollector
{
    public function __construct(
        private array|null $paths = null,
        private FilterStrategy|null $filterStrategy = null,
    ) {
    }

    public function collect(string $scope): Collection
    {
        $generator = new ClassMapGenerator();
        foreach ($this->paths as $path) {
            $generator->scanPaths($path);
        }

        $classes = collect(array_keys($generator->getClassMap()->getMap()))
            ->sort()
            ->filter(function (string $class) use ($scope): bool {
                $reflectionClass = new \ReflectionClass($class);
                $attributes = $reflectionClass->getAttributes(ScopeAttribute::class);

                if (ScopeAttribute::DEFAULT === $scope && blank($attributes)) {
                    return true;
                }

                if (blank($attributes)) {
                    return false;
                }

                /** @var ScopeAttribute $scopeAttribute */
                $scopeAttribute = $attributes[0]->newInstance();
                $scopes = Arr::wrap($scopeAttribute->name);

                return ['*'] === $scopes
                    || in_array(
                        $scope,
                        when(filled($scopes), $scopes, []),
                        true,
                    );
            });

        if ($this->filterStrategy instanceof FilterStrategy) {
            $classes = $this->filterStrategy->apply($classes);
        }

        return $classes
            ->map(static function (string $factory) {
                return app($factory);
            })->values();
    }

    public function use(FilterStrategy $filterStrategy): self
    {
        $clone = clone $this;

        $clone->filterStrategy = $filterStrategy;

        return $clone;
    }

    public function in(array $paths): self
    {
        $clone = clone $this;

        $clone->paths = $paths;

        return $clone;
    }
}
