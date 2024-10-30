# Manage Redirects in your Laravel application through Filament.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/vormkracht10/filament-redirects.svg?style=flat-square)](https://packagist.org/packages/vormkracht10/filament-redirects)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/vormkracht10/filament-redirects/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/vormkracht10/filament-redirects/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/vormkracht10/filament-redirects/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/vormkracht10/filament-redirects/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/vormkracht10/filament-redirects.svg?style=flat-square)](https://packagist.org/packages/vormkracht10/filament-redirects)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require vormkracht10/filament-redirects
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-redirects-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-redirects-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-redirects-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$filamentRedirects = new Vormkracht10\FilamentRedirects();
echo $filamentRedirects->echoPhrase('Hello, Vormkracht10!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Mark van Eijk](https://github.com/markvaneijk)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
