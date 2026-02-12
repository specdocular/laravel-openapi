<?php

namespace Workbench\App\Documentation\Parameters;

use Specdocular\LaravelOpenAPI\Contracts\Factories\ParametersFactory;
use Specdocular\OpenAPI\Support\SharedFields\Parameters;

class CreateUserParameters implements ParametersFactory
{
    public function build(): Parameters
    {
        return Parameters::create();
    }
}
