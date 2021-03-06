<?php
require_once 'PHPUnit/Framework.php';

/**
 * Test class for PearClassLoader.
 * Generated by PHPUnit on 2010-03-04 at 00:35:25.
 */
class PearClassLoaderTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var PearClassLoader
	 */
	protected $object;

	public function setUp()
	{
		$this->object = new PearClassLoader(
			array('Inside'),
			array(TEST_ROOT.'/Fixtures/Components/Package/Inside')
		);
		$this->object->registerClassLoader();
	}

	public function tearDown()
	{
		$this->object->unregisterClassLoader();
	}

	public function testInsideClasses()
	{
		$look = new Inside_Look();
		$glass = new Inside_Window_Glass();

		$this->assertThat(
			$look,
			$this->isInstanceOf('Inside_Look')
		);

		$this->assertThat(
			$glass,
			$this->isInstanceOf('Inside_Window_Glass')
		);
	}

	public function testNonRegisteredClass()
	{
		$this->assertFalse(class_exists('Not_Existing_Class_Name', true));
	}

}
