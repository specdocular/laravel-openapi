<?php

namespace Tests\Support\Doubles\Stubs\Builders\Components\Callback;

use Specdocular\LaravelOpenAPI\Attributes\Collection;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\CallbackFactory;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;
use Specdocular\OpenAPI\Schema\Objects\Callback\Callback;
use Specdocular\OpenAPI\Schema\Objects\PathItem\PathItem;

#[Collection('test')]
class ExplicitCollectionCallback extends CallbackFactory implements ShouldBeReferenced
{
    public function component(): Callback
    {
        return Callback::create('https://laragen.io/explicit-collection-callback', PathItem::create());
    }
}
