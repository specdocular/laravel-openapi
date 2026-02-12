<?php

namespace Workbench\App\Documentation;

use Specdocular\LaravelOpenAPI\Factories\OpenAPIFactory;
use Specdocular\OpenAPI\Schema\Objects\Contact\Contact;
use Specdocular\OpenAPI\Schema\Objects\Info\Info;
use Specdocular\OpenAPI\Schema\Objects\License\License;
use Specdocular\OpenAPI\Schema\Objects\OpenAPI\OpenAPI;
use Specdocular\OpenAPI\Schema\Objects\Server\Server;

final readonly class Workbench extends OpenAPIFactory
{
    public function instance(): OpenAPI
    {
        return OpenAPI::v311(
            Info::create(
                'https://laragen.io',
                '1.0.3',
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
        )->security((new WorkbenchSecurity())->build());
    }
}
