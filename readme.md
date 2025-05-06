# Backpack-form
<p align="center">
<a href="https://packagist.org/packages/medianet-dev/backpack-form" title="Latest Version on Packagist"><img src="https://img.shields.io/packagist/v/medianet-dev/backpack-form.svg?logo=composer"></a>
<a href="https://scrutinizer-ci.com/g/Medianet-Tunisia/backpack-form" title="Quality Score"><img src="https://img.shields.io/scrutinizer/quality/g/Medianet-Tunisia/backpack-form.svg?b=main"></a>
<a href="https://packagist.org/packages/medianet-dev/backpack-form" title="Total Downloads"><img src="https://img.shields.io/packagist/dt/medianet-dev/backpack-form.svg"></a>
<a href="https://laravel.com/docs/8.x" title="Laravel Version"><img src="https://img.shields.io/badge/laravel-8.0+-red"></a>
</p>




FormBuilder is a Laravel package that provides a powerful and flexible way to dynamically create, manage, and render forms within your application.

## Features

- Build and configure forms dynamically  
- Support for multiple field types and validation rules  
- Store form definitions and submissions  
- Easy rendering in Blade views  
- JSON-based form schema support  
- Multilingual field support  
- API-ready form submission  

## Requirements

- PHP 7.4+
- Laravel 8.0+

## Installation

You can install the package via Composer:

```bash
composer require medianet-dev/formbuilder
```
After installation , run this command:

```bash
php artisan backpack-form:installation
php artisan migrate
```
After that you configure those variables in .env file with your paths :
```bash
FORMBUILDER_CSS_URL=
FORMBUILDER_JS_URL=
```





## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.


## Credits

- [Mehdi Dimassi](https://github.com/mehdidm/)
- [Rania Mersani](https://github.com/RaniaMersani)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
