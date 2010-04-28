<?php

$root  = dirname(__FILE__).DIRECTORY_SEPARATOR;
$comps = $root.'Components'.DIRECTORY_SEPARATOR;
$dic    = $comps.'DependencyInjection'.DIRECTORY_SEPARATOR;
$pack  = $comps.'Package'.DIRECTORY_SEPARATOR;
$rtr   = $comps.'Router'.DIRECTORY_SEPARATOR;
$web   = $root.'Web'.DIRECTORY_SEPARATOR;

require $dic.'Interface/IComponentDefinition.php';
require $dic.'Interface/IComponentAdapter.php';
require $dic.'Interface/IComponentDefinitionToComponentAdapter.php';
require $dic.'Interface/IDependencyInjectionContainerFactory.php';
require $dic.'Interface/IContainerBuilder.php';
require $dic.'Interface/IDependencyInjectionContainer.php';
require $dic.'Interface/IContainerLoader.php';
require $dic.'Adapter/BaseComponentAdapter.php';
require $dic.'Adapter/DecoratingComponentAdapter.php';
require $dic.'Adapter/SharedComponentAdapter.php';
require $dic.'Adapter/InstanceComponentAdapter.php';
require $dic.'Adapter/ConstructorComponentAdapter.php';
require $dic.'ComponentDefinition.php';
require $dic.'ComponentDefinitionToComponentAdapter.php';
require $dic.'DefaultContainerFactory.php';
require $dic.'ContainerBuilder.php';
require $dic.'DependencyInjectionContainer.php';
require $dic.'Loader/ContainerArrayLoader.php';
require $dic.'Loader/ContainerPhpFileLoader.php';

require $pack.'Interface/IPackage.php';
require $pack.'Interface/IPackageCollection.php';
require $pack.'Interface/IClassLoader.php';
require $pack.'Package.php';
require $pack.'MvcPackage.php';
require $pack.'PackageCollection.php';
require $pack.'Loader/AbstractClassLoader.php';
require $pack.'Loader/ClassMapLoader.php';
require $pack.'Loader/PearClassLoader.php';
require $pack.'Loader/FlatFolderClassLoader.php';

require $rtr.'Loader/RoutingRuleArrayLoader.php';

require $web.'Application/Application.php';
require $web.'Application/WebApplication.php';
require $web.'Application/ApplicationFactory.php';
require $web.'Application/PathCollection.php';
