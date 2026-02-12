<?php

namespace Tests\Support\Doubles\Stubs\Objects;

use Specdocular\LaravelOpenAPI\Attributes\PathItem;

#[PathItem]
final class ImplicitDefaultCollectionController
{
    public function __invoke(): void
    {
    }
}
