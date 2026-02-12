<?php

namespace Tests\Support\Doubles\Stubs;

use Specdocular\LaravelOpenAPI\Attributes\Collection;
use Specdocular\LaravelOpenAPI\Attributes\Operation;
use Specdocular\LaravelOpenAPI\Attributes\PathItem;

#[Collection('TestCollection')]
#[PathItem]
class CollectibleClass
{
    #[Operation]
    public function __invoke(): string
    {
        return 'example';
    }
}
