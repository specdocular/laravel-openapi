<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Specdocular\LaravelOpenAPI\Attributes\Scope;
use Specdocular\LaravelOpenAPI\Factories\OpenAPIFactory;
use Specdocular\LaravelOpenAPI\Generator;
use Specdocular\OpenAPI\Schema\Objects\Info\Info;
use Specdocular\OpenAPI\Schema\Objects\OpenAPI\OpenAPI;
use Tests\Support\Doubles\Stubs\Objects\MultiActionController;

describe(class_basename(Generator::class), function (): void {
    it('should generate OpenApi object', function (string $scope, array $expectation): void {
        Route::get('/test', [MultiActionController::class, 'anotherExample']);
        $factory = Factory::class;

        Config::set('openapi', [
            'scopes' => [
                'default' => [
                    'openapi' => $factory,
                    'components' => [
                        'callbacks' => [
                            __DIR__ . '/../Support/Doubles/Stubs/Builders/Components/Callback',
                        ],
                    ],
                ],
                'example' => [
                    'openapi' => $factory,
                    'components' => [
                        'responses' => [
                            __DIR__ . '/../Support/Doubles/Stubs/Builders/Components/Response',
                        ],
                    ],
                ],
                'test' => [
                    'openapi' => $factory,
                    'components' => [
                        'schemas' => [
                            __DIR__ . '/../Support/Doubles/Stubs/Builders/Components/Schema',
                        ],
                        'request_bodies' => [
                            __DIR__ . '/../Support/Doubles/Stubs/Builders/Components/RequestBody',
                        ],
                    ],
                ],
            ],
        ]);
        Config::set('openapi.scope.default.include_routes_without_attribute', false);
        $openApi = app(Generator::class)->generate($scope);

        $result = $openApi->compile();

        expect($result['components'])->toEqual($expectation['components'])
            ->and($result['paths'])->toEqual($expectation['paths']);
    })->with([
        'default scope' => [
            'scope' => Scope::DEFAULT,
            'expectation' => [
                'paths' => [],
                'components' => [
                    'callbacks' => [
                        'MultiScopeCallback' => [
                            'https://laragen.io/multi-collection-callback' => [],
                        ],
                        'ImplicitDefaultCallback' => [
                            'https://laragen.io/implicit-default-callback' => [],
                        ],
                    ],
                ],
            ],
        ],
        'example scope' => [
            'scope' => 'example',
            'expectation' => [
                'paths' => [
                    '/test' => [
                        'get' => [
                            'operationId' => 'anotherExample',
                            'responses' => [
                                '422' => [
                                    '$ref' => '#/components/responses/ValidationErrorResponse',
                                ],
                            ],
                        ],
                    ],
                ],
                'components' => [
                    'responses' => [
                        'ValidationErrorResponse' => [
                            'description' => 'Unprocessable Entity',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'message' => [
                                                'type' => 'string',
                                                'examples' => ['The given data was invalid.'],
                                            ],
                                            'errors' => [
                                                'type' => 'object',
                                                'additionalProperties' => [
                                                    'type' => 'array',
                                                    'items' => [
                                                        'type' => 'string',
                                                    ],
                                                ],
                                                'examples' => [
                                                    [
                                                        'field' => [
                                                            'Something is wrong with this field!',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'MultiScopeResponse' => [
                            'description' => 'OK',
                        ],
                    ],
                ],
            ],
        ],
        'test scope' => [
            'scope' => 'test',
            'expectation' => [
                'paths' => [],
                'components' => [
                    'schemas' => [
                        'ExplicitScopeSchema' => [
                            'type' => 'object',
                            'properties' => [
                                'id' => [
                                    'type' => 'integer',
                                ],
                            ],
                        ],
                        'MultiScopeSchema' => [
                            'type' => 'object',
                            'properties' => [
                                'id' => [
                                    'type' => 'integer',
                                ],
                            ],
                        ],
                    ],
                    'requestBodies' => [
                        'MultiScopeRequestBody' => [
                            'content' => [
                                'application/json' => [],
                            ],
                        ],
                        'ExplicitScopeRequestBody' => [
                            'content' => [
                                'application/json' => [],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ]);
})->covers(Generator::class);

final readonly class Factory extends OpenAPIFactory
{
    public function instance(): OpenAPI
    {
        return OpenAPI::v311(
            Info::create(
                'https://laragen.io',
                '1.0.0',
            ),
        );
    }
}
