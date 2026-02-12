<?php

namespace Tests\Support\Doubles\Stubs\Attributes;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\Schemes\Http;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\SecurityScheme;

class TestSecuritySchemeFactory extends SecuritySchemeFactory
{
    public function component(): SecurityScheme
    {
        return SecurityScheme::http(Http::basic());
    }
}
