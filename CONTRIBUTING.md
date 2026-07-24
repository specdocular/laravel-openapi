# Contributing to Laravel OpenAPI

Thanks for your interest in improving Laravel OpenAPI — OpenAPI 3.1.x specification
generation for Laravel applications. This guide covers how to set up the project, the
checks your change must pass, and how releases are versioned.

## Code of conduct

Be respectful and constructive. Harassment or abuse of any kind is not tolerated in
issues, pull requests, or discussions.

## Getting started

Laravel OpenAPI is a Laravel package developed against [Orchestra Testbench][testbench],
so you do not need a host Laravel application to work on it.

```bash
git clone https://github.com/specdocular/laravel-openapi.git
cd laravel-openapi
composer install
```

`composer install` runs `package:discover` via the Testbench workbench, so the package
is ready to exercise immediately.

## Making a change

1. Open an issue first for anything beyond a small fix, so the approach can be agreed
   before you invest time.
2. Branch from `main`.
3. Write tests for your change — this package is developed test-first and every
   behavioral change ships with coverage.
4. Keep commits focused and atomic.

## Required checks

Every pull request must pass all three of the checks that CI enforces. Run them
locally before pushing:

```bash
composer test     # Pest test suite (workbench)
composer lint     # PHPStan static analysis
composer fixer    # PHP-CS-Fixer (formatting)
```

- **Tests** — `composer test` must be green. New behavior needs new tests; fixed bugs
  need a regression test that fails before the fix.
- **Static analysis** — `composer lint` must report no errors.
- **Formatting** — `composer fixer` auto-formats; run it and commit the result so the
  `PHP-CS-Fixer` workflow stays green.

## Pull requests

- Describe *what* changed and *why*, and link the issue it closes.
- Keep the diff scoped to the change — avoid unrelated refactors or reformatting.
- Update `CHANGELOG.md` under the `[Unreleased]` heading (see
  [Keep a Changelog][keepachangelog]).

## Versioning

Laravel OpenAPI follows [Semantic Versioning 2.0.0][semver]. Releases are git tags of
the form `vMAJOR.MINOR.PATCH` (for example `v0.3.0`).

- **Pre-1.0 (`0.x`):** the API is still stabilizing. A minor bump (`0.1 → 0.2`) may
  contain breaking changes; patch bumps (`0.1.0 → 0.1.1`) are backwards-compatible.
- **1.0 and later:** MAJOR for breaking changes, MINOR for backwards-compatible
  features, PATCH for backwards-compatible fixes.

Each release updates `CHANGELOG.md` (moving `[Unreleased]` entries under the new
version) and is tagged from `main`.

## Licensing of contributions

Laravel OpenAPI is licensed under the [MIT License](LICENSE). By contributing, you agree
that your contributions are licensed under the same terms.

[testbench]: https://github.com/orchestral/testbench
[keepachangelog]: https://keepachangelog.com/en/1.1.0/
[semver]: https://semver.org/spec/v2.0.0.html
