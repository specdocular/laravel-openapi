<?php

namespace Tests\Support\Doubles\Stubs\Servers;

use Specdocular\LaravelOpenAPI\Contracts\Factories\ServerFactory;
use Specdocular\OpenAPI\Schema\Objects\Server\Fields\Variables\VariableEntry;
use Specdocular\OpenAPI\Schema\Objects\Server\Server;
use Specdocular\OpenAPI\Schema\Objects\ServerVariable\ServerVariable;

class ServerWithMultipleVariableFormatting implements ServerFactory
{
    public function build(): Server
    {
        return Server::create('https://laragen.io')
            ->description('sample_description')
            ->variables(
                VariableEntry::create(
                    'ServerVariableA',
                    ServerVariable::create(
                        'B',
                    )->description('variable_description')
                        ->enum('A', 'B'),
                ),
                VariableEntry::create(
                    'ServerVariableB',
                    ServerVariable::create(
                        'sample',
                    )->description(
                        'sample_description',
                    ),
                ),
            );
    }
}
