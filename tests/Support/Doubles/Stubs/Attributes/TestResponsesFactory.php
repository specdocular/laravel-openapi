<?php

namespace Tests\Support\Doubles\Stubs\Attributes;

use Specdocular\LaravelOpenAPI\Contracts\Factories\ResponsesFactory;
use Specdocular\OpenAPI\Schema\Objects\Response\Response;
use Specdocular\OpenAPI\Schema\Objects\Responses\Fields\HTTPStatusCode;
use Specdocular\OpenAPI\Schema\Objects\Responses\Responses;
use Specdocular\OpenAPI\Schema\Objects\Responses\Support\ResponseEntry;

class TestResponsesFactory implements ResponsesFactory
{
    public function build(): Responses
    {
        return Responses::create(
            ResponseEntry::create(
                HTTPStatusCode::ok(),
                Response::create()->description('OK'),
            ),
        );
    }
}
