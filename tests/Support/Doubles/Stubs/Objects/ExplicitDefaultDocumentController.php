<?php

namespace Tests\Support\Doubles\Stubs\Objects;

use Specdocular\LaravelOpenAPI\Attributes\Document;
use Specdocular\LaravelOpenAPI\Attributes\PathItem;

#[PathItem]
#[Document(Document::DEFAULT)]
final class ExplicitDefaultDocumentController
{
    public function __invoke(): void
    {
    }
}
