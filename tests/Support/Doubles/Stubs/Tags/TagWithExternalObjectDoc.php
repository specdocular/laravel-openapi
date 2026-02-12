<?php

namespace Tests\Support\Doubles\Stubs\Tags;

use Specdocular\LaravelOpenAPI\Contracts\Factories\TagFactory;
use Specdocular\OpenAPI\Schema\Objects\ExternalDocumentation\ExternalDocumentation;
use Specdocular\OpenAPI\Schema\Objects\Tag\Tag;

class TagWithExternalObjectDoc implements TagFactory
{
    public function build(): Tag
    {
        return Tag::create(
            'PostWithExternalObjectDoc',
        )->description('Post Tag')
            ->externalDocs(
                ExternalDocumentation::create(
                    'https://laragen.io/external-docs',
                )->description('External API documentation'),
            );
    }
}
