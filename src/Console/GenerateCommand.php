<?php

namespace Specdocular\LaravelOpenAPI\Console;

use Illuminate\Console\Command;
use Specdocular\LaravelOpenAPI\Generator;

class GenerateCommand extends Command
{
    protected $signature = 'openapi:generate {scope=default}';
    protected $description = 'Generate OpenAPI specification';

    public function handle(Generator $generator): void
    {
        if (!config()->has('openapi.scopes.' . $this->argument('scope'))) {
            $this->error('Scope "' . $this->argument('scope') . '" does not exist.');

            return;
        }

        $this->line(
            json_encode(
                $generator->generate($this->argument('scope')),
                JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE,
            ),
        );
    }
}
