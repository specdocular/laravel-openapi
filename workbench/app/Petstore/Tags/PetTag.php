<?php

namespace Workbench\App\Petstore\Tags;

use Specdocular\LaravelOpenAPI\Contracts\Factories\TagFactory;
use Specdocular\OpenAPI\Schema\Objects\ExternalDocumentation\ExternalDocumentation;
use Specdocular\OpenAPI\Schema\Objects\Tag\Tag;

class PetTag implements TagFactory
{
    public function build(): Tag
    {
        return Tag::create('Pet')
            ->description('Everything about your other Pets!')
            ->externalDocs(
                ExternalDocumentation::create('https://swagger.io')
                ->description('Find out more'),
            );
    }
}
