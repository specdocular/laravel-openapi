<?php

use Specdocular\LaravelOpenAPI\Builders\RequestBodyBuilder;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\RequestBodyFactory;
use Tests\Support\Doubles\Stubs\Builders\TestRequestBodyFactory;

describe(class_basename(RequestBodyBuilder::class), function (): void {
    it('can be created', function (): void {
        $builder = new RequestBodyBuilder();

        $result = $builder->build(TestRequestBodyFactory::class);

        expect($result)->toBeInstanceOf(RequestBodyFactory::class);
    });
})->covers(RequestBodyBuilder::class);
