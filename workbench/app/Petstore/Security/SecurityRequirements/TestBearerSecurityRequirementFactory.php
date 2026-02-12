<?php

namespace Workbench\App\Petstore\Security\SecurityRequirements;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\Composable\SecurityRequirementFactory;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityRequirement\RequiredSecurity;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityRequirement\SecurityRequirement;
use Workbench\App\Petstore\Security\SecuritySchemes\TestBearerSecuritySchemeFactory;

/**
 * @extends SecurityRequirementFactory<SecurityRequirement>
 */
final class TestBearerSecurityRequirementFactory extends SecurityRequirementFactory
{
    public function object(): SecurityRequirement
    {
        return SecurityRequirement::create(
            RequiredSecurity::create(
                TestBearerSecuritySchemeFactory::create(),
            ),
        );
    }
}
