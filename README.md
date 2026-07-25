# Laravel OpenAPI

[![Latest Version on Packagist](https://img.shields.io/packagist/v/specdocular/laravel-openapi.svg)](https://packagist.org/packages/specdocular/laravel-openapi)
[![PHP Version](https://img.shields.io/packagist/php-v/specdocular/laravel-openapi.svg)](https://packagist.org/packages/specdocular/laravel-openapi)
[![Tests](https://github.com/specdocular/laravel-openapi/actions/workflows/tests.yml/badge.svg)](https://github.com/specdocular/laravel-openapi/actions/workflows/tests.yml)
[![codecov](https://codecov.io/gh/specdocular/laravel-openapi/graph/badge.svg)](https://codecov.io/gh/specdocular/laravel-openapi)
[![Code Style](https://github.com/specdocular/laravel-openapi/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/specdocular/laravel-openapi/actions/workflows/php-cs-fixer.yml)

Generate [OpenAPI 3.1.x](https://spec.openapis.org/oas/v3.1.1.html) specifications for Laravel applications using a factory-based, "Laravel way" approach.

## Requirements

- PHP 8.2 or higher
- Laravel 10, 11, or 12

## Installation

```bash
composer require specdocular/laravel-openapi
```

The service provider is auto-discovered by Laravel. Publish the config:

```bash
php artisan vendor:publish --tag=openapi-config
```

## Usage

### 1. Create an OpenAPI Factory

```php
use Specdocular\LaravelOpenAPI\Factories\OpenAPIFactory;
use Specdocular\OpenAPI\Schema\Objects\OpenAPI\OpenAPI;
use Specdocular\OpenAPI\Schema\Objects\Info\Info;

class MyAPIFactory extends OpenAPIFactory
{
    public function instance(): OpenAPI
    {
        return OpenAPI::v311(
            Info::create('My API', '1.0.0')
                ->description('API documentation'),
        );
    }
}
```

#### Targeting an OpenAPI version

The target OAS version is a construction detail of the document, declared by the
factory you call — not a config key. `OpenAPI::v311(...)` emits OpenAPI 3.1.1 (the
default). To emit **OpenAPI 3.2.0**, call `OpenAPI::v320(...)` instead:

```php
    public function instance(): OpenAPI
    {
        return OpenAPI::v320(
            Info::create('My API', '1.0.0')
                ->description('API documentation'),
        );
    }
```

Both factories take the same `Info` and are otherwise interchangeable; the version
lives with the document because it co-varies with how the document is built.

### 2. Configure Documents

In `config/openapi.php`:

```php
'documents' => [
    'default' => [
        'openapi' => MyAPIFactory::class,
        'directories' => [
            app_path('OpenAPI'),
        ],
    ],
],
```

### 3. Create Component Factories

Define reusable request bodies, responses, schemas, and parameters as factory classes. Place them in your configured directories and they will be auto-discovered.

### 4. Generate the Spec

```php
$openApi = app(\Specdocular\LaravelOpenAPI\Generator::class)
    ->generate('default');

$json = json_encode($openApi, JSON_PRETTY_PRINT);
```

## Features

- Factory-based component system (schemas, responses, request bodies, parameters)
- Auto-discovery of factories from configured directories
- Multi-document support for separate API versions or modules
- Route-based generation using Laravel route attributes
- Built on [specdocular/php-openapi](https://github.com/specdocular/php-openapi) for the OpenAPI object model

## Related Packages

| Package | Description |
|---------|-------------|
| [specdocular/php-json-schema](https://github.com/specdocular/php-json-schema) | JSON Schema Draft 2020-12 builder |
| [specdocular/php-openapi](https://github.com/specdocular/php-openapi) | Object-oriented OpenAPI builder (foundation) |
| [specdocular/laravel-rules-to-schema](https://github.com/specdocular/laravel-rules-to-schema) | Convert Laravel validation rules to JSON Schema |

## Contributing

Contributions are welcome. See [CONTRIBUTING.md](CONTRIBUTING.md) for setup, the required checks, and versioning.

## Security

If you discover a security vulnerability, please follow the process in [SECURITY.md](SECURITY.md) rather than opening a public issue.

## License

MIT. See [LICENSE](LICENSE) for details.
