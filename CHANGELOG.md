# Changelog

All notable changes to Laravel OpenAPI are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.3.0] - 2026-07-23

### Changed

- Renamed the generated-artifact concept `Scope` to `Document` for clearer domain
  language.

## [0.2.0] - 2026-02-25

### Added

- README with badges, usage examples, and ecosystem links.
- Codecov coverage reporting.

### Changed

- Renamed the `Collection` concept to `Scope` for clearer domain language.

## [0.1.0] - 2026-02-13

Initial release — OpenAPI 3.1.x specification generation for Laravel applications.

### Added

- Factory-based component system for schemas, responses, request bodies, and
  parameters.
- Auto-discovery of factory classes from configured directories.
- Multi-document support for separate API versions or modules.
- Route-based generation using Laravel route attributes.
- Built on [specdocular/php-openapi](https://github.com/specdocular/php-openapi) for the
  OpenAPI object model.

[Unreleased]: https://github.com/specdocular/laravel-openapi/compare/v0.3.0...HEAD
[0.3.0]: https://github.com/specdocular/laravel-openapi/compare/v0.2.0...v0.3.0
[0.2.0]: https://github.com/specdocular/laravel-openapi/compare/v0.1.0...v0.2.0
[0.1.0]: https://github.com/specdocular/laravel-openapi/releases/tag/v0.1.0
