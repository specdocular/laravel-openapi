<?php

namespace Specdocular\LaravelOpenAPI\Factories;

use Specdocular\OpenAPI\Extensions\Extension;
use Specdocular\OpenAPI\Schema\Objects\Contact\Contact;
use Specdocular\OpenAPI\Schema\Objects\Info\Info;
use Specdocular\OpenAPI\Schema\Objects\License\License;
use Specdocular\OpenAPI\Schema\Objects\OpenAPI\OpenAPI;
use Specdocular\OpenAPI\Schema\Objects\Security\Security;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityRequirement\RequiredSecurity;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityRequirement\SecurityRequirement;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\OAuth\ScopeCollection;
use Specdocular\OpenAPI\Schema\Objects\Server\Server;
use Specdocular\OpenAPI\Schema\Objects\Tag\Tag;
use Workbench\App\Petstore\Security\Scopes\OrderShippingAddressScope;
use Workbench\App\Petstore\Security\Scopes\OrderShippingStatusScope;
use Workbench\App\Petstore\Security\SecuritySchemes\TestBearerSecuritySchemeFactory;
use Workbench\App\Petstore\Security\SecuritySchemes\TestOAuth2PasswordSecuritySchemeFactory;

final readonly class ExampleFactory extends OpenAPIFactory
{
    public function instance(): OpenAPI
    {
        return OpenAPI::v311(
            Info::create(
                'https://laragen.io',
                '1.0.0',
            )->summary('Default OpenAPI Specification')
                ->description(
                    'This is the default OpenAPI specification for the application.',
                )->contact(
                    Contact::create()
                        ->name('Example Contact')
                        ->email('example@example.com')
                        ->url('https://example.com/'),
                )->license(
                    License::create('MIT')
                        ->url('https://github.com/'),
                ),
        )->servers(
            Server::create('https://laragen.io'),
        )->security(
            Security::create(
                SecurityRequirement::create(
                    RequiredSecurity::create(
                        TestBearerSecuritySchemeFactory::create(),
                    ),
                ),
                SecurityRequirement::create(
                    RequiredSecurity::create(
                        TestBearerSecuritySchemeFactory::create(),
                    ),
                    RequiredSecurity::create(
                        TestOAuth2PasswordSecuritySchemeFactory::create(),
                        ScopeCollection::create(
                            OrderShippingAddressScope::create(),
                            OrderShippingStatusScope::create(),
                        ),
                    ),
                ),
            ),
        )->tags(
            Tag::create('test')->description('This is a test tag.'),
        )->addExtension(
            Extension::create('x-example', [
                'name' => 'General',
                'tags' => [
                    'user',
                ],
            ]),
        );
    }
}
