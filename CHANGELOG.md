# 1.2.1

* Updated README.md how to use without composer autoloader.

# 1.2.0

* Improved finding composer autoloader file path. Thank you @veger . For details @see https://github.com/harikt/php-hyperclick/pull/7

# 1.1.0

* Improved getting namespace when there were comments

# 1.0.0

* Intial version.

# 0.4.0
* Fixed #2 . Inform the user if vendor/autoload.php doesn't exists in root of project.

# 0.3.1
* Fix the clicked class namespace when they are on the same root namespace.
Eg : `Cake\Core\Plugin` class contains a call to `Classloader`. Which is not referenced in the namespace.

# 0.3.0
* Moving to coffee script

# 0.2.1

* Bug fix adding necessary dependencies on the package.json. So hyperclick is installed automatically.
* Update readme with gif showing the demo

# 0.2.0

* Version that got released.

# 0.1.0

* Initial version
