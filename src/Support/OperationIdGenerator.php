<?php

namespace Specdocular\LaravelOpenAPI\Support;

use Illuminate\Support\Str;

final readonly class OperationIdGenerator
{
    /**
     * The SOLE owner of the operationId precedence rule: an explicit id from any
     * source wins, otherwise the route's shape derives one.
     *
     * Both OperationBuilder::build (which emits the id) and the document-wide
     * uniqueness guard in PathsBuilder::build (which validates the id set) read
     * this, so the rule cannot be expressed twice at two different scopes —
     * ADR 0144 Amendment (row #751) item 3. It is pure and deterministic, so
     * evaluating it once per consumer cannot diverge.
     */
    public function resolve(RouteInfo $routeInfo): string
    {
        return $routeInfo->explicitOperationId() ?? $this->generate($routeInfo);
    }

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
