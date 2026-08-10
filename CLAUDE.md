# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Overview

`ellipsesynergie/api-response` is a small PHP library (PSR-4, namespace `EllipseSynergie\ApiResponse\`) for building consistent JSON API responses on top of [league/fractal](https://fractal.thephpleague.com). Requires PHP >= 8.3; tested against Laravel 11–13. Framework-agnostic core with a Laravel integration included. The `1.x` branch is a maintenance branch for PHP 8.1/Laravel 8-era users (it still contains the removed Lumen support); `master` is 2.x.

## Commands

```bash
composer install                  # install dependencies
composer test                     # run PHPUnit test suite
vendor/bin/phpunit tests/ResponseTest.php                 # run a single test file
vendor/bin/phpunit --filter testMethodName                # run a single test method
vendor/bin/phpstan analyze        # static analysis (level 5, baseline in phpstan-baseline.neon)
vendor/bin/psalm                  # static analysis (errorLevel 5, baseline in psalm.baseline.xml)
vendor/bin/phpcs src/             # coding style check (PSR-12, 150-char line limit; config in phpcs.xml)
```

CI (GitHub Actions) runs the test suite on a PHP 8.3/8.4/8.5 × Laravel 11/12/13 matrix (Laravel 11 + PHP 8.5 excluded), plus PHPStan + Psalm and phpcs. All three workflows must pass.

## Architecture

The core flow: user data + a Fractal transformer → Fractal `Manager` builds an array → `withArray()` (framework-specific) turns it into an HTTP response.

- **`src/AbstractResponse.php`** — the heart of the package. Implements `Contracts\Response`: `withItem()`, `withCollection()`, `withError()`, and the `error*()` helpers (each sets an HTTP status code and a `GEN-*` error code constant). Declares abstract `withArray()`, which is the single framework integration point subclasses must implement.
- **`src/Contracts/Response.php`** — interface consumers type-hint against (and the container binding key in Laravel).
- **`src/Laravel/Response.php`** — Laravel implementation: `withArray()` via `response()->json()`, plus `withPaginator()` (LengthAwarePaginator + `IlluminatePaginatorAdapter`) and `errorWrongArgsValidator()`.
- **`src/Laravel/ResponseServiceProvider.php`** — builds the Fractal `Manager`, sets the custom serializer, parses the `include` query param from the request, and binds the instance to `Contracts\Response`. Auto-discovered via `extra.laravel.providers` in composer.json. Also registers a deprecated `Response::api()` macro for backward compatibility. Override `getSerializer()` in a subclass to swap serializers.
- **`src/Serializer/Serializer.php`** — extends Fractal's `ArraySerializer` to support a custom resource key, defaulting to `data`.
- **`src/Testing/Laravel/AddTestingSupportForInclude.php`** — trait for consumers' Laravel tests to make the `include` query param work (see issue #31).

Tests mirror `src/` under `tests/`, using fakes (`ResponseFaker`, `ResponseFake`, `ResponseFactoryFake`) rather than a full framework boot.

## Conventions

- Response envelope is fixed: success payloads under a resource key (default `data`), errors as `{"error": {"code", "http_code", "message"}}`. Error codes are the `CODE_*` constants (`GEN-NOT-FOUND`, etc.) on `AbstractResponse`.
- Changes to response-building behavior usually touch the trio: `AbstractResponse`, `Contracts/Response`, and `Laravel/Response`.
- New static-analysis errors should be fixed rather than added to the baselines.
