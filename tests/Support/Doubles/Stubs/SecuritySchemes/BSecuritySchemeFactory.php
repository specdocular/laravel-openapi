<?php

namespace Tests\Support\Doubles\Stubs\SecuritySchemes;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\Schemes\ApiKey;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\SecurityScheme;

class BSecuritySchemeFactory extends SecuritySchemeFactory
{
    public function component(): SecurityScheme
    {
        return SecurityScheme::apiKey(ApiKey::header('header'))
            ->description('api_key');
    }
}
