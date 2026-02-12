<?php

namespace Specdocular\LaravelOpenAPI\Builders;

use Illuminate\Support\Collection;
use Specdocular\LaravelOpenAPI\Attributes\Extension as ExtensionAttribute;
use Specdocular\LaravelOpenAPI\Contracts\Abstract\Factories\ExtensionFactory;
use Specdocular\OpenAPI\Contracts\Abstract\ExtensibleObject;
use Specdocular\OpenAPI\Extensions\Extension;

final readonly class ExtensionBuilder
{
    /**
     * @template T of ExtensibleObject
     *
     * @param T $extensibleObject
     *
     * @return T
     */
    public function build(ExtensibleObject $extensibleObject, Collection $attributes): ExtensibleObject
    {
        return $attributes->reduce(
            static function (ExtensibleObject $object, ExtensionAttribute $extensionAttribute): ExtensibleObject {
                if (is_a($extensionAttribute->factory, ExtensionFactory::class, true)) {
                    /** @var ExtensionFactory $factory */
                    $factory = new $extensionAttribute->factory();
                    $key = $factory->key();
                    $value = $factory->value();
                } else {
                    $key = $extensionAttribute->key;
                    $value = $extensionAttribute->value;
                }

                return $object->addExtension(Extension::create($key, $value));
            },
            $extensibleObject,
        );
    }
}
