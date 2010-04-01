<?php

require_once 'PHPUnit/Framework.php';

require_once TEST_ROOT.'/Fixtures/Components/DependencyInjection/classes.php';

/**
 * Test class for MethodsAfterConstructionAdapter.
 * Generated by PHPUnit on 2010-03-12 at 19:42:45.
 */
class MethodsAfterConstructionAdapterTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var DependencyInjectionContainer
	 */
	protected $container;

	/**
	 * @var array
	 */
	protected $manyMethods;

	/**
	 * @var array
	 */
	protected $noMethods;

	/**
	 * @var IComponentAdapter
	 */
	protected $adapter;

	/**
	 * @var PunchReceiver
	 */
	protected $against;

	protected function setUp()
	{
		$this->container = new DependencyInjectionContainer();
		$this->container->registerComponent('WeakPunch');
		$this->container->registerComponent('StrongPunch');

		$this->manyMethods = array(
			array('fromNothing',   array()),
			array('fromSomePunch', array(new ComponentArgument('WeakPunch'))),
			array('fromWeakPunch', array(new ComponentArgument('MediumPunch'))),
			array('fromPunches',   array()),
		);

		$this->noMethods = array();

		$this->against = new PunchReceiver();

		$this->adapter = $this->getMock('IComponentAdapter');
		$this->adapter->expects($this->any())
			->method('getInstance')
			->will($this->returnValue($this->against));
	}

	protected function tearDown()
	{
	}

	public function testGetMethodsWithEmptyArray()
	{
		$methodsAdapter = new MethodsAfterConstructionAdapter(
			$this->noMethods , $this->adapter
		);
		$this->assertEquals($this->noMethods, $methodsAdapter->getMethods());
	}

	public function testGetMethodsWithFilledArray()
	{
		$methodsAdapter = new MethodsAfterConstructionAdapter(
			$this->manyMethods , $this->adapter
		);
		$this->assertEquals($this->manyMethods, $methodsAdapter->getMethods());
	}

	public function testGetInstance()
	{
		$methodsAdapter = new MethodsAfterConstructionAdapter(
			$this->manyMethods , $this->adapter
		);

		$instance = $methodsAdapter->getInstance($this->container);


		$this->assertTrue($this->against->calledWithNothing);
		$this->assertThat(4, $this->equalTo($this->against->wasHit));

	}

	public function testGetInstanceWithZeroMethods()
	{

	}
}