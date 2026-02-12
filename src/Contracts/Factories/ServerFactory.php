<?php

namespace Specdocular\LaravelOpenAPI\Contracts\Factories;

use Specdocular\OpenAPI\Schema\Objects\Server\Server;

interface ServerFactory
{
    public function build(): Server;
}
