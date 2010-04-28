<?php

require_once 'PHPUnit/Framework.php';

/**
 * Test class for ComponentDefinitionToComponentAdapter.
 * Generated by PHPUnit on 2010-03-13 at 15:02:07.
 */
class ComponentDefinitionToComponentAdapterTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var ComponentDefinitionToComponentAdapter
	 */
	protected $object;

	protected function setUp()
	{
		$this->object = new ComponentDefinitionToComponentAdapter();
	}

	protected function tearDown()
	{
	}

	public function testConvert()
	{
		$definition = new ComponentDefinition('HelloClass');
		$definition->setTransient();
		$adapter = $this->object->convert(null, $definition);

		$this->assertThat($adapter, $this->isInstanceOf('ConstructorComponentAdapter'));
		$this->assertThat(null, $this->equalTo($adapter->getKey()));
		$this->assertThat('HelloClass', $this->equalTo($adapter->getClass()));
	}

	public function testConvertShared()
	{
		$definition = new ComponentDefinition('HelloClass');

		$adapter = $this->object->convert(null, $definition);

		$this->assertThat($adapter, $this->isInstanceOf('SharedComponentAdapter'));
		$this->assertThat($adapter->getAdapter(), $this->isInstanceOf('ConstructorComponentAdapter'));
	}

	public function testWithArguments()
	{
		$definition = new ComponentDefinition('HelloClass');
		$definition->addArgument('value', 'my value')
			->addArgument('constant', 'constant_key')
			->addArgument('component', 'component_key')
			->addArgument('array', array(array('value', 'another value')))
			->setTransient();

		$adapter = $this->object->convert(null, $definition);

		$args = $adapter->getArguments();
		$this->assertThat('HelloClass', $this->equalTo($adapter->getClass()));
		$this->assertThat(null,     $this->equalTo($adapter->getKey()));
		$this->assertThat($adapter, $this->isInstanceOf('ConstructorComponentAdapter'));
		$this->assertThat($args[0], $this->isInstanceOf('ValueArgument'));
		$this->assertThat($args[1], $this->isInstanceOf('ConstantArgument'));
		$this->assertThat($args[2], $this->isInstanceOf('ComponentArgument'));
		$this->assertThat($args[3], $this->isInstanceOf('ArrayArgument'));
	}

	public function testWithArguments_AssociativeArrayArgument()
	{
		$definition = new ComponentDefinition('HelloClass');
		$definition->setTransient()->addArgument('array', array(
			'first'  => array('value', '1'),
			'second' => array('value', '2'),
			'third'  => array('value', '3'),
		));
		$adapter = $this->object->convert(null, $definition);

		$args  = $adapter->getArguments();
		$arrayArgument = $args[0];

		$this->assertThat($arrayArgument, $this->isInstanceOf('ArrayArgument'));

		$container = $this->getMock('IDependencyInjectionContainer');
		$adapter   = $this->getMock('IComponentAdapter');

		$resolved = $arrayArgument->resolve($container, $adapter);

		$this->assertThat($resolved, $this->equalTo(array(
			'first'  => '1',
			'second' => '2',
			'third'  => '3'
		)));
	}

	public function testWithUnrecognizedArguments()
	{
		$definition = new ComponentDefinition('HelloClass');
		$definition->addArgument('unrecognized', null)
			->setTransient();

		$this->setExpectedException('InvalidArgumentException');
		$adapter = $this->object->convert(null, $definition);
	}

	public function testWithMethodAfterConstruction()
	{
		$definition = new ComponentDefinition('HelloClass');
		$definition->addMethod('methodName')
			->setTransient();

		$adapter = $this->object->convert(null, $definition);

		$methods = $adapter->getMethods();
		$this->assertThat($adapter, $this->isInstanceOf('MethodsAfterConstructionAdapter'));
		$this->assertThat($adapter->getAdapter(), $this->isInstanceOf('ConstructorComponentAdapter'));
		$this->assertThat(array(array('methodName', array())), $this->equalTo($methods));
	}
}
