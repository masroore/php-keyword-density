# This is my package word-frequency

[![Latest Version on Packagist](https://img.shields.io/packagist/v/masroore/word-frequency.svg?style=flat-square)](https://packagist.org/packages/masroore/word-frequency)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/masroore/word-frequency/run-tests?label=tests)](https://github.com/masroore/word-frequency/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/masroore/word-frequency/Check%20&%20fix%20styling?label=code%20style)](https://github.com/masroore/word-frequency/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/masroore/word-frequency.svg?style=flat-square)](https://packagist.org/packages/masroore/word-frequency)

Word frequency counter allows you to count the frequency usage of each word in a text.

## Installation

You can install the package via composer:

```bash
composer require masroore/word-frequency
```

## Usage

```php
$wordFrequency = new WordFrequency\WordFrequency();
echo $wordFrequency->echoPhrase('Hello, WordFrequency!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Masroor Ehsan](https://github.com/masroore)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
