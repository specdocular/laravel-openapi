<?php

use Tests\IntegrationTestCase;
use Tests\UnitTestCase;

pest()->extends(IntegrationTestCase::class)->in('Integration')
    ->afterEach(fn () => cleanup($this->cleanupCallbacks));

pest()->extends(UnitTestCase::class)->in('Unit')
    ->afterEach(fn () => cleanup($this->cleanupCallbacks));

expect()->extend('toBeValidJsonSchema', function (): Pest\Expectation {
    $tempFile = tempnam(sys_get_temp_dir(), 'openapi_') . '.json';
    file_put_contents($tempFile, json_encode($this->value, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    exec("npx --yes @redocly/cli lint {$tempFile} --format=json 2>&1", $output, $exitCode);
    @unlink($tempFile);
    expect($exitCode)->toBe(0, 'JSON Schema validation failed: ' . implode("\n", $output));

    return $this;
});

expect()->extend('toBeImmutable', function (): Pest\Expectation {
    $class = new ReflectionClass($this->value);
    foreach ($class->getProperties() as $property) {
        expect($property->isReadOnly())->toBeTrue(
            "Property {$property->getName()} is not readonly"
        );
    }

    return $this;
});

function cleanup(array $callbacks): void
{
    foreach ($callbacks as $callback) {
        $callback();
    }
}
