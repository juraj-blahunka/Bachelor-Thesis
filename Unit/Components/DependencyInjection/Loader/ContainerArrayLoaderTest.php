<?php
require_once 'PHPUnit/Framework.php';

/**
 * Test class for ContainerArrayLoader.
 * Generated by PHPUnit on 2010-04-17 at 13:44:37.
 */
class ContainerArrayLoaderTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var ContainerArrayLoader
	 */
	protected $object;

	protected function setUp()
	{
		$this->object = new ContainerArrayLoader();
	}

	protected function tearDown()
	{
	}

	public function testLoad()
	{
		$data = include(FIXTURES_ROOT.'/Components/DependencyInjection/Loader/SampleArrayConfig.php');
		$builder = $this->object->load($data);
		$this->assertThat($builder->getConstants(), $this->equalTo(array(
			'my.constant' => '1',
			'my.second'   => '2',
		)));

		$this->assertEquals(2, count($builder->getDefinitions()));

		$def = $builder->getDefinition('MyComponent');
		$this->assertThat($def->getClass(), $this->equalTo('My_Special_Component'));
		$this->assertThat($def->getArguments(), $this->equalTo(array(
			array('value', 'my value'),
			array('constant', 'my.constant'),
			array('component', 'Other'),
		)));
		$this->assertThat($def->getMethods(), $this->equalTo(array(
			array('resolve', array(
				array('constant', 'my.second')
			)),
			array('otherMethod', array())
		)));
		$this->assertThat($def->getNotes(), $this->equalTo(array(
			'remember' => 'this',
			'controller.load' => 'resolve',
		)));
		$this->assertThat($def->getScope(), $this->equalTo('transient'));

		$def = $builder->getDefinition('Other');
		$this->assertThat($def->getClass(), $this->equalTo('Other'));
		$this->assertThat($def->getArguments(), $this->equalTo(array()));
		$this->assertThat($def->getMethods(), $this->equalTo(array()));
		$this->assertThat($def->getNotes(), $this->equalTo(array()));
		$this->assertThat($def->getScope(), $this->equalTo('shared'));
	}

	public function testLoad_NotAnArray()
	{
		$this->setExpectedException('UnexpectedValueException');
		$this->object->load('some string');
	}
}
