<?php

use Illuminate\Support\Facades\Config;
use Pest\Expectation;
use Specdocular\LaravelOpenAPI\Attributes\Scope;
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
            'scopes' => [
                'default' => [
                    'components' => $componentPaths,
                ],
                'test' => [
                    'components' => $componentPaths,
                ],
            ],
        ]);
    });

    it('can collect components', function (string|null $scope, array|null $expectation): void {
        $componentsBuilder = app(ComponentsBuilder::class);

        /** @var Components|null $result */
        $result = $componentsBuilder->build($scope);

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
            'none existing scope' => [
                'scope' => 'unknown',
                'expectation' => null,
            ],
            'test scope' => [
                'scope' => 'test',
                'expectation' => [
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
                    'responses' => [
                        'MultiScopeResponse' => [
                            'description' => 'OK',
                        ],
                        'ExplicitScopeResponse' => [
                            'description' => 'OK',
                        ],
                    ],
                    'parameters' => [
                        'MultiScopeParameter' => [
                            'name' => 'test',
                            'in' => 'cookie',
                            'schema' => [
                                'type' => 'string',
                            ],
                        ],
                        'ExplicitScopeParameter' => [
                            'name' => 'user_id',
                            'in' => 'path',
                            'schema' => [
                                'type' => 'string',
                            ],
                        ],
                    ],
                    'examples' => [
                        'MultiScopeExample' => [
                            'value' => 'Example Value',
                        ],
                        'ExplicitScopeExample' => [
                            'value' => 'Example Value',
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
                    'headers' => [
                        'ExplicitScopeHeader' => [],
                        'MultiScopeHeader' => [],
                    ],
                    'securitySchemes' => [
                        'ExplicitScopeSecurityScheme' => [
                            'type' => 'http',
                            'scheme' => 'basic',
                        ],
                        'MultiScopeSecurityScheme' => [
                            'type' => 'http',
                            'scheme' => 'basic',
                        ],
                    ],
                    'links' => [
                        'MultiScopeLink' => [],
                        'ExplicitScopeLink' => [],
                    ],
                    'callbacks' => [
                        'ExplicitScopeCallback' => [
                            'https://laragen.io/explicit-collection-callback' => [],
                        ],
                        'MultiScopeCallback' => [
                            'https://laragen.io/multi-collection-callback' => [],
                        ],
                    ],
                    'pathItems' => [
                        'MultiScopePathItem' => [],
                        'ExplicitScopePathItem' => [],
                    ],
                ],
            ],
            'explicit default scope' => [
                'scope' => Scope::DEFAULT,
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
                        'MultiScopeSchema' => [
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
                        'MultiScopeResponse' => [
                            'description' => 'OK',
                        ],
                    ],
                    'parameters' => [
                        'MultiScopeParameter' => [
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
                        'MultiScopeExample' => [
                            'value' => 'Example Value',
                        ],
                    ],
                    'requestBodies' => [
                        'ImplicitDefaultRequestBody' => [
                            'content' => [
                                'application/json' => [],
                            ],
                        ],
                        'MultiScopeRequestBody' => [
                            'content' => [
                                'application/json' => [],
                            ],
                        ],
                    ],
                    'headers' => [
                        'MultiScopeHeader' => [],
                        'ImplicitDefaultHeader' => [],
                    ],
                    'securitySchemes' => [
                        'MultiScopeSecurityScheme' => [
                            'type' => 'http',
                            'scheme' => 'basic',
                        ],
                        'ImplicitDefaultSecurityScheme' => [
                            'type' => 'http',
                            'scheme' => 'basic',
                        ],
                    ],
                    'links' => [
                        'MultiScopeLink' => [],
                        'ImplicitDefaultLink' => [],
                    ],
                    'callbacks' => [
                        'ImplicitDefaultCallback' => [
                            'https://laragen.io/implicit-default-callback' => [],
                        ],
                        'MultiScopeCallback' => [
                            'https://laragen.io/multi-collection-callback' => [],
                        ],
                    ],
                    'pathItems' => [
                        'MultiScopePathItem' => [],
                        'ImplicitDefaultPathItem' => [],
                    ],
                ],
            ],
        ],
    );
})->covers(ComponentsBuilder::class);
