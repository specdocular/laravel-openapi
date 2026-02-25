<?php

namespace Workbench\App\Documentation\Shared\Parameters;

use Specdocular\LaravelOpenAPI\Attributes\Scope;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\ParameterFactory;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;
use Specdocular\OpenAPI\Schema\Objects\Parameter\Parameter;
use Specdocular\OpenAPI\Schema\Objects\Schema\Schema;
use Specdocular\OpenAPI\Support\Serialization\QueryParameter;
use Workbench\App\Documentation\WorkbenchScope;

#[Scope(WorkbenchScope::class)]
final class Limit extends ParameterFactory implements ShouldBeReferenced
{
    public function component(): Parameter
    {
        return Parameter::query(
            'limit',
            QueryParameter::create(
                Schema::integer()
                    ->minimum(0)
                    ->default(10)
                    ->description('The maximum number of items to return.'),
            ),
        );
    }
}
