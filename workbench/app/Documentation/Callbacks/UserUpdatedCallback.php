<?php

namespace Workbench\App\Documentation\Callbacks;

use Specdocular\JsonSchema\Draft202012\Formats\StringFormat;
use Specdocular\JsonSchema\Draft202012\Keywords\Properties\Property;
use Specdocular\LaravelOpenAPI\Attributes\Scope;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\CallbackFactory;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;
use Specdocular\OpenAPI\Schema\Objects\Callback\Callback;
use Specdocular\OpenAPI\Schema\Objects\MediaType\MediaType;
use Specdocular\OpenAPI\Schema\Objects\Operation\Operation;
use Specdocular\OpenAPI\Schema\Objects\PathItem\PathItem;
use Specdocular\OpenAPI\Schema\Objects\PathItem\Support\AvailableOperation;
use Specdocular\OpenAPI\Schema\Objects\PathItem\Support\HttpMethod;
use Specdocular\OpenAPI\Schema\Objects\RequestBody\RequestBody;
use Specdocular\OpenAPI\Schema\Objects\Response\Response;
use Specdocular\OpenAPI\Schema\Objects\Responses\Fields\HTTPStatusCode;
use Specdocular\OpenAPI\Schema\Objects\Responses\Responses;
use Specdocular\OpenAPI\Schema\Objects\Responses\Support\ResponseEntry;
use Specdocular\OpenAPI\Schema\Objects\Schema\Schema;
use Specdocular\OpenAPI\Support\RuntimeExpression\Request\RequestQueryExpression;
use Specdocular\OpenAPI\Support\SharedFields\Content\ContentEntry;
use Workbench\App\Documentation\WorkbenchScope;

#[Scope(WorkbenchScope::class)]
class UserUpdatedCallback extends CallbackFactory implements ShouldBeReferenced
{
    public function component(): Callback
    {
        return Callback::create(
            RequestQueryExpression::create('callbackUrl'),
            PathItem::create()
                ->operations(
                    AvailableOperation::create(
                        HttpMethod::POST,
                        Operation::create()
                            ->requestBody(
                                RequestBody::create(
                                    ContentEntry::json(
                                        MediaType::create()
                                            ->schema(
                                                Schema::object()
                                                    ->description('Request body for User Updated callback')
                                                    ->properties(
                                                        Property::create(
                                                            'id',
                                                            Schema::string()
                                                                ->description('The ID of the updated user')
                                                                ->format(StringFormat::UUID),
                                                        ),
                                                        Property::create(
                                                            'changes',
                                                            Schema::object()
                                                                ->description('The changes made to the user')
                                                                ->properties(
                                                                    Property::create(
                                                                        'name',
                                                                        Schema::string()
                                                                            ->description('The updated name of the user'),
                                                                    ),
                                                                    Property::create(
                                                                        'email',
                                                                        Schema::string()
                                                                            ->description('The updated email of the user')
                                                                            ->format(StringFormat::EMAIL),
                                                                    ),
                                                                    Property::create(
                                                                        'updated_at',
                                                                        Schema::string()
                                                                            ->description('The timestamp when the user was updated')
                                                                            ->format(StringFormat::DATE_TIME),
                                                                    ),
                                                                ),
                                                        ),
                                                    ),
                                            ),
                                    ),
                                )->description('Callback for User Updated'),
                            )->responses(
                                Responses::create(
                                    ResponseEntry::create(
                                        HTTPStatusCode::ok(),
                                        Response::create()->description('OK'),
                                    ),
                                ),
                            ),
                    ),
                ),
        );
    }
}
