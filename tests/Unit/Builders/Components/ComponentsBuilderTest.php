<?php

use Illuminate\Support\Facades\Config;
use Pest\Expectation;
use Specdocular\LaravelOpenAPI\Attributes\Document;
use Specdocular\LaravelOpenAPI\Builders\ComponentsBuilder\ComponentsBuilder;
use Specdocular\OpenAPI\Schema\Objects\Components\Components;

describe(class_basename(ComponentsBuilder::class), function (): void {
    beforeEach(function (): void {
        $componentPaths = [
            'headers' => [
                __DIR__ . '/../../../Support/Doubles/Stubs/Builders/Components/Header',
            ],
            'security_schemes' => [
                __DIR__ . '/../../../Support/Doubles/Stubs/Builders/Components/SecurityScheme',
            ],
            'links' => [
                __DIR__ . '/../../../Support/Doubles/Stubs/Builders/Components/Link',
            ],
            'callbacks' => [
                __DIR__ . '/../../../Support/Doubles/Stubs/Builders/Components/Callback',
            ],
            'path_items' => [
                __DIR__ . '/../../../Support/Doubles/Stubs/Builders/Components/PathItem',
            ],
            'schemas' => [
                __DIR__ . '/../../../Support/Doubles/Stubs/Builders/Components/Schema',
            ],
            'responses' => [
                __DIR__ . '/../../../Support/Doubles/Stubs/Builders/Components/Response',
            ],
            'parameters' => [
                __DIR__ . '/../../../Support/Doubles/Stubs/Builders/Components/Parameter',
            ],
            'examples' => [
                __DIR__ . '/../../../Support/Doubles/Stubs/Builders/Components/Example',
            ],
            'request_bodies' => [
                __DIR__ . '/../../../Support/Doubles/Stubs/Builders/Components/RequestBody',
            ],
        ];
        Config::set('openapi', [
            'documents' => [
                'default' => [
                    'components' => $componentPaths,
                ],
                'test' => [
                    'components' => $componentPaths,
                ],
            ],
        ]);
    });

    it('can collect components', function (string|null $document, array|null $expectation): void {
        $componentsBuilder = app(ComponentsBuilder::class);

        /** @var Components|null $result */
        $result = $componentsBuilder->build($document);

        when(
            is_null($expectation),
            function () use ($result): Expectation {
                return expect($result)->toBeNull();
            },
        );

        when(
            !is_null($expectation),
            function () use ($result, $expectation): Expectation {
                return expect($result->compile())->toEqualCanonicalizing($expectation);
            },
        );
    })->with(
        [
            'none existing document' => [
                'document' => 'unknown',
                'expectation' => null,
            ],
            'test document' => [
                'document' => 'test',
                'expectation' => [
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
                    'responses' => [
                        'MultiDocumentResponse' => [
                            'description' => 'OK',
                        ],
                        'ExplicitDocumentResponse' => [
                            'description' => 'OK',
                        ],
                    ],
                    'parameters' => [
                        'MultiDocumentParameter' => [
                            'name' => 'test',
                            'in' => 'cookie',
                            'schema' => [
                                'type' => 'string',
                            ],
                        ],
                        'ExplicitDocumentParameter' => [
                            'name' => 'user_id',
                            'in' => 'path',
                            'schema' => [
                                'type' => 'string',
                            ],
                        ],
                    ],
                    'examples' => [
                        'MultiDocumentExample' => [
                            'value' => 'Example Value',
                        ],
                        'ExplicitDocumentExample' => [
                            'value' => 'Example Value',
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
                    'headers' => [
                        'ExplicitDocumentHeader' => [],
                        'MultiDocumentHeader' => [],
                    ],
                    'securitySchemes' => [
                        'ExplicitDocumentSecurityScheme' => [
                            'type' => 'http',
                            'scheme' => 'basic',
                        ],
                        'MultiDocumentSecurityScheme' => [
                            'type' => 'http',
                            'scheme' => 'basic',
                        ],
                    ],
                    'links' => [
                        'MultiDocumentLink' => [],
                        'ExplicitDocumentLink' => [],
                    ],
                    'callbacks' => [
                        'ExplicitDocumentCallback' => [
                            'https://laragen.io/explicit-collection-callback' => [],
                        ],
                        'MultiDocumentCallback' => [
                            'https://laragen.io/multi-collection-callback' => [],
                        ],
                    ],
                    'pathItems' => [
                        'MultiDocumentPathItem' => [],
                        'ExplicitDocumentPathItem' => [],
                    ],
                ],
            ],
            'explicit default document' => [
                'document' => Document::DEFAULT,
                'expectation' => [
                    'schemas' => [
                        'ImplicitDefaultSchema' => [
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
                    'responses' => [
                        'ImplicitDefaultResponse' => [
                            'description' => 'OK',
                        ],
                        'MultiDocumentResponse' => [
                            'description' => 'OK',
                        ],
                    ],
                    'parameters' => [
                        'MultiDocumentParameter' => [
                            'name' => 'test',
                            'in' => 'cookie',
                            'schema' => [
                                'type' => 'string',
                            ],
                        ],
                        'ImplicitDefaultParameter' => [
                            'name' => 'limit',
                            'in' => 'query',
                            'schema' => [
                                'type' => 'integer',
                            ],
                        ],
                    ],
                    'examples' => [
                        'ImplicitDefaultExample' => [
                            'externalValue' => 'Example External Value',
                        ],
                        'MultiDocumentExample' => [
                            'value' => 'Example Value',
                        ],
                    ],
                    'requestBodies' => [
                        'ImplicitDefaultRequestBody' => [
                            'content' => [
                                'application/json' => [],
                            ],
                        ],
                        'MultiDocumentRequestBody' => [
                            'content' => [
                                'application/json' => [],
                            ],
                        ],
                    ],
                    'headers' => [
                        'MultiDocumentHeader' => [],
                        'ImplicitDefaultHeader' => [],
                    ],
                    'securitySchemes' => [
                        'MultiDocumentSecurityScheme' => [
                            'type' => 'http',
                            'scheme' => 'basic',
                        ],
                        'ImplicitDefaultSecurityScheme' => [
                            'type' => 'http',
                            'scheme' => 'basic',
                        ],
                    ],
                    'links' => [
                        'MultiDocumentLink' => [],
                        'ImplicitDefaultLink' => [],
                    ],
                    'callbacks' => [
                        'ImplicitDefaultCallback' => [
                            'https://laragen.io/implicit-default-callback' => [],
                        ],
                        'MultiDocumentCallback' => [
                            'https://laragen.io/multi-collection-callback' => [],
                        ],
                    ],
                    'pathItems' => [
                        'MultiDocumentPathItem' => [],
                        'ImplicitDefaultPathItem' => [],
                    ],
                ],
            ],
        ],
    );
})->covers(ComponentsBuilder::class);
