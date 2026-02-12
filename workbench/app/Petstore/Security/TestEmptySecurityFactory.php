<?php

namespace Workbench\App\Petstore\Security;

use Specdocular\LaravelOpenAPI\Contracts\Factories\SecurityFactory;
use Specdocular\OpenAPI\Schema\Objects\Security\Security;

class TestEmptySecurityFactory implements SecurityFactory
{
    public function build(): Security
    {
        return Security::create();
    }
}
