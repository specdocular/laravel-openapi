<?php

namespace Tests\Support\Doubles\Stubs\Builders;

use Specdocular\LaravelOpenAPI\Contracts\Factories\ExternalDocumentationFactory;
use Specdocular\OpenAPI\Schema\Objects\ExternalDocumentation\ExternalDocumentation;

class ExternalDocsFactory implements ExternalDocumentationFactory
{
    public function build(): ExternalDocumentation
    {
        return ExternalDocumentation::create('https://laragen.io/test')
            ->description('description');
    }
}
