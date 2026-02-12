<?php

namespace Workbench\App\Documentation\Parameters;

use Specdocular\LaravelOpenAPI\Attributes\Collection;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\ParameterFactory;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;
use Specdocular\OpenAPI\Schema\Objects\Parameter\Parameter;
use Specdocular\OpenAPI\Schema\Objects\Schema\Schema;
use Specdocular\OpenAPI\Support\Serialization\PathParameter;
use Workbench\App\Documentation\WorkbenchCollection;

#[Collection(WorkbenchCollection::class)]
final class Id extends ParameterFactory implements ShouldBeReferenced
{
    public function component(): Parameter
    {
        return Parameter::path(
            'id',
            PathParameter::create(Schema::string()),
        );
    }
}
