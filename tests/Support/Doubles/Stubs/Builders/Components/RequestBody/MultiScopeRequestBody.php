<?php

namespace Tests\Support\Doubles\Stubs\Builders\Components\RequestBody;

use Specdocular\LaravelOpenAPI\Attributes\Scope;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\RequestBodyFactory;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;
use Specdocular\OpenAPI\Schema\Objects\MediaType\MediaType;
use Specdocular\OpenAPI\Schema\Objects\RequestBody\RequestBody;
use Specdocular\OpenAPI\Support\SharedFields\Content\ContentEntry;

#[Scope(['test', Scope::DEFAULT])]
class MultiScopeRequestBody extends RequestBodyFactory implements ShouldBeReferenced
{
    public function component(): RequestBody
    {
        return RequestBody::create(
            ContentEntry::json(MediaType::create()),
        );
    }
}
