<?php

namespace Tests\Support\Doubles\Stubs\Objects;

use Specdocular\LaravelOpenAPI\Attributes\PathItem;
use Specdocular\LaravelOpenAPI\Attributes\Scope;

#[PathItem]
final class ExplicitDefaultScopeControllerAction
{
    #[Scope(Scope::DEFAULT)]
    public function __invoke(): void
    {
    }
}
