<?php

namespace Tests\Support\Doubles\Stubs\Builders\Components\Link;

use Specdocular\LaravelOpenAPI\Attributes\Document;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\LinkFactory;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;
use Specdocular\OpenAPI\Schema\Objects\Link\Link;

#[Document(['test', Document::DEFAULT])]
class MultiDocumentLink extends LinkFactory implements ShouldBeReferenced
{
    public function component(): Link
    {
        return Link::create();
    }
}
