<?php

namespace Workbench\App\Documentation\Parameters;

use Specdocular\LaravelOpenAPI\Attributes\Collection;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\ParameterFactory;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;
use Specdocular\OpenAPI\Schema\Objects\Parameter\Parameter;
use Specdocular\OpenAPI\Schema\Objects\Schema\Schema;
use Specdocular\OpenAPI\Support\Serialization\QueryParameter;
use Workbench\App\Documentation\WorkbenchCollection;

#[Collection(WorkbenchCollection::class)]
final class Password extends ParameterFactory implements ShouldBeReferenced
{
    public function component(): Parameter
    {
        return Parameter::query(
            'password',
            QueryParameter::create(Schema::string()),
        );
    }
}
