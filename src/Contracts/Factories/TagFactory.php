<?php

namespace Specdocular\LaravelOpenAPI\Contracts\Factories;

use Specdocular\OpenAPI\Schema\Objects\Tag\Tag;

interface TagFactory
{
    public function build(): Tag;
}
