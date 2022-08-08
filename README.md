<img src="package-banner@2x.png" title="Laravel Route Registrars" alt="A Laravel package that introduces a clean object based alternative to Laravel route files.">

![Packagist Version](https://img.shields.io/packagist/v/olliecodes/laravel-route-registrars)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/olliecodes/laravel-route-registrars)
![GitHub](https://img.shields.io/github/license/olliecodes/laravel-route-registrars)
[![codecov](https://codecov.io/gh/olliecodes/laravel-route-registrars/branch/main/graph/badge.svg?token=FHJ41NQMTA)](https://codecov.io/gh/olliecodes/laravel-route-registrars)

## Laravel Route Registrars
This package introduces a clean object based way to define your routes in a Laravel application. A tutorial on the basic premise exists on [Laravel news](https://laravel-news.com/route-registrars), written by [@juststeveking](https://twitter.com/JustSteveKing).

## Install

Install via composer.

```bash
$ composer require olliecodes/laravel-route-registrars
```

### Fresh Laravel Installation

If you're installing this package on a fresh laravel installation, you'll want to run the following command before you do anything with your routes.

```bash
php artisan init:routing
```

This will overwrite the `app/Providers/RouteServiceProvider.php` file with one compatible with the route registrars, and create default route registrars to replace both `routes/web.php` and `routes/api.php`.

### Existing Laravel Installation

If you have an existing application, it is recommended that you read through the Laravel News article that covers this approach, as you're going to have to manually refactor your route service provider and route files.

### Requirements

This package requires the following;

- PHP >= 8.0 (Including 8).
- `laravel/framework` >= 9.0

## Usage

To register new routes, you can either add their definitions to the `map` method of a `RouteRegistrar`, or create a new one.

### Creating a new registrar

The following command will create a new registrar inside `app/Http/Routes`.

```bash
php artisan make:registrar {name}
```

The `{name}` can be any valid class name, or sub-namespace. For example, using `Auth\\GuestRoutes` will create `app/Http/Routes/Auth/GuestRoutes.php`.

There are several options available when creating a registrar.

#### `--C|hasChildren`

Create a route registrar that has the `MapRouteRegistrars` trait so that it can map child registrars.

#### `--W|web`

Create the route registrar in `app/Http/Routes/Web`, an option left in for those of you that are splitting the Web and API routes.

#### `--A|API`

Exactly the same as the above option, except it creates it in `app/Http/Routes/Api`,