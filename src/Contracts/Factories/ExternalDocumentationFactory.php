<?php

namespace Specdocular\LaravelOpenAPI\Contracts\Factories;

use Specdocular\OpenAPI\Schema\Objects\ExternalDocumentation\ExternalDocumentation;

interface ExternalDocumentationFactory
{
    public function build(): ExternalDocumentation;
}
