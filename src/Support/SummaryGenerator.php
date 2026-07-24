<?php

namespace Specdocular\LaravelOpenAPI\Support;

use Illuminate\Support\Str;

final readonly class SummaryGenerator
{
    public function generate(RouteInfo $routeInfo): string
    {
        $segments = collect(explode('/', $routeInfo->uri()))
            ->filter(static fn (string $segment): bool => '' !== $segment);

        $lastIsParameter = $segments->isNotEmpty()
            && $this->isParameter($segments->last());

        $resourceSegment = $segments
            ->reject(fn (string $segment): bool => $this->isParameter($segment))
            ->last() ?? 'resource';

        $collection = $this->humanize($resourceSegment);
        $item = $this->humanize(Str::singular($resourceSegment));

        return match (Str::lower($routeInfo->method())) {
            'get' => $lastIsParameter ? "Show {$item}" : "List {$collection}",
            'post' => "Create {$item}",
            'put', 'patch' => "Update {$item}",
            'delete' => "Delete {$item}",
            default => Str::ucfirst(Str::lower($routeInfo->method())) . " {$item}",
        };
    }

    private function isParameter(string $segment): bool
    {
        return Str::startsWith($segment, '{') && Str::endsWith($segment, '}');
    }

    private function humanize(string $segment): string
    {
        return Str::of($segment)->headline()->lower()->toString();
    }
}
