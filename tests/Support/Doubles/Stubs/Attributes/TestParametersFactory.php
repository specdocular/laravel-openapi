<?php

namespace Tests\Support\Doubles\Stubs\Attributes;

use Specdocular\LaravelOpenAPI\Contracts\Factories\ParametersFactory;
use Specdocular\OpenAPI\Schema\Objects\Parameter\Parameter;
use Specdocular\OpenAPI\Schema\Objects\Schema\Schema;
use Specdocular\OpenAPI\Support\Serialization\CookieParameter;
use Specdocular\OpenAPI\Support\Serialization\HeaderParameter;
use Specdocular\OpenAPI\Support\Serialization\PathParameter;
use Specdocular\OpenAPI\Support\SharedFields\Parameters;
use Tests\Support\Doubles\Stubs\TestParameter;

class TestParametersFactory implements ParametersFactory
{
    public function build(): Parameters
    {
        return Parameters::create(
            Parameter::header(
                'param_a',
                HeaderParameter::create(Schema::string()),
            ),
            Parameter::path(
                'param_b',
                PathParameter::create(Schema::string()),
            ),
            TestParameter::create(),
            Parameter::cookie(
                'param_c',
                CookieParameter::create(Schema::string()),
            ),
        );
    }
}
