<?php

require dirname(__FILE__).'/Components/Package/Interface/IPackage.php';
require dirname(__FILE__).'/Components/Package/Interface/IClassLoader.php';
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
'IDependencyInjectionContainerFactory' => 'DependencyInjection/Interface/IDependencyInjectionContainerFactory.php',
'IContainerBuilder'             => 'DependencyInjection/Interface/IContainerBuilder.php',
'IDependencyInjectionContainer' => 'DependencyInjection/Interface/IDependencyInjectionContainer.php',
'IComponentAdapter'             => 'DependencyInjection/Interface/IComponentAdapter.php',
'IInjecteeArgument'             => 'DependencyInjection/Interface/IInjecteeArgument.php',
'IComponentDefinition'          => 'DependencyInjection/Interface/IComponentDefinition.php',
'IComponentDefinitionToComponentAdapter' => 'DependencyInjection/Interface/IComponentDefinitionToComponentAdapter.php',

'InjecteeArgumentException'     => 'DependencyInjection/Exception/InjecteeArgumentException.php',
'CyclicInstantiationException'  => 'DependencyInjection/Exception/CyclicInstantiationException.php',
'AmbiguousArgumentException'    => 'DependencyInjection/Exception/AmbiguousArgumentException.php',

'ContainerBuilder'              => 'DependencyInjection/ContainerBuilder.php',
'DependencyInjectionContainer'  => 'DependencyInjection/DependencyInjectionContainer.php',
'DefaultContainerFactory'       => 'DependencyInjection/DefaultContainerFactory.php',
'ComponentDefinition'           => 'DependencyInjection/ComponentDefinition.php',
'ComponentDefinitionToComponentAdapter' => 'DependencyInjection/ComponentDefinitionToComponentAdapter.php',

'BaseComponentAdapter'          => 'DependencyInjection/Adapter/BaseComponentAdapter.php',
'DecoratingComponentAdapter'    => 'DependencyInjection/Adapter/DecoratingComponentAdapter.php',
'ConstructorComponentAdapter'   => 'DependencyInjection/Adapter/ConstructorComponentAdapter.php',
'TransientComponentAdapter'     => 'DependencyInjection/Adapter/TransientComponentAdapter.php',
'SharedComponentAdapter'        => 'DependencyInjection/Adapter/SharedComponentAdapter.php',
'InstanceComponentAdapter'      => 'DependencyInjection/Adapter/InstanceComponentAdapter.php',
'MethodsAfterConstructionAdapter' => 'DependencyInjection/Adapter/MethodsAfterConstructionAdapter.php',

'ConstantArgument'              => 'DependencyInjection/Argument/ConstantArgument.php',
'ValueArgument'                 => 'DependencyInjection/Argument/ValueArgument.php',
'ComponentArgument'             => 'DependencyInjection/Argument/ComponentArgument.php',
'ArrayArgument'                 => 'DependencyInjection/Argument/ArrayArgument.php',

// Event Dispatcher
'IEvent'        => 'Events/Interface/IEvent.php',
'IEventEmitter' => 'Events/Interface/IEventEmitter.php',
'Event'         => 'Events/Event.php',
'EventEmitter'  => 'Events/EventEmitter.php',

// Router
'IRouter'              => 'Router/Interface/IRouter.php',
'IRouterFactory'       => 'Router/Interface/IRouterFactory.php',
'ICompiledRule'        => 'Router/Interface/ICompiledRule.php',
'IRoute'               => 'Router/Interface/IRoute.php',
'IRouteMatcher'        => 'Router/Interface/IRouteMatcher.php',
'IRoutingRule'         => 'Router/Interface/IRoutingRule.php',
'IRoutingRuleCompiler' => 'Router/Interface/IRoutingRuleCompiler.php',
'IUrlCreator'          => 'Router/Interface/IUrlCreator.php',

'Route'                => 'Router/Route.php',
'RouterFactory'        => 'Router/RouterFactory.php',

'CompiledRule'         => 'Router/Rule/CompiledRule.php',
'RoutingRule'          => 'Router/Rule/RoutingRule.php',

'RouteMatcher'         => 'Router/Helper/RouteMatcher.php',
'RoutingRuleCompiler'  => 'Router/Helper/RoutingRuleCompiler.php',
'UrlCreator'           => 'Router/Helper/UrlCreator.php',
'RouterManager'        => 'Router/RouterManager.php',

// Http
'IRequest'              => 'Http/Interface/IRequest.php',
'IResponse'             => 'Http/Interface/IResponse.php',

'BaseCollection'        => 'Http/Collection/BaseCollection.php',
'CookieCollection'      => 'Http/Collection/CookieCollection.php',
'HeaderCollection'      => 'Http/Collection/HeaderCollection.php',

'HttpException'         => 'Http/Exception/HttpException.php',
'NotFoundHttpException' => 'Http/Exception/NotFoundHttpException.php',

'Request'          => 'Http/Request.php',
'Response'         => 'Http/Response.php',

// Cache
'IClassReflectionCache'  => 'Cache/Reflection/Interface/IClassReflectionCache.php',
'IMethodReflectionCache' => 'Cache/Reflection/Interface/IMethodReflectionCache.php',
'IReflectionCache'       => 'Cache/Reflection/Interface/IReflectionCache.php',
'ClassReflectionCache'   => 'Cache/Reflection/ClassReflectionCache.php',
'MethodReflectionCache'  => 'Cache/Reflection/MethodReflectionCache.php',
'ReflectionCache'        => 'Cache/Reflection/ReflectionCache.php',


				) // end array
			),
			new ClassMapLoader(
				dirname(__FILE__).'/Web',
				array(
// Naming
'ISimpleNameStrategy' => 'Naming/Interface/ISimpleNameStrategy.php',
'INameStrategy'       => 'Naming/Interface/INameStrategy.php',

'AbstractNameStrategy'   => 'Naming/AbstractNameStrategy.php',
'ActionNameStrategy'     => 'Naming/ActionNameStrategy.php',
'CommandNameStrategy'    => 'Naming/CommandNameStrategy.php',
'ControllerNameStrategy' => 'Naming/ControllerNameStrategy.php',

// Runner
'IControllerLoader'       => 'Runner/Interface/IControllerLoader.php',
'IActionInvoker'          => 'Runner/Interface/IActionInvoker.php',

'ControllerLoader'        => 'Runner/Loader/ControllerLoader.php',
'CommandActionInvoker'    => 'Runner/Invoker/CommandActionInvoker.php',
'ControllerActionInvoker' => 'Runner/Invoker/ControllerActionInvoker.php',

'ControllerInvokerListener' => 'Runner/Listener/ControllerInvokerListener.php',
'ControllerLoaderListener'  => 'Runner/Listener/ControllerLoaderListener.php',

'ControllerRunner' => 'Runner/ControllerRunner.php',

// Controller
'IController'     => 'Controller/Interface/IController.php',
'BaseController'  => 'Controller/BaseController.php',
'Controller'      => 'Controller/Controller.php',

				)
			) // end class loader
		); // end return array
	}
}
