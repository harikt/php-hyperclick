# php-hyperclick package

Open the class files when you trigger `ctrl` + `mouse left click`.

![How it works!](https://cloud.githubusercontent.com/assets/120454/12533819/51b6cd44-c264-11e5-855c-ecd6437ca43d.gif)

## Inspired by

* [js-hyperclick](https://github.com/AsaAyers/js-hyperclick/)
* [atom-autocomplete-php](https://github.com/Peekmo/atom-autocomplete-php)

This works with the help of some dependencies

* [Hyperclick](https://atom.io/packages/hyperclick)

Optional dependency:

* [Composer](https://getcomposer.org) a dependency manager for PHP

## Making composer an optional dependency

Even though the class finding functionality is relied on composer, you can easily
make the necessary change to make composer as optional dependency.

The base working of the package is it tries to find the file `/vendor/autoload.php`
which returns an autoloader object. It assumes the object has a method
[findFile($class_name)](https://github.com/composer/composer/blob/c540dace8cceca12b1fa969fd9f58dcb7395d402/src/Composer/Autoload/ClassLoader.php#L307-L314).

So if you are not using composer, keep a `vendor/autoload.php` file on the root
of your project.

```php
// vendor/autoload.php

$autoloader = new YourAutoloader();

// Make sure there is findFile method which can return the path to the file when class name is passed

return $autoloader;
```

## Wishes

* Learn coffee script and port
* Improve all the ugly code

## Known Limitations

* Must have `use` statement in classes. Else clicking on things like `new \Lib\Hello\World()` will not be opened.
* May not work on windows
* Other unknown bugs

## Thanks

Special Thanks to

* Marco Pivetta
* Shameer C
* Wouter J
* Mark Hahn
* Lee Dohm
* Dylan R. E. Moonfire
* Joel Clermont

and to everyone who have helped knowingly/unknowingly to make this happen.
