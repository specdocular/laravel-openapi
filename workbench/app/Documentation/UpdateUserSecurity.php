<?php

namespace Workbench\App\Documentation;

use Specdocular\LaravelOpenAPI\Contracts\Factories\SecurityFactory;
use Specdocular\OpenAPI\Schema\Objects\Security\Security;
use Workbench\App\Petstore\Security\SecurityRequirements\TestBearerSecurityRequirementFactory;
use Workbench\App\Petstore\Security\SecurityRequirements\TestMultiSecurityRequirementFactory;

final readonly class UpdateUserSecurity implements SecurityFactory
{
    public function build(): Security
    {
        return Security::create(
            TestBearerSecurityRequirementFactory::create(),
            TestMultiSecurityRequirementFactory::create(),
        );
    }
}
