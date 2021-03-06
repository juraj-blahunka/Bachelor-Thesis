<?php
require_once 'PHPUnit/Framework.php';

/**
 * Test class for ControllerLoader.
 * Generated by PHPUnit on 2010-04-26 at 20:27:18.
 */
class ControllerLoaderTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var ControllerLoader
	 */
	protected $object;

	protected function setUp()
	{
		$paths = new PathCollection(array(
			'Sample.controllers' => array(
				FIXTURES_ROOT.'/Web/Runner/Loader'
			)
		));
		$container = new DependencyInjectionContainer();
		$controllerNaming = new ControllerNameStrategy();
		$this->object = new ControllerLoader($paths, $container, $controllerNaming);
	}

	protected function tearDown()
	{
	}

	public function testLoadController()
	{
		$route = new Route();
		$route->setPackage('Sample')
			->setController('sample');

		$controller = $this->object->loadController($route);

		$this->assertThat(
			$controller,
			$this->isInstanceOf('SampleController')
		);
	}

	public function testLoadController_Fails()
	{
		$route = new Route();
		$route->setPackage('Sample')
			->setController('not-defined');

		$this->assertThat(
			$this->object->loadController($route),
			$this->equalTo(false)
		);
	}
}
