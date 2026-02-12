<?php

namespace Tests\Support\Doubles\Stubs\Builders;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\ResponseFactory;
use Specdocular\OpenAPI\Schema\Objects\Response\Response;

class TestResponse extends ResponseFactory
{
    public function component(): Response
    {
        return Response::create()->description('Reusable Response');
    }
}
