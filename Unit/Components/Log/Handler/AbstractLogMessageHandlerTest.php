<?php
require_once 'PHPUnit/Framework.php';

/**
 * Test class for AbstractLogMessageHandler.
 * Generated by PHPUnit on 2010-04-27 at 17:46:54.
 */
class AbstractLogMessageHandlerTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var AbstractLogMessageHandler
	 */
	protected $object;

	/**
	 * @var ILogMessageFilter
	 */
	protected $filter;

	/**
	 * @var ILogMessage
	 */
	protected $log;

	protected function setUp()
	{
		$this->filter = $this->getMock('ILogMessageFilter');
		$this->object = new LogMessageHandlerStub_TestSuite(null, array(
			$this->filter
		));
		$this->log = $this->getMock('ILogMessage');
	}

	protected function tearDown()
	{
	}

	public function testIsAbstract()
	{
		$reflection = new ReflectionClass('AbstractLogMessageHandler');
		$this->assertThat($reflection->isAbstract(), $this->equalTo(true));
	}

	public function testHandle_Accept()
	{
		$this->setFilterAcceptValue(true);
		$this->object->handle($this->log);

		$this->assertThat(
			count($this->object->logs),
			$this->equalTo(1)
		);
		$this->assertThat(
			$this->object->logs[0],
			$this->identicalTo($this->log)
		);
	}

	public function testHandle_Unaccepted()
	{
		$this->setFilterAcceptValue(false);
		$this->object->handle($this->log);

		$this->assertThat(
			count($this->object->logs),
			$this->equalTo(0)
		);
	}

	protected function setFilterAcceptValue($bool)
	{
		$this->filter->expects($this->once())->method('accept')
			->will($this->returnValue($bool));
	}
}

class LogMessageHandlerStub_TestSuite extends AbstractLogMessageHandler
{
	public $logs = array();

	public function handleLogMessage($message, ILogMessage $log)
	{
		$this->logs[] = $log;
	}
}
