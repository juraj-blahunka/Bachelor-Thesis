<?php
require_once 'PHPUnit/Framework.php';

/**
 * Test class for DefaultLogMessageFormatter.
 * Generated by PHPUnit on 2010-04-27 at 17:24:01.
 */
class DefaultLogMessageFormatterTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var DefaultLogMessageFormatter
	 */
	protected $object;

	protected function setUp()
	{
		$this->object = new DefaultLogMessageFormatter();
	}

	protected function tearDown()
	{
	}

	public function testFormat()
	{
		$timestamp = date('c');
		$log = new LogMessage('my message', array(
			'timestamp' => $timestamp
		));
		$message = $this->object->format($log);
		$this->assertThat($message, $this->equalTo("{$timestamp} (NO LEVEL) my message"));
	}

	public function testFormat_NoTimestamp()
	{
		$log = new LogMessage('my message');
		$message = $this->object->format($log);
		$this->assertThat($message, $this->equalTo('no timestamp (NO LEVEL) my message'));
	}
}
