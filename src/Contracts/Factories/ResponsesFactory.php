<?php

namespace Specdocular\LaravelOpenAPI\Contracts\Factories;

use Specdocular\OpenAPI\Schema\Objects\Responses\Responses;

interface ResponsesFactory
{
    public function build(): Responses;
}
