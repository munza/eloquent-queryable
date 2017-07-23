# eloquent-queryable

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what
PSRs you support to avoid any confusion with users and contributors.


## Install

**Via Composer**

``` bash
$ composer require munza/eloquent-queryable
```

## Register

**in Laravel**

```php
// config/app.php

    'providers' => [
    // ...
        Munza\EloquentQueryable\EloquentQueryableServiceProvider::class,
    // ...
    ]
```

**in Lumen**

```php
// bootstrap/app.php

    // ...
    $app->register(Munza\EloquentQueryable\EloquentQueryableServiceProvider::class);
    // ...
```

## Configuration

**in Laravel**

```bash
$ php artisan vendor:publish --provider=Munza\EloquentQueryable\EloquentQueryableServiceProvider::class
```

**in Lumen**

```bash
$ cp vendor/munza/eloquent-queryable/resources/config/eloquent-queryable.php ./config
```

```php
// bootstrap/app.php
// ...
$app->configure('eloquent-queryable');
// ...
```

## Usage

Add `Munza\EloquentQueryable\Traits\RequestQueryable` trait in the model to use.

## Example Queries

```
http://localhost:8000/?q[select]=id,name
http://localhost:8000/?q[order_by]=name,desc;created_at
http://localhost:8000/?q[limit]=20
http://localhost:8000/?q[offset]=10
http://localhost:8000/?q[with]=posts,posts.comments

http://localhost:8000/?q[where_{column_name}_{postfix}]={values}
http://localhost:8000/?q[or_where_{column_name}_{postfix}]={values}

http://localhost:8000/?q[where_name_starts_with]=John
http://localhost:8000/?q[where_name_not_starts_with]=John

http://localhost:8000/?q[where_name_ends_with]=Doe
http://localhost:8000/?q[where_name_not_ends_with]=Doe

http://localhost:8000/?q[where_name_contains]=John
http://localhost:8000/?q[where_name_not_contains]=John

http://localhost:8000/?q[where_created_at_gt]=2017-07-19%2008:14:45
http://localhost:8000/?q[where_created_at_lt]=2017-07-19%2008:14:48

http://localhost:8000/?q[where_name_eq]=John%20Doe
http://localhost:8000/?q[where_name_ne]=John%20Doe

http://localhost:8000/?q[where_id_in]=1,2,3
http://localhost:8000/?q[where_id_not_in]=1,2,3

http://localhost:8000/?q[where_created_at_between]=2017-07-19%2008:14:45,2017-07-19%2008:14:48
http://localhost:8000/?q[where_created_at_not_between]=2017-07-19%2008:14:45,2017-07-19%2008:14:48
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email tawsif.aqib@gmail.com instead of using the issue tracker.

## Credits

- [Tawsif Aqib][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/munza/eloquent-queryable.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/munza/eloquent-queryable/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/munza/eloquent-queryable.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/munza/eloquent-queryable.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/munza/eloquent-queryable.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/munza/eloquent-queryable
[link-travis]: https://travis-ci.org/munza/eloquent-queryable
[link-scrutinizer]: https://scrutinizer-ci.com/g/munza/eloquent-queryable/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/munza/eloquent-queryable
[link-downloads]: https://packagist.org/packages/munza/eloquent-queryable
[link-author]: https://munza.github.io
[link-contributors]: ../../contributors
