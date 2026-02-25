<?php

namespace Workbench\App\Documentation\Parameters;

use Specdocular\LaravelOpenAPI\Attributes\Scope;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\ParameterFactory;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;
use Specdocular\OpenAPI\Schema\Objects\Parameter\Parameter;
use Specdocular\OpenAPI\Schema\Objects\Schema\Schema;
use Specdocular\OpenAPI\Support\Serialization\PathParameter;
use Workbench\App\Documentation\WorkbenchScope;

#[Scope(WorkbenchScope::class)]
final class Email extends ParameterFactory implements ShouldBeReferenced
{
    public function component(): Parameter
    {
        return Parameter::path(
            'email',
            PathParameter::create(Schema::string()),
        );
    }
}
