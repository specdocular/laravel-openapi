<?php

namespace Tests\Support\Doubles\Stubs\Builders\Components\Parameter;

use Specdocular\LaravelOpenAPI\Attributes\Collection;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\ParameterFactory;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;
use Specdocular\OpenAPI\Schema\Objects\Parameter\Parameter;
use Specdocular\OpenAPI\Schema\Objects\Schema\Schema;
use Specdocular\OpenAPI\Support\Serialization\PathParameter;

#[Collection('test')]
class ExplicitCollectionParameter extends ParameterFactory implements ShouldBeReferenced
{
    public function component(): Parameter
    {
        return Parameter::path(
            'user_id',
            PathParameter::create(Schema::string()),
        );
    }
}
