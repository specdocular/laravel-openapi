<?php

namespace Tests\Support\Doubles\Stubs\Builders\Components\Header;

use Specdocular\LaravelOpenAPI\Attributes\Document;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\HeaderFactory;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;
use Specdocular\OpenAPI\Schema\Objects\Header\Header;

#[Document('test')]
class ExplicitDocumentHeader extends HeaderFactory implements ShouldBeReferenced
{
    public function component(): Header
    {
        return Header::create();
    }
}
