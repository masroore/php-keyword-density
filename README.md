# PHP Keyword Density, Word Frequency

[![Latest Version on Packagist](https://img.shields.io/packagist/v/masroore/keyword-density.svg?style=flat-square)](https://packagist.org/packages/masroore/keyword-density)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/masroore/keyword-density/run-tests?label=tests)](https://github.com/masroore/keyword-density/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/masroore/keyword-density/Check%20&%20fix%20styling?label=code%20style)](https://github.com/masroore/keyword-density/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/masroore/keyword-density.svg?style=flat-square)](https://packagist.org/packages/masroore/keyword-density)

Calculates the keyword density of a text as described in [Wikipedia](https://en.wikipedia.org/wiki/Keyword_density).
Counts the frequency usage of each word in a text.

Collision was created by, and is maintained by **[Masroor Ehsan](https://github.com/masroore)**, and is a PHP package
calculate the keyword density of a text as described in [Wikipedia](https://en.wikipedia.org/wiki/Keyword_density).
Keyword density is the percentage of times a keyword or phrase appears on a text compared to the total number of words
on the text. The word frequency counter PHP package can be used to count the frequency usage of each word in a text.

## Installation

> **Requires [PHP 8.0+](https://php.net/releases/)**

You can install the package via composer:

```bash
composer require masroore/keyword-density
```

## Usage

```php
$kw = new Kaiju\KeywordDensity\KeywordDensity();
$kw->setText($text);
print_r($kw->getPopularWords());
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Thank you for considering to contribute to this project. All the contribution guidelines are
mentioned [here](CONTRIBUTING.md).

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Masroor Ehsan](https://github.com/masroore)
- [All Contributors](../../contributors)

## License

This project is an open-sourced software licensed under the [MIT license](LICENSE.md).
