<?php
require_once 'PHPUnit/Framework.php';

/**
 * Test class for ClassToFileRelationMapLoader.
 * Generated by PHPUnit on 2010-02-24 at 18:07:21.
 */
class ClassToFileRelationMapLoaderTest extends PHPUnit_Framework_TestCase
{
	protected function setUp()
	{
	}

	protected function tearDown()
	{
	}

	private function getTestDirectory()
	{
		return FIXTURES_ROOT.'/Components/Package';
	}

	public function testOneMapperLoader()
	{
		$loader = new ClassToFileRelationMapLoader(
			$this->getTestDirectory(),
			array(
				'OneClassModel'   => 'OneClassModel.php',
			)
		);
		$loader->registerClassLoader();

		$one   = new OneClassModel();

		$this->assertThat($one, $this->isInstanceOf('OneClassModel'));

		$loader->unregisterClassLoader();
	}

	public function testIndependentMapperLoaders()
	{
		$loaders = array();
		$loaders [] = new ClassToFileRelationMapLoader(
			$this->getTestDirectory(), 
			array(
				'TwoClassModel'   => 'TwoClassModel.php',
			)
		);
		$loaders [] = new ClassToFileRelationMapLoader(
			$this->getTestDirectory(), 
			array(
				'ThreeClassModel' => 'ThreeClassModel.php',
			)
		);
		foreach ($loaders as $loader)
			$loader->registerClassLoader();

		$two   = new TwoClassModel();
		$three = new ThreeClassModel();

		$this->assertThat($two,   $this->isInstanceOf('TwoClassModel'));
		$this->assertThat($three, $this->isInstanceOf('ThreeClassModel'));

		foreach ($loaders as $loader)
			$loader->unregisterClassLoader();
	}
	
	public function testNotIncludedInMapperLoaders()
	{
		$this->assertFalse(class_exists('FourClassModel', true));
	}
}