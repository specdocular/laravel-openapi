<?php

namespace Specdocular\LaravelOpenAPI\Builders;

use Specdocular\LaravelOpenAPI\Contracts\Factories\SecurityFactory;
use Specdocular\OpenAPI\Schema\Objects\Security\Security;
use Webmozart\Assert\Assert;

final readonly class SecurityBuilder
{
    /** @param class-string<SecurityFactory> $factory */
    public function build(string $factory): Security
    {
        Assert::isAOf($factory, SecurityFactory::class);

        return (new $factory())->build();
    }
}
