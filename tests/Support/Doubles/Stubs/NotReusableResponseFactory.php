<?php

namespace Tests\Support\Doubles\Stubs;

use Specdocular\OpenAPI\Schema\Objects\Response\Response;

class NotReusableResponseFactory
{
    public function build(): Response
    {
        return Response::create()->description('OK');
    }
}
