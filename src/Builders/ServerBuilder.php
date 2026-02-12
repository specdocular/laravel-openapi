<?php

namespace Specdocular\LaravelOpenAPI\Builders;

use Specdocular\LaravelOpenAPI\Contracts\Factories\ServerFactory;
use Specdocular\OpenAPI\Schema\Objects\Server\Server;
use Webmozart\Assert\Assert;

final readonly class ServerBuilder
{
    /**
     * @param array<array-key, class-string<ServerFactory>> $factory
     *
     * @return Server[]
     */
    public function build(string ...$factory): array
    {
        Assert::allIsAOf($factory, ServerFactory::class);

        /** @var Server[] $servers */
        $servers = collect($factory)
            ->map(
                /**
                 * @param class-string<ServerFactory> $factory
                 */
                static function (string $factory): Server {
                    return (new $factory())->build();
                },
            )->toArray();

        return $servers;
    }
}
