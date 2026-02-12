<?php

namespace Specdocular\LaravelOpenAPI\Builders;

use Specdocular\LaravelOpenAPI\Contracts\Factories\ResponsesFactory;
use Specdocular\OpenAPI\Schema\Objects\Responses\Responses;
use Webmozart\Assert\Assert;

final readonly class ResponsesBuilder
{
    /** @param class-string<ResponsesFactory> $factory */
    public function build(string $factory): Responses
    {
        Assert::isAOf($factory, ResponsesFactory::class);

        return (new $factory())->build();
    }
}
