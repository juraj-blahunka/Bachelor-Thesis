<?php
require_once 'PHPUnit/Framework.php';

/**
 * Test class for ControllerLoadListener.
 * Generated by PHPUnit on 2010-04-26 at 18:06:20.
 */
class ControllerLoadListenerTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var ControllerLoadListener
	 */
	protected $object;

	protected function setUp()
	{
	}

	protected function tearDown()
	{
	}

	public function testHandle()
	{
		$loader = $this->getMock('IControllerLoader');
		$loader->expects($this->once())->method('loadController')
			->will($this->returnValue('controller instance'));
		$route = $this->getMock('IRoute');
		$this->object = new ControllerLoadListener($loader);
		$event = new Event($this, '', array('route' => $route));

		$this->assertThat(
			$this->object->handle($event),
			$this->equalTo(true)
		);

		$this->assertThat(
			$event->getValue(),
			$this->equalTo('controller instance')
		);
	}

	public function testHandle_NotSuccessful()
	{
		$loader = $this->getMock('IControllerLoader');
		$loader->expects($this->once())->method('loadController')
			->will($this->returnValue(null));
		$route = $this->getMock('IRoute');
		$this->object = new ControllerLoadListener($loader);
		$event = new Event($this, '', array('route' => $route));

		$this->assertThat(
			$this->object->handle($event),
			$this->equalTo(false)
		);
	}
}