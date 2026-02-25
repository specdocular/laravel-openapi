<?php

namespace Tests\Support\Doubles\Stubs\Objects;

use Specdocular\LaravelOpenAPI\Attributes\PathItem;
use Specdocular\LaravelOpenAPI\Attributes\Scope;

#[PathItem]
#[Scope('some-other-collection')]
final class ExplicitOverriddenDefaultScopeControllerAction
{
    #[Scope(Scope::DEFAULT)]
    public function __invoke(): void
    {
    }
}
