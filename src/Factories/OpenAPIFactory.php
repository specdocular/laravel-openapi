<?php

namespace Specdocular\LaravelOpenAPI\Factories;

use Specdocular\OpenAPI\Schema\Objects\OpenAPI\OpenAPI;

abstract readonly class OpenAPIFactory
{
    final private function __construct()
    {
    }

    final public static function create(): OpenAPI
    {
        return (new static())->instance();
    }

    abstract public function instance(): OpenAPI;
}
