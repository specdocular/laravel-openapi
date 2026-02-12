<?php

namespace Tests\Support\Doubles\Stubs\Builders;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\CallbackFactory;
use Specdocular\OpenAPI\Schema\Objects\Callback\Callback;
use Specdocular\OpenAPI\Schema\Objects\PathItem\PathItem;

class AnotherTestCallbackFactory extends CallbackFactory
{
    public function component(): Callback
    {
        return Callback::create('https://laragen.io/test', PathItem::create());
    }
}
