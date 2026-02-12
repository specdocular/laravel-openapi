<?php

namespace Tests\Support\Doubles\Stubs\SecuritySchemes;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\Schemes\ApiKey;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\SecurityScheme;

class ApiKeySecuritySchemeFactory extends SecuritySchemeFactory
{
    public static function name(): string
    {
        return 'ApiKey';
    }

    public function component(): SecurityScheme
    {
        return SecurityScheme::apiKey(ApiKey::query('header'))
            ->description('Api Key Security');
    }
}
