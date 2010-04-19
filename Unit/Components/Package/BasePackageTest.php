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

	public function registerWiring(IContainerBuilder $container)
	{

	}
}

class BasePackageFallbackStub extends BasePackage
{
	public function registerClassLoaders() {}
	public function getPackagename() { return 'BasePackageFallbackStub'; }
	public function registerWiring(IContainerBuilder $container) {}
}

class BasePackageTest extends PHPUnit_Framework_TestCase
{
	/*
	 * @var IDependencyInjectionContainer
	 */
	protected $container;

	protected function setUp()
	{
		$this->container = $this->getMock('IDependencyInjectionContainer');
	}

	protected function tearDown()
	{
	}

	public function testRegister()
	{
		$package = new BasePackageStub();
		$package->register($this->container);

		$this->assertTrue(ClassLoaderStub::$registered);
	}

	public function testRegisterWithNothing_FallbackMode()
	{
		$package = new BasePackageFallbackStub();
		$package->register($this->container);
		// nothing happened, no error (Fallback on empty returns)
	}
}
