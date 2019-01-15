# Helpers

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/4c084aada0bf4f70bf397338300bfc5d)](https://www.codacy.com/app/laravel-enso/Helpers?utm_source=github.com&utm_medium=referral&utm_content=laravel-enso/Helpers&utm_campaign=badger)
[![StyleCI](https://styleci.io/repos/85466970/shield?branch=master)](https://styleci.io/repos/85466970)
[![License](https://poser.pugx.org/laravel-enso/helpers/license)](https://packagist.org/packages/laravel-enso/helpers)
[![Total Downloads](https://poser.pugx.org/laravel-enso/helpers/downloads)](https://packagist.org/packages/laravel-enso/helpers)
[![Latest Stable Version](https://poser.pugx.org/laravel-enso/helpers/version)](https://packagist.org/packages/laravel-enso/helpers)

Helper classes dependency for [Laravel Enso](https://github.com/laravel-enso/Enso).

### Includes

#### Classes

- An abstract `Enum` class which can be used to build an enumeration out of an array or a config file and comes with a set of helper functions 
- An `Obj` class, with a constructor for building an object from an array, a Laravel model that can even have loaded relationships and more. 
It provides a suite of helper functions, such as: 
     * `all()`, 
     * `__toString()`,
     * `toJson()`,
     * `toArray()`,
     * `get($key)`,
     * `set($key, $value)`,
     * `has($key)`,
     * `keys()`,
     * `values()` 
- A `JsonParser` class that takes a JSON file as its constrctor's argument, and can parse and transform the file to:
    * object
    * array
    * JSON string
     

#### Exceptions

- A generic exception: `EnsoException` is available also with a Facade. This exception is extended by all the other Enso specific exceptions and it is not reported by the Laravel's Exception Handler
- A `FileMissingException`, a child of `EnsoException`
- A `JsonParseException`, a child of `EnsoException`
- A `MorphableConfigException`, a child of `EnsoException`

#### Traits

- `ActiveState` - adds `whereActive()` and `whereDisabled()` scopes, `isActive()` and `isDisabled()` helpers, for models that have a boolean `is_active` property

### Usage

Be sure to check out the full documentation for this package available at [docs.laravel-enso.com](https://docs.laravel-enso.com/packages/helpers.html)

### Contributions

are welcome. Pull requests are great, but issues are good too.

### License

This package is released under the MIT license.
