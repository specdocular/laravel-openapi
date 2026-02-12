<?php

namespace Workbench\App\Petstore\Factories\Responses;

use Specdocular\LaravelOpenAPI\Contracts\Factories\ResponsesFactory;
use Specdocular\OpenAPI\Schema\Objects\Responses\Fields\HTTPStatusCode;
use Specdocular\OpenAPI\Schema\Objects\Responses\Responses;
use Specdocular\OpenAPI\Schema\Objects\Responses\Support\ResponseEntry;
use Workbench\App\Petstore\Reusable\Response\ValidationErrorResponse;

class SingleResponseUsingReusable implements ResponsesFactory
{
    public function build(): Responses
    {
        return Responses::create(
            ResponseEntry::create(
                HTTPStatusCode::unprocessableEntity(),
                ValidationErrorResponse::create(),
            ),
        );
    }
}
