<?php

namespace Specdocular\LaravelOpenAPI\Builders;

use Specdocular\LaravelOpenAPI\Contracts\Factories\TagFactory;
use Specdocular\OpenAPI\Schema\Objects\Tag\Tag;
use Webmozart\Assert\Assert;

final readonly class TagBuilder
{
    /**
     * @param array<array-key, class-string<TagFactory>> $factory
     *
     * @return Tag[]
     */
    public function build(string ...$factory): array
    {
        Assert::allIsAOf($factory, TagFactory::class);

        /** @var Tag[] $tags */
        $tags = collect($factory)
            ->map(
                /**
                 * @param class-string<TagFactory> $factory
                 */
                static function (string $factory): Tag {
                    return (new $factory())->build();
                },
            )->toArray();

        return $tags;
    }
}
