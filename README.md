# forsyth-edwards-notation

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Total Downloads][ico-downloads]][link-downloads]

This library provides support for reading and writing chess boards in the Forsyth-Edwards notation.

## Installation

Via composer

```
composer require chesszebra/forsyth-edwards-notation
```

## Usage

### Parse a FEN

```php
use ChessZebra\ForsythEdwardsNotation\FenNotation;

$notation = new FenNotation('rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1');
```

### Convert a FEN to a string

```php
use ChessZebra\ForsythEdwardsNotation\FenNotation;

$notation = new FenNotation('rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1');

echo $notation->toString(); // or cast it: (string)$notation
```

### Validating a FEN

```php
use ChessZebra\ForsythEdwardsNotation\Validator;

$validator = new Validator();

$validationResult = $validator->validate('rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1');

// $validationResult is a ValidationResult constant. 
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please report them via [HackerOne][link-hackerone].

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/chesszebra/forsyth-edwards-notation.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/chesszebra/forsyth-edwards-notation/master.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/chesszebra/forsyth-edwards-notation.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/chesszebra/forsyth-edwards-notation
[link-travis]: https://travis-ci.org/chesszebra/forsyth-edwards-notation
[link-downloads]: https://packagist.org/packages/chesszebra/forsyth-edwards-notation
[link-contributors]: ../../contributors
[link-hackerone]: https://hackerone.com/chesszebra
