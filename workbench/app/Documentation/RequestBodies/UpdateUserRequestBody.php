<?php

namespace Workbench\App\Documentation\RequestBodies;

use Specdocular\JsonSchema\Draft202012\Formats\StringFormat;
use Specdocular\JsonSchema\Draft202012\Keywords\Properties\Property;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\RequestBodyFactory;
use Specdocular\OpenAPI\Schema\Objects\MediaType\MediaType;
use Specdocular\OpenAPI\Schema\Objects\RequestBody\RequestBody;
use Specdocular\OpenAPI\Schema\Objects\Schema\Schema;
use Specdocular\OpenAPI\Support\SharedFields\Content\ContentEntry;

final class UpdateUserRequestBody extends RequestBodyFactory
{
    public function component(): RequestBody
    {
        return RequestBody::create(
            ContentEntry::json(
                MediaType::create()
                    ->schema(
                        Schema::object()
                            ->description('Request body for updating a user')
                            ->properties(
                                Property::create(
                                    'name',
                                    Schema::string()
                                        ->description('The name of the user')
                                        ->minLength(3)
                                        ->maxLength(20),
                                ),
                                Property::create(
                                    'password',
                                    Schema::string()
                                        ->description('The password of the user')
                                        ->format(StringFormat::PASSWORD),
                                ),
                                Property::create(
                                    'confirm_password',
                                    Schema::string()
                                        ->description('The confirmation of the user\'s password')
                                        ->format(StringFormat::PASSWORD),
                                ),
                            ),
                    ),
            ),
        )->description('Update User Request Body');
    }
}
