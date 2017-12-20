# PHP Decimal Changelog

## 1.0 Series

### Unreleased
##### 2017-12-XX

Based on [direvus/php-decimal](https://github.com/direvus/php-decimal) as of
2017-12-20, with the following modifications:

- Use via composer
- PSR-4 class loading
- PSR-2 coding style
- License is MIT
- Minimum PHP is 7.x
- Variadic arguments are using the "..." notation
- Money formatters have been dropped
- PHPUnit 6.x, tests have been split in multiple files
- `DomainException`s have been converted to `InvalidArgumentException` and
  `DivisionByZeroError`
