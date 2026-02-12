<?php

namespace Specdocular\LaravelOpenAPI\Contracts\Abstract\Factories;

abstract class ExtensionFactory
{
    abstract public function key(): string;

    abstract public function value(): mixed;
}
