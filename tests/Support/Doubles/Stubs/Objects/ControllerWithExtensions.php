<?php

namespace Tests\Support\Doubles\Stubs\Objects;

use Specdocular\LaravelOpenAPI\Attributes\Collection;
use Specdocular\LaravelOpenAPI\Attributes\Extension;
use Specdocular\LaravelOpenAPI\Attributes\Operation;
use Specdocular\LaravelOpenAPI\Attributes\PathItem;

#[PathItem(summary: 'Test path item')]
#[Collection(['test', 'example'])]
class ControllerWithExtensions
{
    #[Operation(summary: 'Test operation')]
    #[Extension(key: 'x-custom', value: 'custom-value')]
    #[Extension(key: 'x-another', value: 'another-value')]
    #[Collection('action-collection')]
    public function withExtensions(): void
    {
    }

    #[Operation(summary: 'No extensions')]
    public function withoutExtensions(): void
    {
    }
}
