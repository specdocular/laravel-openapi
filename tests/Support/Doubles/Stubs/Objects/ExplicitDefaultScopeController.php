<?php

namespace Tests\Support\Doubles\Stubs\Objects;

use Specdocular\LaravelOpenAPI\Attributes\PathItem;
use Specdocular\LaravelOpenAPI\Attributes\Scope;

#[PathItem]
#[Scope(Scope::DEFAULT)]
final class ExplicitDefaultScopeController
{
    public function __invoke(): void
    {
    }
}
