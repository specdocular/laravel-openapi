<?php

namespace Specdocular\LaravelOpenAPI\Contracts\Factories;

use Specdocular\OpenAPI\Support\SharedFields\Parameters;

interface ParametersFactory
{
    public function build(): Parameters;
}
