<?php

namespace Workbench\App\Documentation;

use Specdocular\LaravelOpenAPI\Contracts\Factories\ResponsesFactory;
use Specdocular\OpenAPI\Schema\Objects\Responses\Fields\HTTPStatusCode;
use Specdocular\OpenAPI\Schema\Objects\Responses\Responses;
use Specdocular\OpenAPI\Schema\Objects\Responses\Support\ResponseEntry;
use Workbench\App\Documentation\Responses\UserResponse;
use Workbench\App\Documentation\Shared\Responses\UnprocessableEntityResponse;

final readonly class UserResponses implements ResponsesFactory
{
    public function build(): Responses
    {
        return Responses::create(
            ResponseEntry::create(
                HTTPStatusCode::ok(),
                UserResponse::create(),
            ),
            ResponseEntry::create(
                HTTPStatusCode::unprocessableEntity(),
                UnprocessableEntityResponse::create(),
            ),
        );
    }
}
