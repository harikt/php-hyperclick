<?php

$class = $argv[1];
$file = $argv[2];
$rootpath = $argv[3];

require __DIR__.'/FQCN.php';

$foundAutoLoader = false;

// First try default location
$autoloader = $rootpath.'/vendor/autoload.php';
if (is_readable($autoloader)) {
    $foundAutoLoader = true;
    if (getFilePath($rootpath.'/vendor/autoload.php', $class, $file)) {
        exit(0);
    }
}

// Try to find autoload.php elsewhere in $rootpath
$dirIterator = new RecursiveDirectoryIterator($rootpath);
$reqIterator = new RecursiveIteratorIterator($dirIterator);
$regexIterator = new RegexIterator($reqIterator, '#/vendor/autoload.php$#i');
foreach ($regexIterator as $autoloader) {
    $foundAutoLoader = true;
    if (getFilePath($autoloader, $class, $file)) {
        exit(0);
    }
}

if ($foundAutoLoader) {
    echo "Class $class not found.";
} else {
    echo "Class $class not found, please make sure the composer vendor/autoload.php file exists in your project and is readable.";
}

function getFilePath($autoloader, $class, $file)
{
    if (!is_readable($autoloader)) {
        return false;
    }

    $loader = require $autoloader;

    $contents = file_get_contents($file);
    $fqns = new Hkt\FQCN();
    $useClasses = $fqns->getAllUseStatements($contents);
    if (array_key_exists($class, $useClasses)) {
        echo $loader->findFile($useClasses[$class]);

        return true;
    }

  // Try using current namespace
  $namespace = $fqns->getNamespace();
    if ($namespace) {
        $foundFile = $loader->findFile($namespace.'\\'.$class);
        if ($foundFile) {
            echo $foundFile;

            return true;
        }
    }

  // Try using global namespace
  $foundFile = $loader->findFile($class);
    if ($foundFile) {
        echo $foundFile;

        return true;
    }

    return false;
}
