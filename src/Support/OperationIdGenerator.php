<?php

namespace Specdocular\LaravelOpenAPI\Support;

use Illuminate\Support\Str;

final readonly class OperationIdGenerator
{
    public function generate(RouteInfo $routeInfo): string
    {
        $segments = collect(explode('/', $routeInfo->uri()))
            ->filter(static fn (string $segment): bool => '' !== $segment)
            ->map(static function (string $segment): string {
                if (Str::startsWith($segment, '{') && Str::endsWith($segment, '}')) {
                    $parameter = rtrim(Str::between($segment, '{', '}'), '?');

                    return 'By' . Str::studly($parameter);
                }

                return Str::studly($segment);
            })
            ->implode('');

        return Str::lower($routeInfo->method()) . $segments;
    }
}
