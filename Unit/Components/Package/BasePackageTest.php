<?php
require_once 'PHPUnit/Framework.php';

class ClassLoaderStub implements IClassLoader
{
	static public $registered = false;

	public function registerClassLoader()
	{
		self::$registered = true;
	}

	public function unregisterClassLoader()
	{
		self::$registered = false;
	}
}

class BasePackageStub extends BasePackage
{
	public function registerClassLoaders()
	{
		return array(
			new ClassLoaderStub()
		);
	}

	public function getPackageName()
	{
		return 'BasePackageStub';
	}

	public function registerPackages()
	{
		return array(
			new InternalPackageStub()
		);
	}

	public function registerWiring(IContainerBuilder $container)
	{

	}
}

class InternalPackageStub implements IPackage
{
	static public $registered = false;

	public function getPackageName()
	{
		return 'InternalPackageStub';
	}

	public function register(IContainerBuilder $builder)
	{
		self::$registered = true;
	}
}

class BasePackageTest extends PHPUnit_Framework_TestCase
{
	protected function setUp()
	{
	}

	protected function tearDown()
	{
	}

	public function testRegister()
	{
		$container = $this->getMock('IDependencyInjectionContainer');
		$package = new BasePackageStub();
		$package->register($container);

		$this->assertTrue(ClassLoaderStub::$registered);
		$this->assertTrue(InternalPackageStub::$registered);
	}
}
