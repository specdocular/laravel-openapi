<?php

namespace Workbench\App\Petstore\Reusable\Response;

use Specdocular\JsonSchema\Draft202012\Keywords\Properties\Property;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\ResponseFactory;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;
use Specdocular\OpenAPI\Schema\Objects\MediaType\MediaType;
use Specdocular\OpenAPI\Schema\Objects\Response\Response;
use Specdocular\OpenAPI\Schema\Objects\Schema\Schema;
use Specdocular\OpenAPI\Support\SharedFields\Content\ContentEntry;

final class ValidationErrorResponse extends ResponseFactory implements ShouldBeReferenced
{
    public function component(): Response
    {
        $objectDescriptor = Schema::object()->properties(
            Property::create(
                'message',
                Schema::string()->examples('The given data was invalid.'),
            ),
            Property::create(
                'errors',
                Schema::object()->additionalProperties(
                    Schema::array()->items(Schema::string()),
                )->examples(['field' => ['Something is wrong with this field!']]),
            ),
        );

        return Response::create()->description('Unprocessable Entity')
            ->content(
                ContentEntry::json(
                    MediaType::create()->schema($objectDescriptor),
                ),
            );
    }
}
