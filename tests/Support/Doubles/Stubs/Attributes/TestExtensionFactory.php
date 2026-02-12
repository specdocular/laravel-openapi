<?php

namespace Tests\Support\Doubles\Stubs\Attributes;

use Specdocular\LaravelOpenAPI\Contracts\Abstract\Factories\ExtensionFactory as AbstractFactory;

class TestExtensionFactory extends AbstractFactory
{
    public function build(): array
    {
        return [];
    }

    public function key(): string
    {
        return 'x-key';
    }

    public function value(): string
    {
        return 'value';
    }
}
