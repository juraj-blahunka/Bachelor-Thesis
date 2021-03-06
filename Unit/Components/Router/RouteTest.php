<?php
require_once 'PHPUnit/Framework.php';

/**
 * Test class for Route.
 * Generated by PHPUnit on 2010-02-23 at 16:44:36.
 */
class RouteTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var Route
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new Route();
		$this->object->setController('c')
			->setAction('a')
			->setParameters(array())
			->setPackage('Frontend');
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	public function testGetAction()
	{
		$this->assertEquals(
			'a',
			$this->object->getAction()
		);
	}

	public function testGetController()
	{
		$this->assertEquals(
			'c',
			$this->object->getController()
		);
	}

	public function testGetPackage()
	{
		$this->assertThat(
			$this->object->getPackage(),
			$this->equalTo('Frontend')
		);
	}

	public function testGetParameters()
	{
		$this->assertEquals(
			array(),
			$this->object->getParameters()
		);
	}

	public function testSetAction()
	{
		$this->object->setAction('someAction');
		$this->assertEquals(
			'someAction',
			$this->object->getAction()
		);
	}

	public function testSetController()
	{
		$this->object->setController('someController');
		$this->assertEquals(
			'someController',
			$this->object->getController()
		);
	}

	public function testSetPackage()
	{
		$this->object->setPackage('OtherPackage');
		$this->assertThat(
			$this->object->getPackage(),
			$this->equalTo('OtherPackage')
		);
	}

	public function testSetParameters()
	{
		$p = array(
			'first' => 'value'
		);
		$this->object->setParameters($p);
		$this->assertEquals(
			$p,
			$this->object->getParameters()
		);
	}
}
