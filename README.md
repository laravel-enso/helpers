<!--h-->
# Helpers

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/4c084aada0bf4f70bf397338300bfc5d)](https://www.codacy.com/app/laravel-enso/Helpers?utm_source=github.com&utm_medium=referral&utm_content=laravel-enso/Helpers&utm_campaign=badger)
[![StyleCI](https://styleci.io/repos/85466970/shield?branch=master)](https://styleci.io/repos/85466970)
[![License](https://poser.pugx.org/laravel-enso/helpers/license)](https://https://packagist.org/packages/laravel-enso/helpers)
[![Total Downloads](https://poser.pugx.org/laravel-enso/helpers/downloads)](https://packagist.org/packages/laravel-enso/helpers)
[![Latest Stable Version](https://poser.pugx.org/laravel-enso/helpers/version)](https://packagist.org/packages/laravel-enso/helpers)
<!--/h-->

Helper classes dependency for [Laravel Enso](https://github.com/laravel-enso/Enso).

### Includes

#### Traits
- `IsActive` - adds active and disabled scopes and helper attributes
- `FormattedTimestamps` - used to format timestamps created with the timestamps() method in the Laravel migrations

#### Classes
- An `AbstractObject` PSR4 compliant class, that can be converted to string, JSON and array, meant to be extended
- An abstract `Enum` class that comes with a constructor for building an enumeration out of a config file / array 
- A concrete `Object` class, extends AbstractObject and has a constructor that can take a KV parameter 


### Notes

The [Laravel Enso Core](https://github.com/laravel-enso/Core) package comes with this package included.

<!--h-->
### Contributions

are welcome. Pull requests are great, but issues are good too.

### License

This package is released under the MIT license.
<!--/h-->