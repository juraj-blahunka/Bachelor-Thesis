<?php

$dir = dirname(__FILE__).DIRECTORY_SEPARATOR;

require $dir.'Components/DependencyInjection/Interface/IComponentAdapter.php';
require $dir.'Components/DependencyInjection/Interface/IComponentDefinitionToComponentAdapter.php';
require $dir.'Components/DependencyInjection/Interface/IDependencyInjectionContainerFactory.php';
require $dir.'Components/DependencyInjection/Interface/IContainerBuilder.php';
require $dir.'Components/DependencyInjection/Interface/IDependencyInjectionContainer.php';
require $dir.'Components/DependencyInjection/Adapter/InstanceComponentAdapter.php';
require $dir.'Components/DependencyInjection/ComponentDefinitionToComponentAdapter.php';
require $dir.'Components/DependencyInjection/DefaultContainerFactory.php';
require $dir.'Components/DependencyInjection/ContainerBuilder.php';
require $dir.'Components/DependencyInjection/DependencyInjectionContainer.php';
require $dir.'Components/DependencyInjection/Loader/ContainerArrayLoader.php';

require $dir.'Components/Package/Interface/IPackage.php';
require $dir.'Components/Package/Interface/IPackageCollection.php';
require $dir.'Components/Package/Interface/IClassLoader.php';
require $dir.'Components/Package/Package.php';
require $dir.'Components/Package/PackageCollection.php';
require $dir.'Components/Package/Loader/AbstractClassLoader.php';
require $dir.'Components/Package/Loader/ClassMapLoader.php';
require $dir.'Components/Package/Loader/PearClassLoader.php';
require $dir.'Components/Package/Loader/FlatFolderClassLoader.php';

require $dir.'Components/Router/Loader/RoutingRuleArrayLoader.php';

require $dir.'Web/Application/Application.php';
require $dir.'Web/Application/WebApplication.php';
require $dir.'Web/Application/ApplicationFactory.php';
require $dir.'Web/Application/PathCollection.php';
