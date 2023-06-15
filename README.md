<p align="center">
    <img src="https://raw.githubusercontent.com/gehrisandro/tailwind-merge-laravel/main/art/example.png" width="600" alt="Tailwind Merge for Laravel">
    <p align="center">
        <a href="https://github.com/gehrisandro/tailwind-merge-laravel/actions"><img alt="GitHub Workflow Status (main)" src="https://img.shields.io/github/actions/workflow/status/gehrisandro/tailwind-merge-laravel/tests.yml?branch=main&label=tests&style=round-square"></a>
        <a href="https://packagist.org/packages/gehrisandro/tailwind-merge-laravel"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/gehrisandro/tailwind-merge-laravel"></a>
        <a href="https://packagist.org/packages/gehrisandro/tailwind-merge-laravel"><img alt="Latest Version" src="https://img.shields.io/packagist/v/gehrisandro/tailwind-merge-laravel"></a>
        <a href="https://packagist.org/packages/gehrisandro/tailwind-merge-laravel"><img alt="License" src="https://img.shields.io/github/license/gehrisandro/tailwind-merge-laravel"></a>
    </p>
</p>

------

**Tailwind CSS Merge for Laravel** is a Laravel package that allows you to merge multiple Tailwind CSS classes by automatically resolving conflicts between classes by removing classes conflicting with a class defined later. This is especially helpful when you want to override Tailwind CSS classes in your Blade components. \
Essentially, a Laravel port of [tailwind-merge](https://github.com/dcastil/tailwind-merge) by [dcastil](https://github.com/dcastil).

Supports Tailwind v3.0 up to v3.3.

If you find this package helpful, please consider sponsoring the maintainer:
- Sandro Gehri: **[github.com/sponsors/gehrisandro](https://github.com/sponsors/gehrisandro)**

> **Attention:** This package is still in early development.

## Table of Contents
- [Get Started](#get-started)
- [Usage](#usage)
  - [Laravel Blade Components](#use-in-laravel-blade-components)
  - [Laravel Blade Directive](#use-laravel-blade-directive)
  - [Everywhere else in Laravel](#everywhere-else-in-laravel)
- [Configuration](#configuration)
  - [Custom Tailwind Config](#custom-tailwind-config)
- [Contributing](#contributing)

## Get Started
> **Requires [Laravel 10](https://github.com/laravel/laravel)**

First, install `TailwindMerge for Laravel` via the [Composer](https://getcomposer.org/) package manager:

```bash
composer require gehrisandro/tailwind-merge-laravel
```

Next, publish the configuration file:

```bash
php artisan vendor:publish --provider="TailwindMerge\Laravel\ServiceProvider"
```

This will create a `config/tailwind-merge.php` configuration file in your project, which you can modify to your needs
using environment variables. For more information, see the [Configuration](#configuration) section.

```env
TAILWIND_MERGE_PREFIX=tw-
```

Finally, you may use `TailwindMerge` in your Blade components:

```php
// circle.blade.php
<div {{ $attributes->mergeClasses('w-10 h-10 rounded-full bg-red-500') }}></div>

// your-view.blade.php
<x-circle class="bg-blue-500" />

// output
<div class="w-10 h-10 rounded-full bg-blue-500"></div>
```

`TailwindMerge` is not only capable of resolving conflicts between basic Tailwind CSS classes, but also handles more complex scenarios:

```php
use TailwindMerge\Laravel\Facades\TailwindMerge;

// conflicting classes
TailwindMerge::merge('block inline'); // inline
TailwindMerge::merge('pl-4 px-6'); // px-6

// non-conflicting classes
TailwindMerge::merge('text-xl text-black'); // text-xl text-black

// with breakpoints
TailwindMerge::merge('h-10 lg:h-12 lg:h-20'); // h-10 lg:h-20

// dark mode
TailwindMerge::merge('text-black dark:text-white dark:text-gray-700'); // text-black dark:text-gray-700

// with hover, focus and other states
TailwindMerge::merge('hover:block hover:inline'); // hover:inline

// with the important modifier
TailwindMerge::merge('!font-medium !font-bold'); // !font-bold

// arbitrary values
TailwindMerge::merge('z-10 z-[999]'); // z-[999] 

// arbitrary variants
TailwindMerge::merge('[&>*]:underline [&>*]:line-through'); // [&>*]:line-through

// non tailwind classes
TailwindMerge::merge('non-tailwind-class block inline'); // non-tailwind-class inline 
```

It's possible to pass the classes as a string, an array or a combination of both:

```php
TailwindMerge::merge('h-10 h-20'); // h-20
TailwindMerge::merge(['h-10', 'h-20']); // h-20
TailwindMerge::merge(['h-10', 'h-20'], 'h-30'); // h-30
TailwindMerge::merge(['h-10', 'h-20'], 'h-30', ['h-40']); // h-40
```

## Usage

For in depth documentation and general PHP examples, take a look at the [gehrisandro/tailwind-merge-php](https://github.com/gehrisandro/tailwind-merge-php) repository.

### Use in Laravel Blade Components

Create your Blade components as you normally would, but instead of specifying the `class` attribute directly, use the `mergeClasses` method:

```php
// circle.blade.php
<div {{ $attributes->twMerge('w-10 h-10 rounded-full bg-red-500') }}></div>
```

Now you can use your Blade components and pass additional classes to merge:

```php
// your-view.blade.php
<x-circle class="bg-blue-500" />
```

This will now render the following HTML:

```html
<div class="w-10 h-10 rounded-full bg-blue-500"></div>
```

> **Note:** Usage of `$attributes->merge(['class' => '...'])` is currently not supported due to limitations in Laravel.

### Use Laravel Blade Directive
The package registers a Blade directive which can be used to merge classes in your Blade views:

```php
@twMerge('w-10 h-10 rounded-full bg-red-500 bg-blue-500') // w-10 h-10 rounded-full bg-blue-500

// or multiple arguments
@twMerge('w-10 h-10 rounded-full bg-red-500', 'bg-blue-500') // w-10 h-10 rounded-full bg-blue-500
```

If you want to rename the blade directive, you can do so in the `config/tailwind-merge.php` configuration file:

```php
// config/tailwind-merge.php
return [
    'blade_directive' => 'customTwMerge',
];
```

You could even disable the directive completely by setting it to `null`:

```php
// config/tailwind-merge.php
return [
    'blade_directive' => null,
];
```

### Everywhere else in Laravel
If you don't use Laravel Blade, you can still use `TailwindMerge` by using the `merge` method directly:

```php
use TailwindMerge\Laravel\Facades\TailwindMerge;

TailwindMerge::merge('w-10 h-10 rounded-full bg-red-500 bg-blue-500'); // w-10 h-10 rounded-full bg-blue-500
```

For more examples, take a look at the [gehrisandro/tailwind-merge-php](https://github.com/gehrisandro/tailwind-merge-php) repository.

## Configuration

> **Note:** To be documented

### Custom Tailwind Config

> **Note:** To be documented

## Contributing

Thank you for considering contributing to `Tailwind Merge for PHP`! The contribution guide can be found in the [CONTRIBUTING.md](CONTRIBUTING.md) file.


---

`Tailwind Merge for PHP` is an open-sourced software licensed under the **[MIT license](https://opensource.org/licenses/MIT)**.


