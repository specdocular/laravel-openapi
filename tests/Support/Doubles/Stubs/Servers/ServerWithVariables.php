<?php

namespace Tests\Support\Doubles\Stubs\Servers;

use Specdocular\LaravelOpenAPI\Contracts\Factories\ServerFactory;
use Specdocular\OpenAPI\Schema\Objects\Server\Fields\Variables\VariableEntry;
use Specdocular\OpenAPI\Schema\Objects\Server\Server;
use Specdocular\OpenAPI\Schema\Objects\ServerVariable\ServerVariable;

class ServerWithVariables implements ServerFactory
{
    public function build(): Server
    {
        return Server::create('https://laragen.io')
            ->description('sample_description')
            ->variables(
                VariableEntry::create(
                    'variable_name',
                    ServerVariable::create('variable_default')
                        ->description('variable_description'),
                ),
            );
    }
}
