<?php
require_once 'PHPUnit/Framework.php';

/**
 * Test class for MethodReflectionCache.
 * Generated by PHPUnit on 2010-04-11 at 19:16:40.
 */
class MethodReflectionCacheTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var MethodReflectionCache
	 */
	protected $object;

	protected function setUp()
	{
		$this->object = new MethodReflectionCache();
		$this->object->storeMethod(new ReflectionMethod($this, 'setUp'));
	}

	protected function tearDown()
	{
	}

	public function testStoreMethod()
	{
		$reflection = new ReflectionMethod($this, 'testStoreMethod');
		$key = $this->object->storeMethod($reflection);
		$this->assertThat($key, $this->equalTo('MethodReflectionCacheTest.testStoreMethod'));
		$this->assertThat(
			$this->object->retrieveMethod(get_class($this), 'testStoreMethod'),
			$this->equalTo($reflection)
		);
	}

	public function testRetrieveMethod()
	{
		$reflection = $this->object->retrieveMethod(get_class($this), 'setUp');
		$this->assertThat($reflection, $this->isInstanceOf('ReflectionMethod'));
		$this->assertThat(
			$reflection->getName(),
			$this->equalTo('setUp')
		);
		$this->assertThat(
			$reflection->getDeclaringClass()->getName(),
			$this->equalTo(get_class($this))
		);
	}

	public function testHasMethod()
	{
		$this->assertTrue($this->object->hasMethod(get_class($this), 'setUp'));
	}

	public function testDeleteMethod()
	{
		$this->assertTrue($this->object->hasMethod(get_class($this), 'setUp'));
		$this->object->deleteMethod(get_class($this), 'setUp');
		$this->assertFalse($this->object->hasMethod(get_class($this), 'setUp'));
	}
}
