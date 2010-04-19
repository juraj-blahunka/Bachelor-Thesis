<?php
require_once 'PHPUnit/Framework.php';

/**
 * Test class for PackageCollection.
 * Generated by PHPUnit on 2010-04-19 at 22:00:48.
 */
class PackageCollectionTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var PackageCollection
	 */
	protected $object;

	protected function setUp()
	{
		$this->object = new PackageCollection();
	}

	protected function tearDown()
	{
	}

	public function testAddPackage()
	{
		$package = $this->getMock('IPackage');
		$package->expects($this->once())->method('getPackageName')->will($this->returnValue('Sample'));
		$this->object->addPackage($package);
		$this->assertThat(
			$this->object->getPackage('Sample'),
			$this->identicalTo($package)
		);
	}

	public function testSetPackages()
	{
		$package1 = $this->getMock('IPackage');
		$package1->expects($this->once())->method('getPackageName')->will($this->returnValue('Sample1'));
		$package2 = $this->getMock('IPackage');
		$package2->expects($this->once())->method('getPackageName')->will($this->returnValue('Sample2'));
		$packages = array(
			'Sample1' => $package1,
			'Sample2' => $package2
		);
		$this->object->setPackages($packages);
		$this->assertThat(
			$this->object->getPackages(),
			$this->equalTo($packages)
		);
	}
}