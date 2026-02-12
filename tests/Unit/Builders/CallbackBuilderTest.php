<?php

use Specdocular\LaravelOpenAPI\Builders\CallbackBuilder;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\CallbackFactory;
use Tests\Support\Doubles\Stubs\Attributes\TestCallbackFactory;
use Tests\Support\Doubles\Stubs\Builders\AnotherTestCallbackFactory;

describe(class_basename(CallbackBuilder::class), function (): void {
    it('can be created', function (): void {
        $builder = new CallbackBuilder();

        $result = $builder->build(TestCallbackFactory::class, AnotherTestCallbackFactory::class);

        expect($result)
            ->toHaveCount(2)
            ->toContainOnlyInstancesOf(CallbackFactory::class);
    });
})->covers(CallbackBuilder::class);
