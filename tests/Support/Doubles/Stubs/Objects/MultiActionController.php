<?php

namespace Tests\Support\Doubles\Stubs\Objects;

use Specdocular\LaravelOpenAPI\Attributes\Collection;
use Specdocular\LaravelOpenAPI\Attributes\Operation;
use Specdocular\LaravelOpenAPI\Attributes\PathItem;
use Workbench\App\Petstore\Factories\Responses\SingleResponseUsingReusable;

#[PathItem]
#[Collection('example')]
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
    #[Collection('another-collection')]
    public function example(): void
    {
    }
}
