<?php

namespace Workbench\App\Petstore\Security\Scopes;

use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\OAuth\Scope;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\OAuth\ScopeFactory;

final readonly class OrderScope extends ScopeFactory
{
    public function build(): Scope
    {
        return Scope::create('order', 'Full information about orders.');
    }
}
