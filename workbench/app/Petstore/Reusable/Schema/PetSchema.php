<?php

namespace Workbench\App\Petstore\Reusable\Schema;

use Specdocular\JsonSchema\Draft202012\Contracts\JSONSchema;
use Specdocular\JsonSchema\Draft202012\Keywords\Properties\Property;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\SchemaFactory;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;
use Specdocular\OpenAPI\Schema\Objects\Schema\Formats\IntegerFormat;
use Specdocular\OpenAPI\Schema\Objects\Schema\Schema;

class PetSchema extends SchemaFactory implements ShouldBeReferenced
{
    public function component(): JSONSchema
    {
        return Schema::object()
            ->required('id', 'name')
            ->properties(
                Property::create(
                    'id',
                    Schema::integer()
                        ->format(IntegerFormat::INT64),
                ),
                Property::create(
                    'name',
                    Schema::string(),
                ),
                Property::create(
                    'tag',
                    Schema::string(),
                ),
            );
    }
}
