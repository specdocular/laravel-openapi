<?php

namespace Tests\Support\Doubles\Stubs\Objects;

use Specdocular\LaravelOpenAPI\Attributes\PathItem;

#[PathItem]
final class ImplicitDefaultDocumentController
{
    public function __invoke(): void
    {
    }
}
