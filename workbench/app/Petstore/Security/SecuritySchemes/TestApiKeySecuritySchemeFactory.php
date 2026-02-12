<?php

namespace Workbench\App\Petstore\Security\SecuritySchemes;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\Schemes\ApiKey;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\SecurityScheme;

class TestApiKeySecuritySchemeFactory extends SecuritySchemeFactory
{
    public function component(): SecurityScheme
    {
        return SecurityScheme::apiKey(ApiKey::cookie('ApiKey Security'));
    }
}
