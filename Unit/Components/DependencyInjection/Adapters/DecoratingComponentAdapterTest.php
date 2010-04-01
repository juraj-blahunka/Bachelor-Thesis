<?php
require_once 'PHPUnit/Framework.php';

/**
 * Test class for DecoratingComponentAdapter.
 * Generated by PHPUnit on 2010-03-12 at 19:32:58.
 */
class DecoratingComponentAdapterTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var DecoratingComponentAdapter
	 */
	protected $object;

	public function testIsAbstractClass()
	{
		$reflection = new ReflectionClass('DecoratingComponentAdapter');
		$this->assertTrue(
			$reflection->isAbstract(),
			'Class can not be instantiated, is abstract'
		);
	}

}
?>