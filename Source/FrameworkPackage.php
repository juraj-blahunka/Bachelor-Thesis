<?php

require dirname(__FILE__).'/Components/Package/Interfaces/IPackage.php';
require dirname(__FILE__).'/Components/Package/Interfaces/IClassLoader.php';
require dirname(__FILE__).'/Components/Package/BasePackage.php';
require dirname(__FILE__).'/Components/Package/Loader/AbstractClassLoader.php';
require dirname(__FILE__).'/Components/Package/Loader/ClassMapLoader.php';
require dirname(__FILE__).'/Components/Package/Loader/PearClassLoader.php';


class FrameworkPackage extends BasePackage
{
	public function getPackageName()
	{
		return 'Framework';
	}

	public function registerPackages()
	{
		return array();
	}

	public function registerWiring(IDependencyInjectionContainer $container)
	{

	}

	public function registerClassLoaders()
	{
		return array(
			new ClassMapLoader(dirname(__FILE__).'/Utils', array(
				'ArrayUtil'  => 'ArrayUtil.php',
				'StringUtil' => 'StringUtil.php',
			)),
			new ClassMapLoader(
				dirname(__FILE__).'/Components',
				array(

// Dependency Injection Container
'IDependencyInjectionContainerFactory' => 'DependencyInjection/Interfaces/IDependencyInjectionContainerFactory.php',
'IContainerBuilder'             => 'DependencyInjection/Interfaces/IContainerBuilder.php',
'IDependencyInjectionContainer' => 'DependencyInjection/Interfaces/IDependencyInjectionContainer.php',
'IComponentAdapter'             => 'DependencyInjection/Interfaces/IComponentAdapter.php',
'IInjecteeArgument'             => 'DependencyInjection/Interfaces/IInjecteeArgument.php',
'IComponentDefinition'          => 'DependencyInjection/Interfaces/IComponentDefinition.php',
'IComponentDefinitionToComponentAdapter' => 'DependencyInjection/Interfaces/IComponentDefinitionToComponentAdapter.php',

'InjecteeArgumentException'     => 'DependencyInjection/Exceptions/InjecteeArgumentException.php',
'CyclicInstantiationException'  => 'DependencyInjection/Exceptions/CyclicInstantiationException.php',
'AmbiguousArgumentException'    => 'DependencyInjection/Exceptions/AmbiguousArgumentException.php',

'ContainerBuilder'              => 'DependencyInjection/ContainerBuilder.php',
'DependencyInjectionContainer'  => 'DependencyInjection/DependencyInjectionContainer.php',
'DefaultContainerFactory'       => 'DependencyInjection/DefaultContainerFactory.php',
'ComponentDefinition'           => 'DependencyInjection/ComponentDefinition.php',
'ComponentDefinitionToComponentAdapter' => 'DependencyInjection/ComponentDefinitionToComponentAdapter.php',

'BaseComponentAdapter'          => 'DependencyInjection/Adapters/BaseComponentAdapter.php',
'DecoratingComponentAdapter'    => 'DependencyInjection/Adapters/DecoratingComponentAdapter.php',
'ConstructorComponentAdapter'   => 'DependencyInjection/Adapters/ConstructorComponentAdapter.php',
'TransientComponentAdapter'     => 'DependencyInjection/Adapters/TransientComponentAdapter.php',
'SharedComponentAdapter'        => 'DependencyInjection/Adapters/SharedComponentAdapter.php',
'InstanceComponentAdapter'      => 'DependencyInjection/Adapters/InstanceComponentAdapter.php',
'MethodsAfterConstructionAdapter' => 'DependencyInjection/Adapters/MethodsAfterConstructionAdapter.php',

'ConstantArgument'              => 'DependencyInjection/Arguments/ConstantArgument.php',
'ValueArgument'                 => 'DependencyInjection/Arguments/ValueArgument.php',
'ComponentArgument'             => 'DependencyInjection/Arguments/ComponentArgument.php',
'ArrayArgument'                 => 'DependencyInjection/Arguments/ArrayArgument.php',

// Event Dispatcher
'IEvent'        => 'Events/Interfaces/IEvent.php',
'IEventEmitter' => 'Events/Interfaces/IEventEmitter.php',
'Event'         => 'Events/Event.php',
'EventEmitter'  => 'Events/EventEmitter.php',

// Router
'IRouter'              => 'Router/Interfaces/IRouter.php',
'IRouterFactory'       => 'Router/Interfaces/IRouterFactory.php',
'ICompiledRule'        => 'Router/Interfaces/ICompiledRule.php',
'IRoute'               => 'Router/Interfaces/IRoute.php',
'IRouteMatcher'        => 'Router/Interfaces/IRouteMatcher.php',
'IRoutingRule'         => 'Router/Interfaces/IRoutingRule.php',
'IRoutingRuleCompiler' => 'Router/Interfaces/IRoutingRuleCompiler.php',
'IUrlCreator'          => 'Router/Interfaces/IUrlCreator.php',

'Route'                => 'Router/Route.php',
'RouterFactory'        => 'Router/RouterFactory.php',

'CompiledRule'         => 'Router/Rules/CompiledRule.php',
'RoutingRule'          => 'Router/Rules/RoutingRule.php',

'RouteMatcher'         => 'Router/Helpers/RouteMatcher.php',
'RoutingRuleCompiler'  => 'Router/Helpers/RoutingRuleCompiler.php',
'UrlCreator'           => 'Router/Helpers/UrlCreator.php',
'RouterManager'        => 'Router/RouterManager.php',

// Http
'IRequest'              => 'Http/Interfaces/IRequest.php',
'IResponse'             => 'Http/Interfaces/IResponse.php',

'BaseCollection'        => 'Http/Collections/BaseCollection.php',
'CookieCollection'      => 'Http/Collections/CookieCollection.php',
'HeaderCollection'      => 'Http/Collections/HeaderCollection.php',

'HttpException'         => 'Http/Exceptions/HttpException.php',
'NotFoundHttpException' => 'Http/Exceptions/NotFoundHttpException.php',

'Request'          => 'Http/Request.php',
'Response'         => 'Http/Response.php',

// Cache
'IClassReflectionCache'  => 'Cache/Reflection/Interfaces/IClassReflectionCache.php',
'IMethodReflectionCache' => 'Cache/Reflection/Interfaces/IMethodReflectionCache.php',
'IReflectionCache'       => 'Cache/Reflection/Interfaces/IReflectionCache.php',
'ClassReflectionCache'   => 'Cache/Reflection/ClassReflectionCache.php',
'MethodReflectionCache'  => 'Cache/Reflection/MethodReflectionCache.php',
'ReflectionCache'        => 'Cache/Reflection/ReflectionCache.php',


				) // end array
			),
			new ClassMapLoader(
				dirname(__FILE__).'/Web',
				array(
// Naming
'ISimpleNameStrategy' => 'Naming/Interfaces/ISimpleNameStrategy.php',
'INameStrategy'       => 'Naming/Interfaces/INameStrategy.php',

'AbstractNameStrategy'   => 'Naming/AbstractNameStrategy.php',
'ActionNameStrategy'     => 'Naming/ActionNameStrategy.php',
'CommandNameStrategy'    => 'Naming/CommandNameStrategy.php',
'ControllerNameStrategy' => 'Naming/ControllerNameStrategy.php'

				)
			) // end class loader
		); // end return array
	}
}
