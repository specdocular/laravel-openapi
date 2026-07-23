<?php

namespace Tests\Support\Doubles\Stubs;

use Specdocular\LaravelOpenAPI\Attributes\Document;
use Specdocular\LaravelOpenAPI\Attributes\Operation;
use Specdocular\LaravelOpenAPI\Attributes\PathItem;

#[Document('TestCollection')]
#[PathItem]
class CollectibleClass
{
    #[Operation]
    public function __invoke(): string
    {
        return 'example';
    }
}
