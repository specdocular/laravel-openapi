<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(
    static function (): void {
        Route::get(
            '/healthcheck',
            static function (): array {
                return [
                    'status' => 'up',
                    'services' => [
                        'database' => 'up',
                        'redis' => 'up',
                    ],
                ];
            },
        );
    },
);
