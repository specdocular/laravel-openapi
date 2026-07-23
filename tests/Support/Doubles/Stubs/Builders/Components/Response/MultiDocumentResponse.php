<?php

namespace Tests\Support\Doubles\Stubs\Builders\Components\Response;

use Specdocular\LaravelOpenAPI\Attributes\Document;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\ResponseFactory;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;
use Specdocular\OpenAPI\Schema\Objects\Response\Response;

#[Document(['test', 'example', Document::DEFAULT])]
class MultiDocumentResponse extends ResponseFactory implements ShouldBeReferenced
{
    public function component(): Response
    {
        return Response::create()->description('OK');
    }
}
