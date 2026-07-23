<?php

namespace Tests\Support\Doubles\Stubs\Objects;

use Specdocular\LaravelOpenAPI\Attributes\Document;
use Specdocular\LaravelOpenAPI\Attributes\Extension;
use Specdocular\LaravelOpenAPI\Attributes\Operation;
use Specdocular\LaravelOpenAPI\Attributes\PathItem;

#[PathItem(summary: 'Test path item')]
#[Document(['test', 'example'])]
class ControllerWithExtensions
{
    #[Operation(summary: 'Test operation')]
    #[Extension(key: 'x-custom', value: 'custom-value')]
    #[Extension(key: 'x-another', value: 'another-value')]
    #[Document('action-collection')]
    public function withExtensions(): void
    {
    }

    #[Operation(summary: 'No extensions')]
    public function withoutExtensions(): void
    {
    }
}
