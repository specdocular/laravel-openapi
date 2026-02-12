<?php

namespace Tests\Support\Doubles\Stubs\Tags;

use Specdocular\LaravelOpenAPI\Contracts\Factories\TagFactory;
use Specdocular\OpenAPI\Schema\Objects\Tag\Tag;

class TagWithoutExternalDoc implements TagFactory
{
    public function build(): Tag
    {
        return Tag::create(
            'PostWithoutExternalDoc',
        )->description('Post Tag');
    }
}
