<?php

namespace Tests\Support\Doubles\Stubs\Objects;

use Specdocular\LaravelOpenAPI\Attributes\Document;
use Specdocular\LaravelOpenAPI\Attributes\PathItem;

#[PathItem]
#[Document('some-other-collection')]
final class ExplicitOverriddenDefaultDocumentControllerAction
{
    #[Document(Document::DEFAULT)]
    public function __invoke(): void
    {
    }
}
