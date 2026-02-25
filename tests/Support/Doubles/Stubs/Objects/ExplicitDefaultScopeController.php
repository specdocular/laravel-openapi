<?php

namespace Tests\Support\Doubles\Stubs\Objects;

use Specdocular\LaravelOpenAPI\Attributes\Scope;
use Specdocular\LaravelOpenAPI\Attributes\PathItem;

#[PathItem]
#[Scope(Scope::DEFAULT)]
final class ExplicitDefaultScopeController
{
    public function __invoke(): void
    {
    }
}
