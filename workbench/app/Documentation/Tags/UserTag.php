<?php

namespace Workbench\App\Documentation\Tags;

use Specdocular\LaravelOpenAPI\Contracts\Factories\TagFactory;
use Specdocular\OpenAPI\Schema\Objects\Tag\Tag;

final readonly class UserTag implements TagFactory
{
    public function build(): Tag
    {
        return Tag::create('User')
            ->description('Operations related to user management.');
    }
}
