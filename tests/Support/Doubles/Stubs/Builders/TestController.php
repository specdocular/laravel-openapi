<?php

namespace Tests\Support\Doubles\Stubs\Builders;

class TestController
{
    public function actionWithTypeHintedParams(int $id, $unHinted, \stdClass $unknown): void
    {
    }
}
