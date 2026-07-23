<?php

namespace Tests\Support\Doubles\Stubs\Builders\Components\Parameter;

use Specdocular\LaravelOpenAPI\Attributes\Document;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\ParameterFactory;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;
use Specdocular\OpenAPI\Schema\Objects\Parameter\Parameter;
use Specdocular\OpenAPI\Schema\Objects\Schema\Schema;
use Specdocular\OpenAPI\Support\Serialization\CookieParameter;

#[Document(['test', Document::DEFAULT])]
class MultiDocumentParameter extends ParameterFactory implements ShouldBeReferenced
{
    public function component(): Parameter
    {
        return Parameter::cookie(
            'test',
            CookieParameter::create(Schema::string()),
        );
    }
}
