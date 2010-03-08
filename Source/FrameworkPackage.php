<?php

require dirname(__FILE__).'/Components/Package/IPackage.php';
require dirname(__FILE__).'/Components/Package/IClassLoader.php';
require dirname(__FILE__).'/Components/Package/BasePackage.php';
require dirname(__FILE__).'/Components/Package/ClassToFileRelationMapLoader.php';
require dirname(__FILE__).'/Components/Package/PearClassLoader.php';


class FrameworkPackage extends BasePackage
{
	public function getPackageName()
	{
		return 'Framework';
	}
	
	public function registerClassLoaders()
	{
		return array(
			new ClassToFileRelationMapLoader(
				dirname(__FILE__).'/Components',
				array(

// Dependency Injection Container
'IDependencyInjectionContainerFactory' => 'DependencyInjection/Interfaces/IDependencyInjectionContainerFactory.php',
'IDependencyInjectionContainer' => 'DependencyInjection/Interfaces/IDependencyInjectionContainer.php',
'IComponentAdapter'             => 'DependencyInjection/Interfaces/IComponentAdapter.php',
'IInjecteeArgument'             => 'DependencyInjection/Interfaces/IInjecteeArgument.php',
'IComponentDefinition'          => 'DependencyInjection/Interfaces/IComponentDefinition.php',
'IComponentDefinitionToComponentAdapter' => 'DependencyInjection/Interfaces/IComponentDefinitionToComponentAdapter.php',

'InjecteeArgumentException'     => 'DependencyInjection/Exceptions/InjecteeArgumentException.php',
'CyclicInstantiationException'  => 'DependencyInjection/Exceptions/CyclicInstantiationException.php',

'DependencyInjectionContainer'  => 'DependencyInjection/DependencyInjectionContainer.php',
'DefaultContainerFactory'       => 'DependencyInjection/DefaultContainerFactory.php',
'ComponentDefinition'           => 'DependencyInjection/ComponentDefinition.php',
'ComponentDefinitionToComponentAdapter' => 'DependencyInjection/ComponentDefinitionToComponentAdapter.php',

'AbstractComponentAdapter'      => 'DependencyInjection/Adapters/AbstractComponentAdapter.php',
'DecoratingComponentAdapter'    => 'DependencyInjection/Adapters/DecoratingComponentAdapter.php',
'ConstructorComponentAdapter'   => 'DependencyInjection/Adapters/ConstructorComponentAdapter.php',
'TransientComponentAdapter'     => 'DependencyInjection/Adapters/TransientComponentAdapter.php',
'SharedComponentAdapter'        => 'DependencyInjection/Adapters/SharedComponentAdapter.php',
'InstanceComponentAdapter'      => 'DependencyInjection/Adapters/InstanceComponentAdapter.php',
'MethodsAfterConstructionAdapter' => 'DependencyInjection/Adapters/MethodsAfterConstructionAdapter.php',

'ConstantArgument'              => 'DependencyInjection/Arguments/ConstantArgument.php',
'ValueArgument'                 => 'DependencyInjection/Arguments/ValueArgument.php',
'ReferenceArgument'             => 'DependencyInjection/Arguments/ReferenceArgument.php',
'ClassArgument'                 => 'DependencyInjection/Arguments/ClassArgument.php',
'ArrayArgument'                 => 'DependencyInjection/Arguments/ArrayArgument.php',

// Event Dispatcher
'IEvent'      => 'Dispatcher/IEvent.php',
'IDispatcher' => 'Dispatcher/IDispatcher.php',
'Event'       => 'Dispatcher/Event.php',
'Dispatcher'  => 'Dispatcher/Dispatcher.php',

// Router
'ICompiledRule'        => 'Router/Interfaces/ICompiledRule.php',
'IRoute'               => 'Router/Interfaces/IRoute.php',
'IRouteMatcher'        => 'Router/Interfaces/IRouteMatcher.php',
'IRoutingRule'         => 'Router/Interfaces/IRoutingRule.php',
'IRoutingRuleCompiler' => 'Router/Interfaces/IRoutingRuleCompiler.php',
'CompiledRule'         => 'Router/CompiledRule.php',
'Route'                => 'Router/Route.php',
'RouteMatcher'         => 'Router/RouteMatcher.php',
'RoutingRule'          => 'Router/RoutingRule.php',
'RoutingRuleCompiler'  => 'Router/RoutingRuleCompiler.php',

				) // end array
			) // end new ClassLoader
		); // end return array
	}
}