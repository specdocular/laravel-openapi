<?php

namespace Specdocular\LaravelOpenAPI\Support;

use Illuminate\Support\Str;
use Webmozart\Assert\Assert;

/**
 * Projects a raw Laravel URI template into the set of OAS-legal path templates.
 *
 * A Laravel optional path parameter (`{opt?}`) has no OpenAPI equivalent — OAS
 * models an omittable trailing segment as separate paths. So the maximal
 * TRAILING run of optional segments explodes into one present-prefix template
 * per combination; an INTERIOR optional (followed by a required segment) has no
 * coherent absent-form URL and is normalized to required. Every emitted template
 * is `?`-free — this class is the sole owner of that rule (ADR 0146).
 *
 * Trailing explosion is a guarded operation: it is valid only when the route's
 * identity is derived (each variant gets a distinct operationId). When the caller
 * passes $explodeTrailingOptionals = false (the route carries an explicit
 * operationId, which every variant would duplicate), the trailing run is
 * normalized to required instead of exploded, yielding a single template.
 */
final readonly class PathTemplateExpander
{
    /** @return list<string> */
    public function expand(string $rawUri, bool $explodeTrailingOptionals = true): array
    {
        $segments = array_values(array_filter(explode('/', $rawUri), static fn (string $segment): bool => '' !== $segment));

        $trailingOptionalCount = $explodeTrailingOptionals ? $this->trailingOptionalCount($segments) : 0;
        $fixedCount = count($segments) - $trailingOptionalCount;

        $fixed = array_map(
            fn (string $segment): string => $this->strip($segment),
            array_slice($segments, 0, $fixedCount),
        );
        $trailing = array_slice($segments, $fixedCount);

        $templates = [];
        for ($present = 0; $present <= $trailingOptionalCount; ++$present) {
            $variant = array_merge(
                $fixed,
                array_map(fn (string $segment): string => $this->strip($segment), array_slice($trailing, 0, $present)),
            );
            $templates[] = $this->assertLegal(Str::start(implode('/', $variant), '/'));
        }

        return $templates;
    }

    /** @param list<string> $segments */
    private function trailingOptionalCount(array $segments): int
    {
        $count = 0;
        for ($index = count($segments) - 1; $index >= 0; --$index) {
            if (!$this->isOptional($segments[$index])) {
                break;
            }
            ++$count;
        }

        return $count;
    }

    private function isOptional(string $segment): bool
    {
        return 1 === preg_match('/^\{.+\?}$/', $segment);
    }

    private function strip(string $segment): string
    {
        return str_replace('?}', '}', $segment);
    }

    private function assertLegal(string $template): string
    {
        Assert::false(str_contains($template, '?'), "Path template [{$template}] must not contain the optional marker.");

        return $template;
    }
}
