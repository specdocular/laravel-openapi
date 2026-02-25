<?php

use Specdocular\LaravelOpenAPI\Attributes\Scope;
use Tests\Support\Doubles\Stubs\Attributes\TestStringable;

describe(class_basename(Scope::class), function (): void {
    it('can fall back to default scope', function (): void {
        $scope = new Scope();
        expect($scope->name)->toBe([Scope::DEFAULT]);
    });

    it('can accept string as scope name', function (): void {
        $scope = new Scope('scope');
        expect($scope->name)->toBe(['scope']);
    });

    it('can accept array of strings as scope name', function (): void {
        $scope = new Scope(['scope1', 'scope2']);
        expect($scope->name)->toBe(['scope1', 'scope2']);
    });

    it('can accept array of stringables as scope name', function (): void {
        $scope = new Scope([TestStringable::class]);
        expect($scope->name)->toBe(['stringable']);
    });

    it('can accept mixed array of strings and stringables as scope name', function (): void {
        $scope = new Scope(['scope', TestStringable::class]);
        expect($scope->name)->toBe(['scope', 'stringable']);
    });
})->covers(Scope::class);
