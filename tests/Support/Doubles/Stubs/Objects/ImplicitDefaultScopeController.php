<?php

namespace Tests\Support\Doubles\Stubs\Objects;

use Specdocular\LaravelOpenAPI\Attributes\PathItem;

#[PathItem]
final class ImplicitDefaultScopeController
{
    public function __invoke(): void
    {
    }
}
