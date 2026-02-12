<?php

namespace Tests\Support\Doubles\Stubs\Builders\Components\Example;

use Specdocular\LaravelOpenAPI\Attributes\Collection;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\ExampleFactory;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;
use Specdocular\OpenAPI\Schema\Objects\Example\Example;

#[Collection(['test', Collection::DEFAULT])]
class MultiCollectionExample extends ExampleFactory implements ShouldBeReferenced
{
    public function component(): Example
    {
        return Example::create()->value('Example Value');
    }
}
