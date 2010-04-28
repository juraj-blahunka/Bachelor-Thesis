<?php

define('TEST_ROOT', dirname(__FILE__));
define('FIXTURES_ROOT', TEST_ROOT.'/Fixtures');

error_reporting( E_ALL | E_STRICT );
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);

require TEST_ROOT.'./../Source/bootstrap.php';
require TEST_ROOT.'./../Source/FrameworkPackage.php';

$container = new DependencyInjectionContainer();
$paths     = new PathCollection();

$package = new FrameworkPackage();
$package->register($container, $paths);
