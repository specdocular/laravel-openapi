<?php

namespace Workbench\App\Documentation\Responses;

use Specdocular\JsonSchema\Draft202012\Formats\StringFormat;
use Specdocular\JsonSchema\Draft202012\Keywords\Properties\Property;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\ResponseFactory;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;
use Specdocular\OpenAPI\Schema\Objects\MediaType\MediaType;
use Specdocular\OpenAPI\Schema\Objects\Response\Response;
use Specdocular\OpenAPI\Schema\Objects\Schema\Schema;
use Specdocular\OpenAPI\Support\SharedFields\Content\ContentEntry;

final class UserResponse extends ResponseFactory implements ShouldBeReferenced
{
    public function component(): Response
    {
        return Response::create()->description('UserResponse')
            ->content(
                ContentEntry::json(
                    MediaType::create()->schema(
                        Schema::object()
                        ->description('Generic response for a user object')
                        ->properties(
                            Property::create(
                                'id',
                                Schema::string()
                                    ->description('The unique identifier of the user')
                                    ->format(StringFormat::UUID),
                            ),
                            Property::create(
                                'phone',
                                Schema::integer()
                                    ->description('The phone number of the user'),
                            ),
                            Property::create(
                                'name',
                                Schema::string()
                                    ->description('The name of the user'),
                            ),
                            Property::create(
                                'email',
                                Schema::string()
                                    ->description('The email address of the user')
                                    ->format(StringFormat::EMAIL),
                            ),
                        ),
                    ),
                ),
            );
    }
}
