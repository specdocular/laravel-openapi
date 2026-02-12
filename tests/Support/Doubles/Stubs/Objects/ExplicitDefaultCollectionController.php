<?php

namespace Tests\Support\Doubles\Stubs\Objects;

use Specdocular\LaravelOpenAPI\Attributes\Collection;
use Specdocular\LaravelOpenAPI\Attributes\PathItem;

#[PathItem]
#[Collection(Collection::DEFAULT)]
final class ExplicitDefaultCollectionController
{
    public function __invoke(): void
    {
    }
}
