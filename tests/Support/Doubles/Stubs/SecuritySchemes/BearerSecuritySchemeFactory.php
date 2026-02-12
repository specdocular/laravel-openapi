<?php

namespace Tests\Support\Doubles\Stubs\SecuritySchemes;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\Schemes\Http;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\SecurityScheme;

class BearerSecuritySchemeFactory extends SecuritySchemeFactory
{
    public static function name(): string
    {
        return 'Bearer';
    }

    public function component(): SecurityScheme
    {
        return SecurityScheme::http(Http::bearer('Example Bearer Security'));
    }
}
