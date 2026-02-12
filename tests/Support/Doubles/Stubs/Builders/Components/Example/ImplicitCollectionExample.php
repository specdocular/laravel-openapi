<?php

namespace Tests\Support\Doubles\Stubs\Builders\Components\Example;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\ExampleFactory;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;
use Specdocular\OpenAPI\Schema\Objects\Example\Example;

class ImplicitCollectionExample extends ExampleFactory implements ShouldBeReferenced
{
    public function component(): Example
    {
        return Example::create()->externalValue('Example External Value');
    }
}
