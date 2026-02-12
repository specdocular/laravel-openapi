<?php

namespace Tests\Support\Doubles\Stubs\Servers;

use Specdocular\LaravelOpenAPI\Contracts\Factories\ServerFactory;
use Specdocular\OpenAPI\Schema\Objects\Server\Server;

class ServerWithoutVariables implements ServerFactory
{
    public function build(): Server
    {
        return Server::create('https://laragen.io')
            ->description('sample_description');
    }
}
