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
final class Search extends ParameterFactory implements ShouldBeReferenced
{
    public function component(): Parameter
    {
        return Parameter::query(
            'search',
            QueryParameter::create(
                Schema::string()
                    ->description(
                        'The search term to filter results by. This can be a partial match on any searchable field.',
                    ),
            ),
        );
    }
}
