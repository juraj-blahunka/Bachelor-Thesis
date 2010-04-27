<?php
require_once 'PHPUnit/Framework.php';

class NotFoundHttpExceptionTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var NotFoundHttpException
	 */
	protected $object;

	protected function setUp()
	{
	}

	protected function tearDown()
	{
	}

	public function testThrow()
	{
		$msg = 'Something was not found';
		try
		{
			throw new NotFoundHttpException($msg);
		}
		catch (HttpException $e)
		{
			$this->assertThat(
				$e->getStatusCode(),
				$this->equalTo(404)
			);
			$this->assertThat(
				$e->getMessage(),
				$this->equalTo($msg)
			);
		}

	}
}
