# Core plugin required for Catalyst

[![Latest Version on Packagist](https://img.shields.io/packagist/v/omnia-digital/catalyst-core-plugin.svg?style=flat-square)](https://packagist.org/packages/omnia-digital/catalyst-core-plugin)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/omnia-digital/catalyst-core-plugin/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/omnia-digital/catalyst-core-plugin/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/omnia-digital/catalyst-core-plugin/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/omnia-digital/catalyst-core-plugin/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/omnia-digital/catalyst-core-plugin.svg?style=flat-square)](https://packagist.org/packages/omnia-digital/catalyst-core-plugin)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require omnia-digital/catalyst-core-plugin
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="catalyst-core-plugin-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="catalyst-core-plugin-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="catalyst-core-plugin-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$catalyst = new OmniaDigital\Catalyst();
echo $catalyst->echoPhrase('Hello, OmniaDigital!');
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

- [Josh Torres](https://github.com/joshtorres)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
