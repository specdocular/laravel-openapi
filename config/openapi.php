<?php

use Specdocular\LaravelOpenAPI\Factories\DefaultFactory;

return [
    /*
     * Document configuration.
     */
    'document' => [
        /*
         * The default document configuration.
         */
        'default' => [
            /*
             * The default document name to use when no explicit document is specified.
             */
            'name' => 'default',

            /*
             * Indicates if the routes that doesn't have explicit Document attributes
             * should be considered under default document or not.
             */
            'include_routes_without_attribute' => false,
        ],
        /*
         * Indicates if the action-level Document attribute should override the
         * controller-level Document attribute or not.
         */
        'action_attribute_overrides_controller_attribute' => true,
    ],
    'documents' => [
        'default' => [
            'openapi' => DefaultFactory::class,
            // Route for exposing specification.
            // Leave uri null to disable.
            'route' => [
                'uri' => '/openapi',
                'middleware' => [],
            ],
            // Directories to use for locating OpenAPI object definitions.
            'components' => [
                'schemas' => [
                    app_path('OpenAPI/Schemas'),
                ],

                'responses' => [
                    app_path('OpenAPI/Responses'),
                ],

                'parameters' => [
                    app_path('OpenAPI/Parameters'),
                ],

                'examples' => [
                    app_path('OpenAPI/Examples'),
                ],

                'request_bodies' => [
                    app_path('OpenAPI/RequestBodies'),
                ],

                'headers' => [
                    app_path('OpenAPI/Headers'),
                ],

                'security_schemes' => [
                    app_path('OpenAPI/SecuritySchemes'),
                ],

                'links' => [
                    app_path('OpenAPI/Links'),
                ],

                'callbacks' => [
                    app_path('OpenAPI/Callbacks'),
                ],

                'path_items' => [
                    app_path('OpenAPI/PathItems'),
                ],
            ],
        ],
    ],
];
