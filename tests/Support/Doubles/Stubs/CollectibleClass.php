<?php

namespace Tests\Support\Doubles\Stubs;

use Specdocular\LaravelOpenAPI\Attributes\Operation;
use Specdocular\LaravelOpenAPI\Attributes\PathItem;
use Specdocular\LaravelOpenAPI\Attributes\Scope;

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
