<?php

namespace Specdocular\LaravelOpenAPI\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class SecuritySchemeFactoryMakeCommand extends GeneratorCommand
{
    protected $name = 'openapi:make-security-scheme';
    protected $description = 'Create a new SecurityScheme factory class';
    protected $type = 'SecurityScheme';

    protected function buildClass($name): array|string
    {
        $output = parent::buildClass($name);

        return str_replace('DummySecurityScheme', Str::replaceLast('SecurityScheme', '', class_basename($name)), $output);
    }

    protected function getStub(): string
    {
        return __DIR__ . '/Stubs/securityscheme.stub';
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\OpenApi\SecuritySchemes';
    }

    protected function qualifyClass($name): string
    {
        $name = parent::qualifyClass($name);

        if (Str::endsWith($name, 'SecurityScheme')) {
            return $name;
        }

        return $name . 'SecurityScheme';
    }
}
