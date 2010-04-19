<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @author sul1nko
 */

// TODO: check include path
//ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.dirname(__FILE__).'/..');

define('TEST_ROOT', dirname(__FILE__));
define('FIXTURES_ROOT', TEST_ROOT.'/Fixtures');

error_reporting( E_ALL | E_STRICT );
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);

require TEST_ROOT.'./../Source/bootstrap.php';
require TEST_ROOT.'./../Source/FrameworkPackage.php';

$package = new FrameworkPackage();
$package->register(new DependencyInjectionContainer());
