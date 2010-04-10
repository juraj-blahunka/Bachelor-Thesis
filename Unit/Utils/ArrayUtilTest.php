<?php
require_once 'PHPUnit/Framework.php';

/**
 * Test class for ArrayUtil.
 * Generated by PHPUnit on 2010-04-11 at 00:01:46.
 */
class ArrayUtilTest extends PHPUnit_Framework_TestCase
{
	protected $array = array(
		'small caps',
		'associated' => 'MiXED caPs'
	);

	public function testInArrayCaseInsensitive()
	{
		$this->assertTrue(ArrayUtil::inArrayCaseInsensitive('small caps', $this->array));
		$this->assertTrue(ArrayUtil::inArrayCaseInsensitive('SMALL CAPS', $this->array));
		$this->assertTrue(ArrayUtil::inArrayCaseInsensitive('mixed caps', $this->array));
	}
}
