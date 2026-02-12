<?php

namespace Workbench\App\Documentation\Parameters;

use Specdocular\JsonSchema\Draft202012\Formats\StringFormat;
use Specdocular\LaravelOpenAPI\Contracts\Factories\ParametersFactory;
use Specdocular\OpenAPI\Schema\Objects\Parameter\Parameter;
use Specdocular\OpenAPI\Schema\Objects\Schema\Schema;
use Specdocular\OpenAPI\Support\Serialization\PathParameter;
use Specdocular\OpenAPI\Support\SharedFields\Parameters;

class UpdateUserParameters implements ParametersFactory
{
    public function build(): Parameters
    {
        return Parameters::create(
            Parameter::path(
                'id',
                PathParameter::create(
                    Schema::string()
                        ->format(StringFormat::UUID),
                ),
            ),
        );
    }
}
