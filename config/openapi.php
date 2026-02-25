<?php

use Specdocular\LaravelOpenAPI\Factories\DefaultFactory;

return [
    /*
     * Scope configuration.
     */
    'scope' => [
        /*
         * The default scope configuration.
         */
        'default' => [
            /*
             * The default scope name to use when no explicit scope is specified.
             */
            'name' => 'default',

            /*
             * Indicates if the routes that doesn't have explicit Scope attributes
             * should be considered under default scope or not.
             */
            'include_routes_without_attribute' => false,
        ],
        /*
         * Indicates if the action-level Scope attribute should override the
         * controller-level Scope attribute or not.
         */
        'action_attribute_overrides_controller_attribute' => true,
    ],
    'scopes' => [
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
