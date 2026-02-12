<?php

namespace Specdocular\LaravelOpenAPI\Contracts\Factories;

use Specdocular\OpenAPI\Schema\Objects\Security\Security;

interface SecurityFactory
{
    public function build(): Security;
}
