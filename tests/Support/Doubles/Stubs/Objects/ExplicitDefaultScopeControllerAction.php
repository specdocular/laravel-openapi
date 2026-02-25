<?php

namespace Tests\Support\Doubles\Stubs\Objects;

use Specdocular\LaravelOpenAPI\Attributes\Scope;
use Specdocular\LaravelOpenAPI\Attributes\PathItem;

#[PathItem]
final class ExplicitDefaultScopeControllerAction
{
    #[Scope(Scope::DEFAULT)]
    public function __invoke(): void
    {
    }
}
