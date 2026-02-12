<?php

namespace Tests\Support\Doubles\Stubs\Builders\Components\SecurityScheme;

use Specdocular\LaravelOpenAPI\Attributes\Collection;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\Schemes\Http;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\SecurityScheme;

#[Collection('test')]
class ExplicitCollectionSecurityScheme extends SecuritySchemeFactory implements ShouldBeReferenced
{
    public function component(): SecurityScheme
    {
        return SecurityScheme::http(Http::basic());
    }
}
