<?php

namespace Specdocular\LaravelOpenAPI\Support;

use Composer\ClassMapGenerator\ClassMapGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Specdocular\LaravelOpenAPI\Attributes\Document as DocumentAttribute;
use Specdocular\LaravelOpenAPI\Contracts\Interface\FilterStrategy;

final class ComponentCollector
{
    public function __construct(
        private array|null $paths = null,
        private FilterStrategy|null $filterStrategy = null,
    ) {
    }

    public function collect(string $document): Collection
    {
        $generator = new ClassMapGenerator();
        foreach ($this->paths as $path) {
            $generator->scanPaths($path);
        }

        $classes = collect(array_keys($generator->getClassMap()->getMap()))
            ->sort()
            ->filter(function (string $class) use ($document): bool {
                $reflectionClass = new \ReflectionClass($class);
                $attributes = $reflectionClass->getAttributes(DocumentAttribute::class);

                if (DocumentAttribute::DEFAULT === $document && blank($attributes)) {
                    return true;
                }

                if (blank($attributes)) {
                    return false;
                }

                /** @var DocumentAttribute $documentAttribute */
                $documentAttribute = $attributes[0]->newInstance();
                $documents = Arr::wrap($documentAttribute->name);

                return ['*'] === $documents
                    || in_array(
                        $document,
                        when(filled($documents), $documents, []),
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
