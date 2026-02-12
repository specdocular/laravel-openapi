<?php

namespace Specdocular\LaravelOpenAPI\Builders;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\RequestBodyFactory;
use Webmozart\Assert\Assert;

final readonly class RequestBodyBuilder
{
    /** @param class-string<RequestBodyFactory> $factory */
    public function build(string $factory): RequestBodyFactory
    {
        Assert::isAOf($factory, RequestBodyFactory::class);

        return $factory::create();
    }
}
