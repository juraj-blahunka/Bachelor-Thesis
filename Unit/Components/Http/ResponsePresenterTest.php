<?php
require_once 'PHPUnit/Framework.php';

/**
 * Test class for RenderableResponse.
 * Generated by PHPUnit on 2010-04-23 at 16:31:50.
 */
class ResponsePresenterTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var IResponse
	 */
	protected $response;

	/**
	 * @var RenderableResponse
	 */
	protected $object;

	protected function setUp()
	{
		$this->response = $this->getMock('IResponse');
		$this->object   = new ResponsePresenter($this->response);
	}

	protected function tearDown()
	{
	}

	public function testGetOriginalResponse()
	{
		$this->assertThat(
			$this->object->getOriginalResponse(),
			$this->identicalTo($this->response)
		);
	}

	public function testSetVariables()
	{
		$vars = array(
			'var1' => 'val1',
			'var2' => 'val2'
		);
		$this->object->setVariables($vars);
		$this->assertThat(
			$this->object->getVariables(),
			$this->equalTo($vars)
		);
	}

	public function testGetVariables()
	{
		$this->assertThat(
			$this->object->getVariables(),
			$this->equalTo(array())
		);
	}

	public function testAddVariables()
	{
		$this->object->setVariables(array(
			'first'     => '1',
			'untouched' => 'value',
		));
		$this->object->addVariables(array(
			'some_context' => 'value',
			'first'        => '2',
		));

		$this->assertThat($this->object->getVariables(), $this->equalTo(array(
			'some_context' => 'value',
			'first'        => '2',
			'untouched'    => 'value',
		)));
	}

	public function testSetViewName()
	{
		$this->object->setViewName('view/name');
		$this->assertThat(
			$this->object->getViewName(),
			$this->equalTo('view/name')
		);
	}

	public function testGetViewName()
	{
		$this->assertThat(
			$this->object->getViewName(),
			$this->equalTo(null)
		);
	}
}