<?php

namespace Workbench\App\Petstore\Factories\Responses;

use Specdocular\LaravelOpenAPI\Contracts\Factories\ResponsesFactory;
use Specdocular\JsonSchema\Draft202012\Keywords\Properties\Property;
use Specdocular\OpenAPI\Schema\Objects\MediaType\MediaType;
use Specdocular\OpenAPI\Schema\Objects\Response\Response;
use Specdocular\OpenAPI\Schema\Objects\Responses\Fields\HTTPStatusCode;
use Specdocular\OpenAPI\Schema\Objects\Responses\Responses;
use Specdocular\OpenAPI\Schema\Objects\Responses\Support\ResponseEntry;
use Specdocular\OpenAPI\Schema\Objects\Schema\Schema;
use Specdocular\OpenAPI\Support\SharedFields\Content\ContentEntry;

final class SingleResponse implements ResponsesFactory
{
    public function build(): Responses
    {
        return Responses::create(
            ResponseEntry::create(
                HTTPStatusCode::unprocessableEntity(),
                Response::create()->description('Unprocessable Entity')
                    ->content(
                        ContentEntry::json(
                            MediaType::create()->schema(
                                Schema::object()
                                ->properties(
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
                                ),
                            ),
                        ),
                    ),
            ),
        );
    }
}
