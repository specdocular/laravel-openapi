<?php

namespace Tests\Support\Doubles\Stubs\Objects;

use Specdocular\LaravelOpenAPI\Attributes\Scope;
use Specdocular\LaravelOpenAPI\Attributes\PathItem;

#[PathItem]
#[Scope('some-other-collection')]
final class ExplicitOverriddenDefaultScopeControllerAction
{
    #[Scope(Scope::DEFAULT)]
    public function __invoke(): void
    {
    }
}
