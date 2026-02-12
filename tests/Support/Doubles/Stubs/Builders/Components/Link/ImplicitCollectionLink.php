<?php

namespace Tests\Support\Doubles\Stubs\Builders\Components\Link;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\LinkFactory;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;
use Specdocular\OpenAPI\Schema\Objects\Link\Link;

class ImplicitCollectionLink extends LinkFactory implements ShouldBeReferenced
{
    public function component(): Link
    {
        return Link::create();
    }
}
