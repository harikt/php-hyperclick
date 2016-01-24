<?php
$class = $argv[1];
$file = $argv[2];
$rootpath = $argv[3];
$autoloader = $rootpath . '/vendor/autoload.php';
if (file_exists($autoloader)) {
    $loader = require $autoloader;

    require __DIR__ . '/FQCN.php';

    $contents = file_get_contents($file);
    $fqns = new Hkt\FQCN();
    $useClasses = $fqns->getAllUseStatements($contents);
    if (array_key_exists($class, $useClasses)) {
        echo $loader->findFile($useClasses[$class]);
    } else {
        // Get current namespace
        $namespace = $fqns->getNamespace();
        if ($namespace) {
            $class = $namespace . '\\' . $class;
        }
        echo $loader->findFile($class);
    }

}
