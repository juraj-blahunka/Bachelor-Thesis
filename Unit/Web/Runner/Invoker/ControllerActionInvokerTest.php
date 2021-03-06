<?php
require_once 'PHPUnit/Framework.php';

/**
 * Test class for ControllerActionInvoker.
 * Generated by PHPUnit on 2010-04-26 at 20:36:30.
 */
class ControllerActionInvokerTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var ControllerActionInvoker
	 */
	protected $object;

	/**
	 * @var ReflectionCache
	 */
	protected $cache;

	protected function setUp()
	{
		$this->cache  = new ReflectionCache(new ClassReflectionCache(), new MethodReflectionCache());
		$this->object = new ControllerActionInvoker($this->cache, new ActionNameStrategy());
	}

	protected function tearDown()
	{
	}

	public function testCanInvoke()
	{
		$route = new Route();
		$route->setAction('sample');
		$controller = $this->createController();

		$this->assertThat(
			$this->object->canInvoke($controller, $route),
			$this->equalTo(true)
		);
	}

	public function testInvoke()
	{
		$route = new Route();
		$route->setAction('sample')->setParameters(array(
			'p1' => 'Hello ',
			'p2' => 'World!',
			'p3' => 'does\'nt matter',
		));
		$controller = $this->createController();

		$this->assertThat(
			$this->object->invoke($controller, $route),
			$this->equalTo('Hello World! (from optional)')
		);
	}

	public function testInvoke_Failing()
	{
		$route = new Route();
		$route->setAction('sample');
		$controller = $this->createController();

		$this->setExpectedException('NotFoundHttpException');
		$this->object->invoke($controller, $route);
	}

	protected function createController()
	{
		return new ControllerStub_ControllerActionInvokerTest();
	}
}

class ControllerStub_ControllerActionInvokerTest
{
	public function sampleAction($p1, $p2, $p4 = ' (from optional)')
	{
		return $p1 . $p2 . $p4;
	}
}
