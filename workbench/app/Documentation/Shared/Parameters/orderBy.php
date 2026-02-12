<?php

namespace Workbench\App\Documentation\Shared\Parameters;

use Specdocular\LaravelOpenAPI\Attributes\Collection;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\ParameterFactory;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;
use Specdocular\OpenAPI\Schema\Objects\Parameter\Parameter;
use Specdocular\OpenAPI\Schema\Objects\Schema\Schema;
use Specdocular\OpenAPI\Support\Serialization\QueryParameter;
use Workbench\App\Documentation\WorkbenchCollection;

#[Collection(WorkbenchCollection::class)]
final class orderBy extends ParameterFactory implements ShouldBeReferenced
{
    public function component(): Parameter
    {
        return Parameter::query(
            'orderBy',
            QueryParameter::create(
                Schema::string()
                    ->enum(['asc', 'desc'])
                    ->default('asc')
                    ->description(
                        'The order in which to sort the results. Use "asc" for ascending and "desc" for descending order.',
                    ),
            ),
        );
    }
}
