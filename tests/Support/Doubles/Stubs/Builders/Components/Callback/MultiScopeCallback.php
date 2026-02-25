<?php

namespace Tests\Support\Doubles\Stubs\Builders\Components\Callback;

use Specdocular\LaravelOpenAPI\Attributes\Scope;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\CallbackFactory;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;
use Specdocular\OpenAPI\Schema\Objects\Callback\Callback;
use Specdocular\OpenAPI\Schema\Objects\PathItem\PathItem;

#[Scope(['test', Scope::DEFAULT])]
class MultiScopeCallback extends CallbackFactory implements ShouldBeReferenced
{
    public function component(): Callback
    {
        return Callback::create('https://laragen.io/multi-collection-callback', PathItem::create());
    }
}
