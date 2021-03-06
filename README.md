# Laravel Cards

[![Latest Stable Version on Packagist](https://img.shields.io/packagist/v/davide-casiraghi/laravel-cards.svg?style=flat-square)](https://packagist.org/packages/davide-casiraghi/laravel-cards)
[![StyleCI](https://styleci.io/repos/185434966/shield?style=flat-square)](https://styleci.io/repos/185434966)
<a href="https://travis-ci.org/davide-casiraghi/laravel-cards"><img src="https://travis-ci.org/davide-casiraghi/laravel-cards.svg" alt="Build Status"></a>
[![Quality Score](https://img.shields.io/scrutinizer/g/davide-casiraghi/laravel-cards.svg?style=flat-square)](https://scrutinizer-ci.com/g/davide-casiraghi/laravel-cards)
[![Coverage Status](https://scrutinizer-ci.com/g/davide-casiraghi/laravel-cards/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/davide-casiraghi/laravel-cards/)
<a href="https://codeclimate.com/github/davide-casiraghi/laravel-cards/maintainability"><img src="https://api.codeclimate.com/v1/badges/d5cb79bbd0e9b3a2940e/maintainability" /></a>
[![GitHub last commit](https://img.shields.io/github/last-commit/davide-casiraghi/laravel-cards.svg)](https://github.com/davide-casiraghi/laravel-cards) 


This Laravel package show a responsive card made by text on one side of the page and an image on the other.

The library replace all the occurances of this snippet
```
{# card card_id=[1] #}
```
With the some HTML code of a responsive card made by text on one side and an image on the other.  
This code uses **bootstrap 4**.
```html
<div class='row laravel-card' style='background-color: #345642;color: #212529;'>
	<div class='text col-md-9 my-auto px-4 order-md-1'>
		<h2 class='laravel-card-heading mt-5'>".$card_1['title']."</h2>
		<div class='lead mb-4'>".$card_1['body']."</div>
	</div>
<div class='image col-md-3 order-md-2'></div>

</div>
```

## Installation

You can install the package via composer:

```bash composer require davide-casiraghi/laravel-cards ```

### Publish all the vendor files
```php artisan vendor:publish --force```

### Import the _card.scss file in /resources/scss/app.scss
```php
@import 'vendor/laravel-cards/card';
```

and then run in console:  
```npm run dev```  

## Usage

### Authorization
> To work the package aspect that in your user model and table you have a field called **group** that can have this possible values:
- null: Registered user 
- 1: Super Admin
- 2: Admin

> Just the users that have **Admin** and **Super admin** privileges can access to the routes that allow to create, edit and delete the blogs, categories and posts. Otherwise you get redirected to the homepage.


### Access to the package
After the package is published this new route will be available:

``` /laravel-cards ```

Accessing to this routes you can manage the cards.


Then to replace all the occurrance of the card snippets:

``` php
use DavideCasiraghi\LaravelCards\Facades\LaravelCards;  

$text = LaravelCards::replace_card_snippets_with_template($text);
```

### Testing

``` bash ./vendor/bin/phpunit --coverage-html=html ```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email davide.casiraghi@gmail.com instead of using the issue tracker.

## Credits

- [Davide Casiraghi](https://github.com/davide-casiraghi)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
