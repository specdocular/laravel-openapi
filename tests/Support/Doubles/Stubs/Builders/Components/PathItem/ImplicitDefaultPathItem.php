<?php

namespace Tests\Support\Doubles\Stubs\Builders\Components\PathItem;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\PathItemFactory;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;
use Specdocular\OpenAPI\Schema\Objects\PathItem\PathItem;

class ImplicitDefaultPathItem extends PathItemFactory implements ShouldBeReferenced
{
    public function component(): PathItem
    {
        return PathItem::create();
    }
}
