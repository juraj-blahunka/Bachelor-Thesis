<?php
require_once 'PHPUnit/Framework.php';

class HttpExceptionTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var HttpException
	 */
	protected $object;

	protected function setUp()
	{
	}

	protected function tearDown()
	{
	}

	public function testGetStatusCode()
	{
		try
		{
			throw new HttpException(404, 'Test exception');
		}
		catch (HttpException $e)
		{
			$this->assertThat(
				$e->getStatusCode(),
				$this->equalTo(404)
			);
		}
	}
}
