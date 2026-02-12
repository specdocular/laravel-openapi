<?php

namespace Specdocular\LaravelOpenAPI\Http;

use Specdocular\LaravelOpenAPI\Generator;
use Specdocular\OpenAPI\Schema\Objects\OpenAPI\OpenAPI;

final readonly class OpenApiController
{
    public function show(Generator $generator): OpenAPI
    {
        return $generator->generate();
    }
}
