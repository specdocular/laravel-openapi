<?php

namespace Workbench\App\Documentation;

use Specdocular\LaravelOpenAPI\Contracts\Factories\SecurityFactory;
use Specdocular\OpenAPI\Schema\Objects\Security\Security;
use Workbench\App\Petstore\Security\SecurityRequirements\TestBearerSecurityRequirementFactory;

final readonly class WorkbenchSecurity implements SecurityFactory
{
    public function build(): Security
    {
        return Security::create(
            TestBearerSecurityRequirementFactory::create(),
        );
    }
}
