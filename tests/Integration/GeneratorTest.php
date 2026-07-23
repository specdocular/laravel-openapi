<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Specdocular\LaravelOpenAPI\Attributes\Document;
use Specdocular\LaravelOpenAPI\Factories\OpenAPIFactory;
use Specdocular\LaravelOpenAPI\Generator;
use Specdocular\OpenAPI\Schema\Objects\Info\Info;
use Specdocular\OpenAPI\Schema\Objects\OpenAPI\OpenAPI;
use Tests\Support\Doubles\Stubs\Objects\MultiActionController;

describe(class_basename(Generator::class), function (): void {
    it('should generate OpenApi object', function (string $document, array $expectation): void {
        Route::get('/test', [MultiActionController::class, 'anotherExample']);
        $factory = Factory::class;

        Config::set('openapi', [
            'documents' => [
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
        Config::set('openapi.document.default.include_routes_without_attribute', false);
        $openApi = app(Generator::class)->generate($document);

        $result = $openApi->compile();

        expect($result['components'])->toEqual($expectation['components'])
            ->and($result['paths'])->toEqual($expectation['paths']);
    })->with([
        'default document' => [
            'document' => Document::DEFAULT,
            'expectation' => [
                'paths' => [],
                'components' => [
                    'callbacks' => [
                        'MultiDocumentCallback' => [
                            'https://laragen.io/multi-collection-callback' => [],
                        ],
                        'ImplicitDefaultCallback' => [
                            'https://laragen.io/implicit-default-callback' => [],
                        ],
                    ],
                ],
            ],
        ],
        'example document' => [
            'document' => 'example',
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
                        'MultiDocumentResponse' => [
                            'description' => 'OK',
                        ],
                    ],
                ],
            ],
        ],
        'test document' => [
            'document' => 'test',
            'expectation' => [
                'paths' => [],
                'components' => [
                    'schemas' => [
                        'ExplicitDocumentSchema' => [
                            'type' => 'object',
                            'properties' => [
                                'id' => [
                                    'type' => 'integer',
                                ],
                            ],
                        ],
                        'MultiDocumentSchema' => [
                            'type' => 'object',
                            'properties' => [
                                'id' => [
                                    'type' => 'integer',
                                ],
                            ],
                        ],
                    ],
                    'requestBodies' => [
                        'MultiDocumentRequestBody' => [
                            'content' => [
                                'application/json' => [],
                            ],
                        ],
                        'ExplicitDocumentRequestBody' => [
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
