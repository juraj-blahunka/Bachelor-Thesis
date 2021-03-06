<?php

require_once 'PHPUnit/Framework.php';

require_once TEST_ROOT.'/Fixtures/Components/DependencyInjection/classes.php';

/**
 * Test class for TransientComponentAdapter.
 * Generated by PHPUnit on 2010-03-13 at 13:48:48.
 */
class TransientComponentAdapterTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var TransientComponentAdapter
	 */
	protected $object;

	protected function setUp()
	{
		$mock = $this->getMock('IComponentAdapter');
		$this->object = new TransientComponentAdapter($mock);
	}

	protected function tearDown()
	{
	}

	public function testNothing()
	{
		$this->assertTrue(true, 'Nothing to test');
	}
}
