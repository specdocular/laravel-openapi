<?php

namespace Tests\Support\Doubles\Stubs\Builders\Components\Parameter;

use Specdocular\LaravelOpenAPI\Attributes\Scope;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\ParameterFactory;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;
use Specdocular\OpenAPI\Schema\Objects\Parameter\Parameter;
use Specdocular\OpenAPI\Schema\Objects\Schema\Schema;
use Specdocular\OpenAPI\Support\Serialization\CookieParameter;

#[Scope(['test', Scope::DEFAULT])]
class MultiScopeParameter extends ParameterFactory implements ShouldBeReferenced
{
    public function component(): Parameter
    {
        return Parameter::cookie(
            'test',
            CookieParameter::create(Schema::string()),
        );
    }
}
