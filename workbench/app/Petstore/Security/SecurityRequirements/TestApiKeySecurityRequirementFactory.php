<?php

namespace Workbench\App\Petstore\Security\SecurityRequirements;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\Composable\SecurityRequirementFactory;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityRequirement\RequiredSecurity;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityRequirement\SecurityRequirement;
use Workbench\App\Petstore\Security\SecuritySchemes\TestApiKeySecuritySchemeFactory;

/**
 * @extends SecurityRequirementFactory<SecurityRequirement>
 */
final class TestApiKeySecurityRequirementFactory extends SecurityRequirementFactory
{
    public function object(): SecurityRequirement
    {
        return SecurityRequirement::create(
            RequiredSecurity::create(
                TestApiKeySecuritySchemeFactory::create(),
            ),
        );
    }
}
