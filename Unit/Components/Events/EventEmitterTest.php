<?php
require_once 'PHPUnit/Framework.php';

/**
 * Test class for EventEmitter.
 * Generated by PHPUnit on 2010-02-16 at 20:02:39.
 */

interface IMockListener
{
	function testCallback();
}

class EventEmitterTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var EventEmitter
	 */
	protected $dispatcher;

	protected function setUp()
	{
		$this->dispatcher = new EventEmitter();
	}

	protected function tearDown()
	{
	}

	public function testAttachAndDetach()
	{
		$name = 'test.listener';
		$listener = array($this, 'testListener');

		$this->dispatcher->attach($name, $listener);
		$this->assertEquals(
			array($listener),
			$this->dispatcher->getListeners($name)
		);
		
		$this->dispatcher->detach($name, $listener);
		$this->assertEquals(
			array(),
			$this->dispatcher->getListeners($name)
		);

		$ret = $this->dispatcher->detach('unexisting.eventtype', null);
		$this->assertThat(
			false,
			$this->equalTo($ret),
			'Testing with unexisting event type'
		);
	}

	public function testEmptyGetListeners()
	{
		$this->assertEquals(
			array(),
			$this->dispatcher->getListeners('some.undefined.event')
		);
	}

	public function testNotify()
	{
		$name = 'test.listener';
		$mock = $this->getMock('IMockListener');
		$listener = array($mock, 'testCallback');

		$this->dispatcher->attach($name, $listener);
		$this->assertEquals(
			array($listener),
			$this->dispatcher->getListeners($name)
		);

		$e = new Event(null, $name);

		$mock->expects($this->once())
			->method('testCallback')
			->with($e);
		
		$this->dispatcher->notify($e);
	}

	public function testNotifyUntil()
	{
		$name       = 'test.listener';
		$mocks      = array();
		$listeners  = array();

		for ($i = 0; $i < 4; $i++)
		{
			$mocks[$i]      = $this->getMock('IMockListener');
			$listeners[$i]  = array($mocks[$i], 'testCallback');
			$this->dispatcher->attach($name, $listeners[$i]);
		}

		$this->assertThat(
			$listeners,
			$this->equalTo($this->dispatcher->getListeners($name)),
			'Both listener arrays must are equal'
		);

		$e = new Event(null, $name);

		$mocks[0]->expects($this->once())
			->method('testCallback');
			
		$mocks[1]->expects($this->once())
			->method('testCallback')
			->will($this->returnValue(true));

		$mocks[2]->expects($this->never())
			->method('testCallback');

		$mocks[3]->expects($this->never())
			->method('testCallback');

		// notifies only first 2 mocks, other 2 mocks are not called
		$this->dispatcher->notifyUntil($e, true);
	}
}
