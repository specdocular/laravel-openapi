<?php

namespace Workbench\App\Documentation\Shared\Responses;

use Specdocular\JsonSchema\Draft202012\Keywords\Properties\Property;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\ResponseFactory;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;
use Specdocular\OpenAPI\Schema\Objects\MediaType\MediaType;
use Specdocular\OpenAPI\Schema\Objects\Response\Response;
use Specdocular\OpenAPI\Schema\Objects\Schema\Schema;
use Specdocular\OpenAPI\Support\SharedFields\Content\ContentEntry;

final class UnprocessableEntityResponse extends ResponseFactory implements ShouldBeReferenced
{
    public function component(): Response
    {
        return Response::create()->description('Unprocessable Entity')
            ->content(
                ContentEntry::json(
                    MediaType::create()->schema(
                        Schema::object()
                    ->properties(
                        Property::create(
                            'message',
                            Schema::string()->description('A human-readable message describing the error.'),
                        ),
                        Property::create(
                            'errors',
                            Schema::object()->additionalProperties(
                                Schema::array()->items(Schema::string()),
                            )->description('A map of field names to validation errors.'),
                        ),
                    ),
                    ),
                ),
            );
    }
}
