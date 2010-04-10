<?php
require_once 'PHPUnit/Framework.php';

require_once TEST_ROOT.'/Fixtures/Components/DependencyInjection/classes.php';

/**
 * Test class for DependencyInjectionContainer.
 * Generated by PHPUnit on 2010-03-05 at 19:42:12.
 */
class DependencyInjectionContainerTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var DependencyInjectionContainer
	 */
	protected $object;

	/**
	 * @var DependencyInjectionContainer
	 */
	protected $child;

	protected function setUp()
	{
		$this->object = new DependencyInjectionContainer;
		$this->object->addConstants(array(
			'test.first' => 'first default',
			'test.second' => 'second default',
		));
		$this->child = $this->object->createChildContainer();
	}

	protected function tearDown()
	{
	}

	protected function createWeakPunchComponentAdapterMock($key = 'WeakPunch', $instance = null)
	{
		$mock = $this->getMock('IComponentAdapter');
		$mock->expects($this->any())->method('getInstance')
			->will($this->returnValue($instance));
		$mock->expects($this->any())->method('getClass')
			->will($this->returnValue('WeakPunch'));
		$mock->expects($this->any())->method('getKey')
			->will($this->returnValue($key));
		return $mock;
	}

	public function testGetConstant()
	{
		$this->assertThat(
			$this->object->getConstant('test.first'),
			$this->equalTo('first default')
		);
	}

	public function testGetConstant_UndefinedConstant()
	{
		$this->assertThat(
			$this->object->getConstant('test.undefined'),
			$this->equalTo(null)
		);
	}

	public function testSetConstant()
	{
		$this->object->setConstant('test.first', 'overwritten');
		$this->assertThat(
			$this->object->getConstant('test.first'),
			$this->equalTo('overwritten')
		);
	}

	public function testAddConstants()
	{
		$this->object->addConstants(array(
			'test.third' => 'third test value'
		));
		$this->assertThat(
			$this->object->getConstants(),
			$this->equalTo(array(
				'test.first' => 'first default',
				'test.second' => 'second default',
				'test.third' => 'third test value'
			))
		);
	}

	public function testGetConstants()
	{
		$this->assertThat($this->object->getConstants(), $this->equalTo(array(
			'test.first' => 'first default',
			'test.second' => 'second default',
		)));
	}

	public function testSetComponentAdapterAndGetAdapter_FromAdapters()
	{
		$adapter = $this->getMock('IComponentAdapter');
		$adapter->expects($this->once())
			->method('getKey')
			->will($this->returnValue('hello_class_component'));
		$this->object->setComponentAdapter($adapter);
		$this->assertThat(
			$this->object->getComponentAdapter('hello_class_component'),
			$this->equalTo($adapter)
		);
	}

	public function testGetComponentAdapter_UnknownAdapter()
	{
		$this->assertThat(
			$this->object->getComponentAdapter('undefined_component'),
			$this->equalTo(null)
		);
	}

	public function testSetComponentAdapterAndGetAdapter_FromDefinitions()
	{
		$this->object->registerComponent('hello_class_component');
		$this->assertThat(
			$this->object->getComponentAdapter('hello_class_component'),
			$this->isInstanceOf('IComponentAdapter')
		);
	}

	public function testGetAdaptersOfType_ExplicitlySetWithAdapter()
	{
		$instance = new WeakPunch();
		$adapter = $this->createWeakPunchComponentAdapterMock(
			'WeakPunch', $instance
		);
		$this->object->setComponentAdapter($adapter);

		$result = $this->object->getAdaptersOfType('WeakPunch');

		$this->assertThat(
			$result,
			$this->equalTo(array(
				$adapter
			))
		);
	}

	public function testGetAdaptersOfType_ExplicitlySetWithDefinition()
	{
		$this->object->registerComponent('WeakPunch');
		$result = $this->object->getAdaptersOfType('WeakPunch');

		$this->assertTrue(count($result) == 1);
		$this->assertTrue(isset($result[0]));
		$this->assertThat(
			$result[0],
			$this->isInstanceOf('IComponentAdapter')
		);
		$this->assertThat(
			$result[0]->getClass(),
			$this->equalTo('WeakPunch')
		);
	}

	public function testGetAdaptersOfType_ExplicitWithSameClass()
	{
		$instance = new WeakPunch();
		$adapter = $this->createWeakPunchComponentAdapterMock(
			'weak_punch_component', $instance
		);
		$this->object->setComponentAdapter($adapter);

		$result = $this->object->getAdaptersOfType('WeakPunch');

		$this->assertTrue((count($result) == 1) && (isset($result[0])));
		$this->assertThat($result[0]->getClass(), $this->equalTo('WeakPunch'));
		$this->assertThat($result[0]->getKey(), $this->equalTo('weak_punch_component'));
	}

	public function testGetAdaptersOfType_ExtendsClass()
	{
		$instance = new MediumPunch();
		$adapter = $this->getMock('IComponentAdapter');
		$adapter->expects($this->any())->method('getKey')
			->will($this->returnValue('medium_punch_component'));
		$adapter->expects($this->any())->method('getClass')
			->will($this->returnValue('MediumPunch'));
		$adapter->expects($this->any())->method('getInstance')
			->will($this->returnValue($instance));
		$this->object->setComponentAdapter($adapter);

		$result = $this->object->getAdaptersOfType('WeakPunch');

		$this->assertTrue((count($result) == 1) && (isset($result[0])));
		$this->assertThat($result[0]->getClass(), $this->equalTo('MediumPunch'));
		$this->assertThat($result[0]->getKey(), $this->equalTo('medium_punch_component'));
	}

	public function testGetAdaptersOfType_ImplementInterface()
	{
		$this->object->registerComponent('WeakPunch');
		$this->object->registerComponent('MediumPunch');
		$this->object->registerComponent('StrongPunch');

		$result = $this->object->getAdaptersOfType('IPunchable');

		$this->assertTrue(count($result) == 3);
		$this->assertThat($result[0]->getClass(), $this->equalTo('WeakPunch'));
		$this->assertThat($result[1]->getClass(), $this->equalTo('MediumPunch'));
		$this->assertThat($result[2]->getClass(), $this->equalTo('StrongPunch'));
	}

	public function testGetDefinition_NonExistingComponentKey()
	{
		$this->assertThat(
			$this->object->getDefinition('non_existing_key'),
			$this->equalTo(null)
		);
	}

	public function testGetDefinition_DefinedComponent()
	{
		$definition = $this->object->registerComponent('WeakPunch');
		$this->assertThat(
			$this->object->getDefinition('WeakPunch'),
			$this->equalTo($definition)
		);
	}

	public function testGetDefinitions_AreEmpty()
	{
		$this->assertThat(
			$this->object->getDefinitions(),
			$this->equalTo(array())
		);
	}

	public function testGetDefintions_WithDefinedComponents()
	{
		$weak   = $this->object->registerComponent('WeakPunch');
		$strong = $this->object->registerComponent('StrongPunch');

		$this->assertThat(
			$this->object->getDefinitions(),
			$this->equalTo(array(
				'WeakPunch'   => $weak,
				'StrongPunch' => $strong
			))
		);
	}

	public function testGetInstanceOf_DefinitionByComponentId()
	{
		$this->object->registerComponent('weak_punch_component')
			->setClass('WeakPunch');
		$this->assertThat(
			$this->object->getInstanceOf('weak_punch_component'),
			$this->isInstanceOf('WeakPunch')
		);
	}

	public function testGetInstanceOf_DefinitionByClass()
	{
		$this->object->registerComponent('WeakPunch');
		$this->assertThat(
			$this->object->getInstanceOf('WeakPunch'),
			$this->isInstanceOf('WeakPunch')
		);
	}

	public function testGetInstanceOf_NotRegisteredClass()
	{
		$this->assertThat(
			count($this->object->getAdaptersOfType('WeakPunch')),
			$this->equalTo(0)
		);
		$this->assertThat(
			$this->object->getInstanceOf('WeakPunch'),
			$this->isInstanceOf('WeakPunch')
		);
	}

	public function testGetInstanceOf_RegisteredClassWithCustomId()
	{
		$this->object->registerComponent('weak_punch_component')
			->setClass('WeakPunch');
		$this->assertThat(
			$this->object->getInstanceOf('WeakPunch'),
			$this->isInstanceOf('WeakPunch')
		);
		$this->assertThat(
			$this->object->getInstanceOf('weak_punch_component'),
			$this->isInstanceOf('WeakPunch')
		);
	}

	public function testGetInstanceOf_MoreAdequateComponents()
	{
		$this->object->registerComponent('WeakPunch');
		$this->object->registerComponent('DecoratedPunchable');

		$this->setExpectedException('AmbiguousArgumentException');
		$this->object->getInstanceOf('IPunchable');
	}

	public function testGetInstanceOf_WithUndefinedTypes()
	{
		$this->setExpectedException('InjecteeArgumentException');
		$this->object->getInstanceOf('PunchInTheFaceCauseItFails');
	}

	public function testGetInstanceOfWith_DeclaredArguments()
	{
		$depends = $this->object->getInstanceOfWith('DependsOnPunchable', array(
			array('component', 'MediumPunch')
		));
		$this->assertThat(
			$depends->punchable,
			$this->isInstanceOf('MediumPunch')
		);
	}

	public function testGetInstanceOfWith_InstantiatedArguments()
	{
		$argument = new StrongPunch();
		$depends = $this->object->getInstanceOfWith('DependsOnPunchable', array(
			$argument
		));
		
		$this->assertThat($depends->punchable, $this->identicalTo($argument));
	}

	public function testChild_getConstant()
	{
		$this->assertThat(
			$this->child->getConstant('test.first'),
			$this->equalTo('first default')
		);
	}

	public function testChild_getConstants_Empty()
	{
		$this->assertThat(
			$this->child->getConstants(),
			$this->equalTo(array())
		);
	}

	public function testChild_getInstanceOf()
	{
		$this->object->registerComponent('MediumPunch');
		$this->object->registerComponent('DecoratedPunchable')
			->addArgument('component', 'MediumPunch');
		$this->object->registerComponent('DependsOnPunchable')
			->addArgument('component', 'DecoratedPunchable');

		$instance = $this->child->getInstanceOf('DependsOnPunchable');

		$this->assertThat(
			$instance,
			$this->isInstanceOf('DependsOnPunchable')
		);

		$this->assertThat(
			$instance->punchable,
			$this->isInstanceOf('DecoratedPunchable')
		);

		$this->assertThat(
			$instance->punchable->delegate,
			$this->isInstanceOf('MediumPunch')
		);
	}
}
