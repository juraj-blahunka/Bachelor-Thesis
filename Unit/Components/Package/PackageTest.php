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

class PackageStub extends Package
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

	public function registerWiring(IContainerBuilder $container) {}

	public function registerPaths()
	{
		return new PathCollection(array(
			'fixtures' => array(
				FIXTURES_ROOT,
			)
		));
	}
}

class PackageFallbackStub extends Package
{
	public function registerClassLoaders() {}
	public function getPackagename() { return 'BasePackageFallbackStub'; }
	public function registerWiring(IContainerBuilder $container) {}
	public function registerPaths() {}
}

class PackageTest extends PHPUnit_Framework_TestCase
{
	/*
	 * @var IDependencyInjectionContainer
	 */
	protected $container;

	/*
	 * @var PathCollection
	 */
	protected $paths;

	protected function setUp()
	{
		$this->container = $this->getMock('IDependencyInjectionContainer');
		$this->paths     = new PathCollection();
	}

	protected function tearDown()
	{
	}

	public function testRegister()
	{
		$package = new PackageStub();
		$package->register($this->container, $this->paths);

		$this->assertTrue(ClassLoaderStub::$registered);

		$this->assertThat(
			$this->paths->getAll(),
			$this->equalTo(array(FIXTURES_ROOT))
		);
	}

	public function testRegisterWithNothing_FallbackMode()
	{
		$package = new PackageFallbackStub();
		$package->register($this->container, $this->paths);
		// nothing happened, no error (Fallback on empty returns)
	}
}
