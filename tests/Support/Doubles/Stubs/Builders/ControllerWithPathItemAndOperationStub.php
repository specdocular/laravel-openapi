<?php

namespace Tests\Support\Doubles\Stubs\Builders;

use Specdocular\LaravelOpenAPI\Attributes\Document;
use Specdocular\LaravelOpenAPI\Attributes\Operation;
use Specdocular\LaravelOpenAPI\Attributes\PathItem;

#[Document('Another')]
#[PathItem]
class ControllerWithPathItemAndOperationStub
{
    #[Operation]
    public function __invoke(): string
    {
        return 'example';
    }
}
