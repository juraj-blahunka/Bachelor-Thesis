<?php
require_once 'PHPUnit/Framework.php';

require_once TEST_ROOT.'/Fixtures/Components/DependencyInjection/classes.php';

/**
 * Test class for ClassReflectionCache.
 * Generated by PHPUnit on 2010-04-11 at 19:09:53.
 */
class ClassReflectionCacheTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var ClassReflectionCache
	 */
	protected $object;

	protected function setUp()
	{
		$this->object = new ClassReflectionCache();
		$this->object->storeClass(new ReflectionClass('WeakPunch'));
	}

	protected function tearDown()
	{
	}

	public function testStoreClass()
	{
		$reflection = new ReflectionClass('StrongPunch');
		$key = $this->object->storeClass($reflection);
		$this->assertThat($key, $this->equalTo('StrongPunch'));
		$this->assertThat(
			$this->object->retrieveClass($key),
			$this->identicalTo($reflection)
		);
	}

	public function testRetrieveClass()
	{
		$reflection = $this->object->retrieveClass('WeakPunch');
		$this->assertThat($reflection, $this->isInstanceOf('ReflectionClass'));
		$this->assertThat($reflection->getName(), $this->equalTo('WeakPunch'));
	}

	public function testHasClass()
	{
		$this->assertTrue($this->object->hasClass('WeakPunch'));
		$this->assertFalse($this->object->hasClass('UndefinedPunch'));
	}

	public function testDeleteClass()
	{
		$this->assertTrue($this->object->hasClass('WeakPunch'));
		$this->object->deleteClass('WeakPunch');
		$this->assertFalse($this->object->hasClass('WeakPunch'));
	}
}
