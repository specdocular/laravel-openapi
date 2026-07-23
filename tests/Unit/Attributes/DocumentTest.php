<?php

use Specdocular\LaravelOpenAPI\Attributes\Document;
use Tests\Support\Doubles\Stubs\Attributes\TestStringable;

describe(class_basename(Document::class), function (): void {
    it('can fall back to default document', function (): void {
        $document = new Document();
        expect($document->name)->toBe([Document::DEFAULT]);
    });

    it('can accept string as document name', function (): void {
        $document = new Document('scope');
        expect($document->name)->toBe(['scope']);
    });

    it('can accept array of strings as document name', function (): void {
        $document = new Document(['scope1', 'scope2']);
        expect($document->name)->toBe(['scope1', 'scope2']);
    });

    it('can accept array of stringables as document name', function (): void {
        $document = new Document([TestStringable::class]);
        expect($document->name)->toBe(['stringable']);
    });

    it('can accept mixed array of strings and stringables as document name', function (): void {
        $document = new Document(['scope', TestStringable::class]);
        expect($document->name)->toBe(['scope', 'stringable']);
    });
})->covers(Document::class);
