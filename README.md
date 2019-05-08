# Laravel Cards

[![Latest Stable Version on Packagist](https://img.shields.io/packagist/v/davide-casiraghi/laravel-cards.svg?style=flat-square)](https://packagist.org/packages/davide-casiraghi/laravel-cards)
[![StyleCI](https://styleci.io/repos/185434966/shield?style=flat-square)](https://styleci.io/repos/185434966)
<a href="https://travis-ci.org/davide-casiraghi/laravel-cards"><img src="https://travis-ci.org/davide-casiraghi/laravel-cards.svg" alt="Build Status"></a>
[![Quality Score](https://img.shields.io/scrutinizer/g/davide-casiraghi/laravel-cards.svg?style=flat-square)](https://scrutinizer-ci.com/g/davide-casiraghi/laravel-cards)
[![Coverage Status](https://scrutinizer-ci.com/g/davide-casiraghi/laravel-cards/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/davide-casiraghi/laravel-cards/)
<a href="https://codeclimate.com/github/davide-casiraghi/laravel-cards/maintainability"><img src="https://api.codeclimate.com/v1/badges/d5cb79bbd0e9b3a2940e/maintainability" /></a>
[![GitHub last commit](https://img.shields.io/github/last-commit/davide-casiraghi/laravel-cards.svg)](https://github.com/davide-casiraghi/laravel-cards) 


This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what PSRs you support to avoid any confusion with users and contributors.

The library replace all the occurances of this snippet
```
{# card post_id=[6] img_alignment=[right] img_col_size=[3] bkg_color=[#345642] text_color=[#212529] container_wrap=[false] #}
```
With the HTML code of a responsive card made by text on one side and an image on the other.
```html
<div class="accordion">
    <div class="accordion-header collapsed" data-toggle="collapse" data-target="#collapse_1" aria-expanded="false">
        <div class="icon caret-svg"></div>
        Title First Slide
    </div>
    <div class="accordion-body collapse" id="collapse_1" style="">
        <div class="accordion-body-content">This is the first slide. </div>
    </div>
</div>
```

## Installation

You can install the package via composer:

```bash
composer require davide-casiraghi/laravel-cards
```

## Usage

``` php
use DavideCasiraghi\LaravelCards\Facades\LaravelCards;  

$text = LaravelCards::replace_card_strings_with_template(text);
```

### Testing

``` bash
composer test
```

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

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
