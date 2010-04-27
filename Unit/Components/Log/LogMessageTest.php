<?php
require_once 'PHPUnit/Framework.php';

/**
 * Test class for LogMessage.
 * Generated by PHPUnit on 2010-04-27 at 17:18:29.
 */
class LogMessageTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var LogMessage
	 */
	protected $object;

	protected function setUp()
	{
		$this->object = new LogMessage('message', array(
			'extra' => 'extra message'
		));
	}

	protected function tearDown()
	{
	}

	public function testSetMessage()
	{
		$this->object->setMessage('new message');
		$this->assertThat(
			$this->object->getMessage(),
			$this->equalTo('new message')
		);
	}

	public function testGetMessage()
	{
		$this->assertThat(
			$this->object->getMessage(),
			$this->equalTo('message')
		);
	}

	public function testSetParameters()
	{
		$params = array(
			'param1' => 'value1'
		);
		$this->object->setParameters($params);
		$this->assertThat(
			$this->object->getParameters(),
			$this->equalTo($params)
		);
	}

	public function testGetParameters()
	{
		$this->assertThat(
			$this->object->getParameters(),
			$this->equalTo(array(
				'extra' => 'extra message'
			))
		);
	}

	public function testAddParameters()
	{
		$this->object->addParameters(array(
			'another' => 'message'
		));
		$this->assertThat($this->object->getParameters(), $this->equalTo(array(
			'extra'   => 'extra message',
			'another' => 'message'
		)));
	}

	public function testSetParameter()
	{
		$this->object->setParameter('extra', 'new value');
		$this->assertThat($this->object->getParameter('extra'), $this->equalTo('new value'));
	}

	public function testGetParameter()
	{
		$this->assertThat(
			$this->object->getParameter('extra'),
			$this->equalTo('extra message')
		);
		$this->assertThat(
			$this->object->getParameter('undefined'),
			$this->equalTo(null)
		);
		$this->assertThat(
			$this->object->getParameter('undefined', 'default'),
			$this->equalTo('default')
		);
	}
}
