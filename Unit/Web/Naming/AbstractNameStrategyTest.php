<?php
require_once 'PHPUnit/Framework.php';

class ConcreteNameStrategy extends AbstractNameStrategy
{
	public function getClassName($name)
	{
		return $name;
	}
}

/**
 * Test class for AbstractNameStrategy.
 * Generated by PHPUnit on 2010-04-14 at 12:52:33.
 */
class AbstractNameStrategyTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var AbstractNameStrategy
	 */
	protected $object;

	protected function setUp()
	{
	}

	protected function tearDown()
	{
	}

	public function testClassIsAbstract()
	{
		$reflection = new ReflectionClass('AbstractNameStrategy');
		$this->assertTrue($reflection->isAbstract());
	}

	public function testConcreteIsProper()
	{
		$strategy = new ConcreteNameStrategy();
		$this->assertThat(
			$strategy->getFileName('some-hyphenated-string'),
			$this->equalTo('SomeHyphenatedString')
		);
		$this->assertThat(
			$strategy->getClassName('Class'),
			$this->equalTo('Class')
		);
	}
}
