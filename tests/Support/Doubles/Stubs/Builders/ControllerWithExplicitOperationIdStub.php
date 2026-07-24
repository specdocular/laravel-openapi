<?php

namespace Tests\Support\Doubles\Stubs\Builders;

use Specdocular\LaravelOpenAPI\Attributes\Document;
use Specdocular\LaravelOpenAPI\Attributes\Operation;
use Specdocular\LaravelOpenAPI\Attributes\PathItem;

#[Document('Another')]
#[PathItem]
class ControllerWithExplicitOperationIdStub
{
    #[Operation(operationId: 'fixedOperationId')]
    public function __invoke(): string
    {
        return 'example';
    }
}
