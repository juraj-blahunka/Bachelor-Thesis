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

require TEST_ROOT.'./../Source/FrameworkPackage.php';
require TEST_ROOT.'./../Source/Components/DependencyInjection/Interface/IComponentAdapter.php';
require TEST_ROOT.'./../Source/Components/DependencyInjection/Interface/IComponentDefinitionToComponentAdapter.php';
require TEST_ROOT.'./../Source/Components/DependencyInjection/Interface/IDependencyInjectionContainerFactory.php';
require TEST_ROOT.'./../Source/Components/DependencyInjection/Interface/IContainerBuilder.php';
require TEST_ROOT.'./../Source/Components/DependencyInjection/Interface/IDependencyInjectionContainer.php';
require TEST_ROOT.'./../Source/Components/DependencyInjection/Adapter/InstanceComponentAdapter.php';
require TEST_ROOT.'./../Source/Components/DependencyInjection/ComponentDefinitionToComponentAdapter.php';
require TEST_ROOT.'./../Source/Components/DependencyInjection/DefaultContainerFactory.php';
require TEST_ROOT.'./../Source/Components/DependencyInjection/ContainerBuilder.php';
require TEST_ROOT.'./../Source/Components/DependencyInjection/DependencyInjectionContainer.php';

$package = new FrameworkPackage();
$package->register(new DependencyInjectionContainer());
