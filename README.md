# Konekt Decimal

[![Travis Build Status](https://img.shields.io/travis/artkonekt/decimal.svg?style=flat-square)](https://travis-ci.org/artkonekt/decimal)
[![Packagist Stable Version](https://img.shields.io/packagist/v/konekt/decimal.svg?style=flat-square&label=stable)](https://packagist.org/packages/konekt/decimal)
[![Packagist Dev Version](https://img.shields.io/packagist/vpre/konekt/decimal.svg?style=flat-square&label=dev)](https://packagist.org/packages/konekt/decimal)
[![Packagist downloads](https://img.shields.io/packagist/dt/konekt/decimal.svg?style=flat-square)](https://packagist.org/packages/konekt/decimal)
[![StyleCI](https://styleci.io/repos/114921055/shield?branch=master)](https://styleci.io/repos/114921055)
[![MIT Software License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE)

## PHP Decimal Class

> This library is a slightly streamlined remake of the [php-decimal library](https://github.com/direvus/php-decimal)

The PHP language only offers two numeric data types: int and float. Neither of
these types are suitable for a substantial set of real-world problems, where
exact arithmetic with values of arbitrary precision are required -- notably,
when working with monetary values.

PHP's optional extension BCMath provides some limited features in this area, but
it is awkward to use when precision is variable, and it does not support
rounding.

This library uses the BCMath functions internally, but hides them behind a more
convenient, object-oriented, and intuitive API.

## Installation

using composer: `composer require konekt/decimal`

