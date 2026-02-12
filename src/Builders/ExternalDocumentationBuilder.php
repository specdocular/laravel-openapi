<?php

namespace Specdocular\LaravelOpenAPI\Builders;

use Specdocular\LaravelOpenAPI\Contracts\Factories\ExternalDocumentationFactory;
use Specdocular\OpenAPI\Schema\Objects\ExternalDocumentation\ExternalDocumentation;
use Webmozart\Assert\Assert;

final readonly class ExternalDocumentationBuilder
{
    /** @param class-string<ExternalDocumentationFactory> $factory */
    public function build(string $factory): ExternalDocumentation
    {
        Assert::isAOf($factory, ExternalDocumentationFactory::class);

        return (new $factory())->build();
    }
}
