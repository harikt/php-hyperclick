<?php
require dirname(__DIR__) . '/FQCN.php';

require __DIR__ . '/Another/World.php';
require __DIR__ . '/Hello/World.php';
require __DIR__ . '/Hello/Comma.php';
require __DIR__ . '/Hello/Separated.php';
require __DIR__ . '/World/Comma.php';
require __DIR__ . '/World/NewLineSeparated.php';

// Thank you https://gist.github.com/mathiasverraes/9046427
function it($m,$p){echo ($p?'✔︎':'✘')." It $m\n"; if(!$p){$GLOBALS['f']=1;}}function done(){if(@$GLOBALS['f'])die(1);}

$expected = array(
    'World' => 'Hello\World',
    'AnotherWorld' => 'Another\World',
    'Comma' => 'Hello\Comma',
    'Separated' => 'Hello\Separated',
    'WorldComma' => 'World\Comma',
    'NewLineSeparated' => 'World\NewLineSeparated'
);
$fqcn = new Hkt\FQCN();
$contents = file_get_contents(__DIR__ . '/TestClass.php');
it("expected and returned the same array", $expected == $fqcn->getAllUseStatements($contents));

$contents = file_get_contents(__DIR__ . '/Another/World.php');
$fqns = new Hkt\FQCN();
$fqns->getAllUseStatements($contents);
it("Expected and return the same namespace Another", 'Another' == $fqns->getNamespace());
