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
final class SortBy extends ParameterFactory implements ShouldBeReferenced
{
    public function component(): Parameter
    {
        return Parameter::query(
            'sortBy',
            QueryParameter::create(
                Schema::string()
                    ->enum(['name', 'created_at', 'updated_at'])
                    ->default('name')
                    ->description(
                        'The field by which to sort the results. Options are "name", "created_at", and "updated_at".',
                    ),
            ),
        );
    }
}
