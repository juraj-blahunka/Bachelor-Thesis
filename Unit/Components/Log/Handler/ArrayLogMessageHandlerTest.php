<?php
require_once 'PHPUnit/Framework.php';

/**
 * Test class for ArrayLogMessageHandler.
 * Generated by PHPUnit on 2010-04-27 at 17:42:12.
 */
class ArrayLogMessageHandlerTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var ArrayLogMessageHandler
	 */
	protected $object;

	protected function setUp()
	{
		$this->object = new ArrayLogMessageHandler();
	}

	protected function tearDown()
	{
	}

	public function testHandle()
	{
		$log = $this->getMock('ILogMessage');
		$this->object->handle($log);
		$this->assertThat(
			count($this->object->logs),
			$this->equalTo(1)
		);
		$this->assertThat(
			$this->object->logs[0],
			$this->identicalTo($log)
		);
	}
}
