<?php

namespace Workbench\App\Petstore\Security\SecurityRequirements;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\Composable\SecurityRequirementFactory;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityRequirement\SecurityRequirement;

/**
 * @extends SecurityRequirementFactory<SecurityRequirement>
 */
final class TestNoSecurityRequirementFactory extends SecurityRequirementFactory
{
    public function object(): SecurityRequirement
    {
        return SecurityRequirement::create();
    }
}
