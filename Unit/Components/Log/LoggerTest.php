<?php
require_once 'PHPUnit/Framework.php';

/**
 * Test class for Logger.
 * Generated by PHPUnit on 2010-04-27 at 16:53:19.
 */
class LoggerTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var Logger
	 */
	protected $object;

	/**
	 * @var ILogMessageHandler
	 */
	protected $handler;

	protected function setUp()
	{
		$this->handler = $this->getMock('ILogMessageHandler');
		$this->handler->expects($this->once())->method('handle')
			->with($this->isInstanceOf('ILogMessage'));
		$this->object = new Logger($this->handler);
	}

	protected function tearDown()
	{
	}

	public function testEmergency()
	{
		$this->object->emergency('message');
	}

	public function testAlert()
	{
		$this->object->alert('message');
	}

	public function testCritical()
	{
		$this->object->critical('message');
	}

	public function testError()
	{
		$this->object->error('message');
	}

	public function testWarning()
	{
		$this->object->warning('message');
	}

	public function testNotice()
	{
		$this->object->notice('message');
	}

	public function testInfo()
	{
		$this->object->info('message');
	}

	public function testDebug()
	{
		$this->object->debug('message');
	}

	public function testEmergency_WithAdditional()
	{
		$this->object->emergency('message', 'additional');
	}
}
