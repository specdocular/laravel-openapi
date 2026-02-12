<?php

namespace Tests\Support\Doubles\Stubs\Objects;

use Specdocular\LaravelOpenAPI\Attributes\Collection;
use Specdocular\LaravelOpenAPI\Attributes\PathItem;

#[PathItem]
final class ExplicitDefaultCollectionControllerAction
{
    #[Collection(Collection::DEFAULT)]
    public function __invoke(): void
    {
    }
}
