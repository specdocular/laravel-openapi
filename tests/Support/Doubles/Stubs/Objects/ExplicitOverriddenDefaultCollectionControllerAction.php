<?php

namespace Tests\Support\Doubles\Stubs\Objects;

use Specdocular\LaravelOpenAPI\Attributes\Collection;
use Specdocular\LaravelOpenAPI\Attributes\PathItem;

#[PathItem]
#[Collection('some-other-collection')]
final class ExplicitOverriddenDefaultCollectionControllerAction
{
    #[Collection(Collection::DEFAULT)]
    public function __invoke(): void
    {
    }
}
