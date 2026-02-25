<?php

namespace Tests\Support\Doubles\Stubs;

use Specdocular\LaravelOpenAPI\Attributes\Scope;
use Specdocular\LaravelOpenAPI\Attributes\Operation;
use Specdocular\LaravelOpenAPI\Attributes\PathItem;

#[Scope('TestCollection')]
#[PathItem]
class CollectibleClass
{
    #[Operation]
    public function __invoke(): string
    {
        return 'example';
    }
}
