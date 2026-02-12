<?php

namespace Workbench\App\Petstore\Parameters;

use Specdocular\LaravelOpenAPI\Contracts\Factories\ParametersFactory;
use Specdocular\OpenAPI\Schema\Objects\Parameter\Parameter;
use Specdocular\OpenAPI\Schema\Objects\Schema\Formats\IntegerFormat;
use Specdocular\OpenAPI\Schema\Objects\Schema\Schema;
use Specdocular\OpenAPI\Support\Serialization\QueryParameter;
use Specdocular\OpenAPI\Support\SharedFields\Parameters;
use Workbench\App\Petstore\Reusable\Schema\PetSchema;

class ListPetsParameters implements ParametersFactory
{
    public function build(): Parameters
    {
        return Parameters::create(
            Parameter::query(
                'limit',
                QueryParameter::create(
                    Schema::integer()
                        ->format(IntegerFormat::INT32),
                ),
            )->description('How many items to return at one time (max 100)'),
            Parameter::query(
                'pet',
                QueryParameter::create(
                    PetSchema::create(),
                ),
            ),
        );
    }
}
