<?php

namespace Tests\Support\Doubles\Stubs\Objects;

use Specdocular\LaravelOpenAPI\Attributes\Operation;
use Specdocular\LaravelOpenAPI\Attributes\PathItem;
use Specdocular\LaravelOpenAPI\Attributes\Scope;
use Workbench\App\Petstore\Factories\Responses\SingleResponseUsingReusable;

#[PathItem]
#[Scope('example')]
class MultiActionController
{
    #[Operation(
        responses: SingleResponseUsingReusable::class,
        operationId: 'anotherExample',
    )]
    public function anotherExample(): void
    {
    }

    #[Operation]
    #[Scope('another-collection')]
    public function example(): void
    {
    }
}
