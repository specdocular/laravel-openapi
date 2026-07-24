<?php

use Specdocular\LaravelOpenAPI\Factories\DefaultFactory;

describe(class_basename(DefaultFactory::class), function (): void {
    it('uses the app name as the document title, not the app url', function (): void {
        config([
            'app.name' => 'Petstore API',
            'app.url' => 'https://example.test',
        ]);

        $document = DefaultFactory::create()->jsonSerialize();

        expect($document['info']['title'])->toBe('Petstore API')
            ->and($document['info']['title'])->not->toBe('https://example.test');
    });
})->covers(DefaultFactory::class);
