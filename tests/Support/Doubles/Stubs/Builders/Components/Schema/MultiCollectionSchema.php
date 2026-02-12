<?php

namespace Tests\Support\Doubles\Stubs\Builders\Components\Schema;

use Specdocular\JsonSchema\Draft202012\Contracts\JSONSchema;
use Specdocular\JsonSchema\Draft202012\Keywords\Properties\Property;
use Specdocular\LaravelOpenAPI\Attributes\Collection;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\SchemaFactory;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;
use Specdocular\OpenAPI\Schema\Objects\Schema\Schema;

#[Collection(['test', Collection::DEFAULT])]
class MultiCollectionSchema extends SchemaFactory implements ShouldBeReferenced
{
    public function component(): JSONSchema
    {
        return Schema::object()
            ->properties(
                Property::create('id', Schema::integer()),
            );
    }
}
