<?php

namespace Workbench\App\Petstore\Security;

use Specdocular\LaravelOpenAPI\Contracts\Factories\SecurityFactory;
use Specdocular\OpenAPI\Schema\Objects\Security\Security;
use Workbench\App\Petstore\Security\SecurityRequirements\TestBearerSecurityRequirementFactory;
use Workbench\App\Petstore\Security\SecurityRequirements\TestMultiSecurityRequirementFactory;

class TestComplexMultiSecurityFactory implements SecurityFactory
{
    public function build(): Security
    {
        return Security::create(
            TestBearerSecurityRequirementFactory::create(),
            TestMultiSecurityRequirementFactory::create(),
        );
    }
}
