<?php

/**
 * Class loaders defining Framework Package.
 *
 * @package    BachelorThesis
 * @subpackage Resources
 */
return array(

	new ClassMapLoader(dirname(__FILE__).'/../Utils', array(
		'ArrayUtil'  => 'ArrayUtil.php',
		'StringUtil' => 'StringUtil.php',
	)),

	new ClassMapLoader(dirname(__FILE__).'/../Components', array(

		// Dependency Injection Container
		'IDependencyInjectionContainerFactory' => 'DependencyInjection/Interface/IDependencyInjectionContainerFactory.php',
		'IContainerBuilder'             => 'DependencyInjection/Interface/IContainerBuilder.php',
		'IDependencyInjectionContainer' => 'DependencyInjection/Interface/IDependencyInjectionContainer.php',
		'IComponentAdapter'             => 'DependencyInjection/Interface/IComponentAdapter.php',
		'IInjecteeArgument'             => 'DependencyInjection/Interface/IInjecteeArgument.php',
		'IComponentDefinition'          => 'DependencyInjection/Interface/IComponentDefinition.php',
		'IComponentDefinitionToComponentAdapter' => 'DependencyInjection/Interface/IComponentDefinitionToComponentAdapter.php',
		'IContainerLoader'              => 'DependencyInjection/Interface/IContainerLoader.php',

		'InjecteeArgumentException'     => 'DependencyInjection/Exception/InjecteeArgumentException.php',
		'CyclicInstantiationException'  => 'DependencyInjection/Exception/CyclicInstantiationException.php',
		'AmbiguousArgumentException'    => 'DependencyInjection/Exception/AmbiguousArgumentException.php',

		'ContainerArrayLoader'          => 'DependencyInjection/Loader/ContainerArrayLoader.php',
		'ContainerPhpFileLoader'        => 'DependencyInjection/Loader/ContainerPhpFileLoader.php',

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

		// Event Emitter
		'IEvent'           => 'Events/Interface/IEvent.php',
		'IEventEmitter'    => 'Events/Interface/IEventEmitter.php',
		'Event'            => 'Events/Event.php',
		'EventEmitter'     => 'Events/EventEmitter.php',
		'LazyEventEmitter' => 'Events/LazyEventEmitter.php',

		// Router
		'IRouter'              => 'Router/Interface/IRouter.php',
		'IRouterFactory'       => 'Router/Interface/IRouterFactory.php',
		'ICompiledRule'        => 'Router/Interface/ICompiledRule.php',
		'IRoute'               => 'Router/Interface/IRoute.php',
		'IRouteMatcher'        => 'Router/Interface/IRouteMatcher.php',
		'IRoutingRule'         => 'Router/Interface/IRoutingRule.php',
		'IRoutingRuleCompiler' => 'Router/Interface/IRoutingRuleCompiler.php',
		'IUrlCreator'          => 'Router/Interface/IUrlCreator.php',
		'IUrlStrategy'         => 'Router/Interface/IUrlStrategy.php',

		'Route'                => 'Router/Route.php',
		'RouterFactory'        => 'Router/RouterFactory.php',

		'CompiledRule'         => 'Router/Rule/CompiledRule.php',
		'RoutingRule'          => 'Router/Rule/RoutingRule.php',

		'RoutingRuleArrayLoader' => 'Router/Loader/RoutingRuleArrayLoader.php',

		'ValueUrlStrategy'        => 'Router/Helper/ValueUrlStrategy.php',
		'RequestBasePathStrategy' => 'Router/Helper/RequestBasePathStrategy.php',

		'RouteMatcher'         => 'Router/Helper/RouteMatcher.php',
		'RoutingRuleCompiler'  => 'Router/Helper/RoutingRuleCompiler.php',
		'UrlCreator'           => 'Router/Helper/UrlCreator.php',
		'RouterManager'        => 'Router/RouterManager.php',

		// Http
		'IRequest'              => 'Http/Interface/IRequest.php',
		'IResponse'             => 'Http/Interface/IResponse.php',
		'IResponsePresenter'    => 'Http/Interface/IResponsePresenter.php',
		'IStatusCode'           => 'Http/Interface/IStatusCode.php',

		'BaseCollection'        => 'Http/Collection/BaseCollection.php',
		'CookieCollection'      => 'Http/Collection/CookieCollection.php',
		'HeaderCollection'      => 'Http/Collection/HeaderCollection.php',

		'HttpException'         => 'Http/Exception/HttpException.php',
		'NotFoundHttpException' => 'Http/Exception/NotFoundHttpException.php',

		'Request'               => 'Http/Request.php',
		'Response'              => 'Http/Response.php',
		'ResponsePresenter'     => 'Http/ResponsePresenter.php',
		'HttpStatusCode'        => 'Http/HttpStatusCode.php',

		// Log
		'ILogMessage'          => 'Log/Interface/ILogMessage.php',
		'ILogMessageFormatter' => 'Log/Interface/ILogMessageFormatter.php',
		'ILogMessageHandler'   => 'Log/Interface/ILogMessageHandler.php',
		'ILogMessageFilter'    => 'Log/Interface/ILogMessageFilter.php',
		'ILogger'              => 'Log/Interface/ILogger.php',

		'DefaultLogMessageFormatter' => 'Log/Formatter/DefaultLogMessageFormatter.php',

		'AbstractLogMessageHandler'  => 'Log/Handler/AbstractLogMessageHandler.php',
		'ArrayLogMessageHandler'     => 'Log/Handler/ArrayLogMessageHandler.php',
		'LogMessageHandlerComposite' => 'Log/Handler/LogMessageHandlerComposite.php',
		'FileLogMessageHandler'      => 'Log/Handler/FileLogMessageHandler.php',

		'Logger'               => 'Log/Logger.php',
		'LogMessage'           => 'Log/LogMessage.php',
		'NullLogger'           => 'Log/NullLogger.php',

		// Cache
		'IClassReflectionCache'  => 'Cache/Reflection/Interface/IClassReflectionCache.php',
		'IMethodReflectionCache' => 'Cache/Reflection/Interface/IMethodReflectionCache.php',
		'IReflectionCache'       => 'Cache/Reflection/Interface/IReflectionCache.php',
		'ClassReflectionCache'   => 'Cache/Reflection/ClassReflectionCache.php',
		'MethodReflectionCache'  => 'Cache/Reflection/MethodReflectionCache.php',
		'ReflectionCache'        => 'Cache/Reflection/ReflectionCache.php',

		// Storage
		'IStorage'          => 'Storage/Interface/IStorage.php',
		'SessionStorage'    => 'Storage/SessionStorage.php',
		'ArrayStorage'      => 'Storage/ArrayStorage.php',


	)),

	new ClassMapLoader(dirname(__FILE__).'/../Web', array(

		// Naming
		'ISimpleNameStrategy' => 'Naming/Interface/ISimpleNameStrategy.php',
		'INameStrategy'       => 'Naming/Interface/INameStrategy.php',

		'AbstractNameStrategy'   => 'Naming/AbstractNameStrategy.php',
		'ActionNameStrategy'     => 'Naming/ActionNameStrategy.php',
		'CommandNameStrategy'    => 'Naming/CommandNameStrategy.php',
		'ControllerNameStrategy' => 'Naming/ControllerNameStrategy.php',

		// Listener
		'RouteLoadListener'        => 'Listener/RouteLoadListener.php',
		'ControllerInvokeListener' => 'Listener/ControllerInvokeListener.php',
		'ControllerLoadListener'   => 'Listener/ControllerLoadListener.php',
		'BasicViewLoadListener'    => 'Listener/BasicViewLoadListener.php',
		'TwigViewLoadListener'     => 'Listener/TwigViewLoadListener.php',

		// Runner
		'IControllerRunner'       => 'Runner/Interface/IControllerRunner.php',
		'IControllerLoader'       => 'Runner/Interface/IControllerLoader.php',
		'IActionInvoker'          => 'Runner/Interface/IActionInvoker.php',

		'ControllerLoader'        => 'Runner/Loader/ControllerLoader.php',
		'CommandActionInvoker'    => 'Runner/Invoker/CommandActionInvoker.php',
		'ControllerActionInvoker' => 'Runner/Invoker/ControllerActionInvoker.php',

		'ControllerRunner' => 'Runner/ControllerRunner.php',

		// Controller
		'IController'     => 'Controller/Interface/IController.php',
		'BaseController'  => 'Controller/BaseController.php',
		'Controller'      => 'Controller/Controller.php',

		// User
		'IUser' => 'User/Interface/IUser.php',
		'User'  => 'User/User.php',

	))

); // end return array
