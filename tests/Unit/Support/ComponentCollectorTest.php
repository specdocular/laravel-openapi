<?php

use Pest\Expectation;
use Specdocular\LaravelOpenAPI\Attributes\Document;
use Specdocular\LaravelOpenAPI\Support\ComponentCollector;

describe(class_basename(ComponentCollector::class), function (): void {
    it('can collect specific documents', function (): void {
        $sut = new ComponentCollector([
            __DIR__ . '/../../Support/Doubles/Stubs/Builders/Components',
        ]);

        $result = $sut->collect('test')->map(static fn ($component) => $component::class);

        expect($result)->toHaveCount(20)
            ->each(function (Expectation $expectation) {
                return $expectation->toHaveAttribute(Document::class);
            });
    });
})->covers(ComponentCollector::class);
