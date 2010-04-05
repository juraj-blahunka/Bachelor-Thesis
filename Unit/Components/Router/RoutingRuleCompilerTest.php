<?php
require_once 'PHPUnit/Framework.php';

/**
 * Test class for RoutingRuleCompiler.
 * Generated by PHPUnit on 2010-02-24 at 13:46:43.
 */
class RoutingRuleCompilerTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var RoutingRuleCompiler
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new RoutingRuleCompiler(
			new RouterFactory()
		);
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	public function test()
	{
		$rule = new RoutingRule(
			'some rule',
			'/{controller}/{action}/{year}',
			array(
				'controller' => 'Default'
			),
			array(
				'controller' => 'string',
				'action'     => 'string',
				'year'       => 'int',
			)
		);

		$compiled = $this->object->compile($rule);

		$this->assertEquals(
			$rule,
			$compiled->getRule()
		);

		$this->assertEquals(
			'/^\/(?<controller>[a-zA-Z0-9-_]+)\/(?<action>[a-zA-Z0-9-_]+)\/(?<year>[0-9]+)$/',
			$compiled->getRegex()
		);
	}

	public function testFailingToFindPattern()
	{
		$rule = new RoutingRule(
			'some name',
			'/{controller}',
			array(),
			array(
				'controller'     => 'not-existing-pattern-name'
			)
		);

		$this->setExpectedException('InvalidArgumentException');
		$this->object->compile($rule);
	}

	public function testForDefaultPattern()
	{
		$rule = new RoutingRule(
			'rule with undefined requirements',
			'/{controller}',
			array('action'=>'index')
		);

		$compiled = $this->object->compile($rule);

		$this->assertEquals(
			'/^\/(?<controller>[a-zA-Z0-9-_]+)$/',
			$compiled->getRegex()
		);
	}
}
?>
