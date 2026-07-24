<?php

use Specdocular\LaravelOpenAPI\Support\PathTemplateExpander;

describe(class_basename(PathTemplateExpander::class), function (): void {
    it(
        'expands a raw Laravel template into OAS-legal path templates',
        function (string $rawUri, array $expected): void {
            $expander = new PathTemplateExpander();

            expect($expander->expand($rawUri))->toBe($expected);
        },
    )->with([
        'no parameters' => [
            '/example',
            ['/example'],
        ],
        'single required parameter' => [
            '/example/{id}',
            ['/example/{id}'],
        ],
        'single trailing optional explodes into two' => [
            '/example/{id?}',
            ['/example', '/example/{id}'],
        ],
        'multiple trailing optionals explode into a present-prefix chain' => [
            '/example/{a?}/{b?}',
            ['/example', '/example/{a}', '/example/{a}/{b}'],
        ],
        'interior optional is normalized to required, not exploded' => [
            '/example/{a?}/{b}',
            ['/example/{a}/{b}'],
        ],
        'interior optional normalized while trailing optional explodes' => [
            '/example/{a?}/{b}/{c?}',
            ['/example/{a}/{b}', '/example/{a}/{b}/{c}'],
        ],
        'root-level trailing optional' => [
            '/{id?}',
            ['/', '/{id}'],
        ],
    ]);

    it(
        'normalizes to a single required template when trailing explosion is suppressed',
        function (string $rawUri, array $expected): void {
            $expander = new PathTemplateExpander();

            expect($expander->expand($rawUri, false))->toBe($expected);
        },
    )->with([
        'trailing optional collapses to required' => [
            '/comments/{comment?}',
            ['/comments/{comment}'],
        ],
        'multiple trailing optionals all collapse to required' => [
            '/example/{a?}/{b?}',
            ['/example/{a}/{b}'],
        ],
        'interior optional still normalizes' => [
            '/example/{a?}/{b}',
            ['/example/{a}/{b}'],
        ],
        'no optionals unaffected' => [
            '/example/{id}',
            ['/example/{id}'],
        ],
    ]);
})->covers(PathTemplateExpander::class);
