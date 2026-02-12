<?php

namespace Tests\Support\Doubles\Stubs;

use Specdocular\LaravelOpenAPI\Contracts\Abstract\Factories\ExtensionFactory;
use Specdocular\JsonSchema\Draft202012\Contracts\JSONSchema;
use Specdocular\JsonSchema\Draft202012\Formats\StringFormat;
use Specdocular\OpenAPI\Schema\Objects\Schema\Schema;

class FakeExtension extends ExtensionFactory
{
    public function key(): string
    {
        return 'x-uuid';
    }

    public function value(): JSONSchema
    {
        return Schema::string()->format(StringFormat::UUID);
    }
}
