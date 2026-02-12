<?php

namespace Tests\Support\Doubles\Stubs\Attributes;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\RequestBodyFactory;
use Specdocular\OpenAPI\Schema\Objects\MediaType\MediaType;
use Specdocular\OpenAPI\Schema\Objects\RequestBody\RequestBody;
use Specdocular\OpenAPI\Support\SharedFields\Content\ContentEntry;

class TestRequestBodyFactory extends RequestBodyFactory
{
    public function component(): RequestBody
    {
        return RequestBody::create(
            ContentEntry::json(MediaType::create()),
        );
    }
}
