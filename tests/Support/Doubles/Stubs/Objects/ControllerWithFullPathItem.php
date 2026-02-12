<?php

namespace Tests\Support\Doubles\Stubs\Objects;

use Specdocular\LaravelOpenAPI\Attributes\Operation;
use Specdocular\LaravelOpenAPI\Attributes\PathItem;
use Tests\Support\Doubles\Stubs\Attributes\TestParametersFactory;
use Tests\Support\Doubles\Stubs\Servers\ServerWithoutVariables;

#[PathItem(
    summary: 'Test summary',
    description: 'Test description',
    servers: ServerWithoutVariables::class,
    parameters: TestParametersFactory::class,
)]
class ControllerWithFullPathItem
{
    #[Operation(operationId: 'testOperation')]
    public function index(): void
    {
    }
}
