<?php
require_once 'PHPUnit/Framework.php';

/**
 * Test class for Request.
 * Generated by PHPUnit on 2010-04-23 at 20:11:06.
 */
class RequestTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var Request
	 */
	protected $object;

	protected function setUp()
	{
		$get = array(
			'get1' => 'value',
		);
		$post = array(
			'post1' => 'another value',
		);
		$cookies = array(
			'user' => '123',
		);
		$server = array(
			'SERVER_ADDR'     => '127.0.0.1',
			'HTTP_HOST'       => 'localhost',
			'SERVER_PORT'     => '8080',
			'REQUEST_URI'     => '/Bachelor-Thesis/Source/Tryout/default/request',
			'SCRIPT_FILENAME' => 'E:/Documents/Domains/localhost/Bachelor-Thesis/Source/Tryout/index.php',
			'SCRIPT_NAME'     => '/Bachelor-Thesis/Source/Tryout/index.php',
		);
		$this->object = new Request($get, $post, $cookies, $server);
	}

	protected function tearDown()
	{
	}

	public function testHasParameter()
	{
		$this->assertThat(
			$this->object->hasParameter('undefined'),
			$this->equalTo(false)
		);
	}

	public function testHasParameter_Defined()
	{
		$this->assertThat(
			$this->object->hasParameter('get1'),
			$this->equalTo(true)
		);
	}

	public function testGetParameter()
	{
		$this->assertThat(
			$this->object->getParameter('undefined', 'default'),
			$this->equalTo('default')
		);
		$this->assertThat(
			$this->object->getParameter('undefined'),
			$this->equalTo(null)
		);
		$this->assertThat(
			$this->object->getParameter('get1'),
			$this->equalTo('value')
		);
		$this->assertThat(
			$this->object->getParameter('post1'),
			$this->equalTo('another value')
		);
	}

	public function testSetParameter()
	{
		$this->object->setParameter('param', 'data');
		$this->assertThat(
			$this->object->getParameter('param'),
			$this->equalTo('data')
		);
	}

	public function testGetParameters()
	{
		$this->assertThat(
			$this->object->getParameters(),
			$this->equalTo(array(
				'get1' => 'value',
				'post1' => 'another value',
			))
		);
	}

	public function testHasCookie()
	{
		$this->assertThat(
			$this->object->hasCookie('undefined cookie'),
			$this->equalTo(false)
		);
		$this->assertThat(
			$this->object->hasCookie('user'),
			$this->equalTo(true)
		);
	}

	public function testGetCookie()
	{
		$this->assertThat(
			$this->object->getCookie('user'),
			$this->equalTo('123')
		);
		$this->assertThat(
			$this->object->getCookie('undefined', 'default'),
			$this->equalTo('default')
		);
		$this->assertThat(
			$this->object->getCookie('undefined'),
			$this->equalTo(null)
		);
	}

	public function testHasServer()
	{
		$this->assertThat(
			$this->object->hasServer('UNDEFINED_SERVER'),
			$this->equalTo(false)
		);
		$this->assertThat(
			$this->object->hasServer('SERVER_ADDR'),
			$this->equalTo(true)
		);
	}

	public function testGetServer()
	{
		$this->assertThat(
			$this->object->getServer('UNDEFINED'),
			$this->equalTo(null)
		);
		$this->assertThat(
			$this->object->getServer('SERVER_ADDR'),
			$this->equalTo('127.0.0.1')
		);
	}

	public function testIsSecure()
	{
		$this->assertThat(
			$this->object->isSecure(),
			$this->equalTo(false)
		);
	}

	public function testGetProtocol()
	{
		$this->assertThat(
			$this->object->getProtocol(),
			$this->equalTo('http')
		);
	}

	public function testGetHost()
	{
		$this->assertThat(
			$this->object->getHost(),
			$this->equalTo('localhost')
		);
	}

	public function testGetHost_OnlyAddress()
	{
		$request = new Request(array(), array(), array(), array(
			'SERVER_ADDR' => '127.0.0.1',
		));
		$this->assertThat(
			$request->getHost(),
			$this->equalTo('127.0.0.1')
		);
	}

	public function testGetHost_Undefined()
	{
		$request = new Request();
		$this->assertThat(
			$request->getHost(),
			$this->equalTo('')
		);
	}

	public function testGetHttpHost()
	{
		$this->assertThat(
			$this->object->getHttpHost(),
			$this->equalTo('localhost')
		);
	}

	public function testGetHttpHost_FromNameAndPort()
	{
		$request = new Request(array(), array(), array(), array(
			'SERVER_NAME' => 'server',
			'SERVER_PORT' => '8080'
		));
		$this->assertThat(
			$request->getHttpHost(),
			$this->equalTo('server:8080')
		);
	}

	public function testGetMethod()
	{
		$this->assertThat($this->object->getMethod(), $this->equalTo('GET'));
	}

	public function testGetMethod_UndefinedMethod()
	{
		$request = new Request(array(), array(), array(), array(
			'REQUEST_METHOD' => 'UNDEFINED',
		));
		$this->assertThat(
			$request->getMethod(),
			$this->equalTo('GET')
		);
	}

	public function testGetBasePath()
	{
		$this->assertThat(
			$this->object->getBasePath(),
			$this->equalTo('/Bachelor-Thesis/Source/Tryout')
		);
	}

	public function testGetBasePath_FromPhpSelf()
	{
		$server = array(
			'REQUEST_URI'     => '/Bachelor-Thesis/Source/Tryout/default/request',
			'SCRIPT_FILENAME' => 'E:/Documents/Domains/localhost/Bachelor-Thesis/Source/Tryout/index.php',
			'PHP_SELF'        => '/Bachelor-Thesis/Source/Tryout/index.php'
		);
		$request = new Request(array(), array(), array(), $server);

		$this->assertThat(
			$request->getBasePath(),
			$this->equalTo('/Bachelor-Thesis/Source/Tryout')
		);
	}

	public function testGetBasePath_WithException()
	{
		$this->setExpectedException('RuntimeException');
		$server = array(
			'REQUEST_URI'     => '/Bachelor-Thesis/Source/Tryout/admin/default/request',
			'SCRIPT_FILENAME' => 'E:/Documents/Domains/localhost/Bachelor-Thesis/Source/Tryout/index.php',
			'PHP_SELF'        => '/Bachelor-Thesis/Source/Tryout/not-valid.php'
		);
		$request = new Request(array(), array(), array(), $server);
		echo $request->getBasePath();
	}

	public function testGetBasePath_IsInsideRequestUri()
	{
		$server = array(
			'REQUEST_URI'     => '/Bachelor-Thesis/Source/Tryout/index.php/',
			'SCRIPT_FILENAME' => 'E:/Documents/Domains/localhost/Bachelor-Thesis/Source/Tryout/index.php',
			'SCRIPT_NAME'     => '/Bachelor-Thesis/Source/Tryout/index.php'
		);
		$request = new Request(array(), array(), array(), $server);
		$this->assertThat(
			$request->getBasePath(),
			$this->equalTo('/Bachelor-Thesis/Source/Tryout/index.php')
		);
	}

	public function testGetBasePath_JustTrimmed()
	{
		$server = array(
			'REQUEST_URI'     => '/Bachelor-Thesis/Source/Admin/',
			'SCRIPT_FILENAME' => 'E:/Documents/Domains/localhost/Bachelor-Thesis/Source/Tryout/index.php',
			'SCRIPT_NAME'        => '/Bachelor-Thesis/Source/Tryout/index.php'
		);
		$request = new Request(array(), array(), array(), $server);
		$this->assertThat(
			$request->getBasePath(),
			$this->equalTo('/Bachelor-Thesis/Source/Tryout/index.php')
		);
	}

	public function testGetBaseUrl()
	{
		$this->assertThat(
			$this->object->getBaseUrl(),
			$this->equalTo(rtrim($this->object->getBasePath(), '/'))
		);
	}

	public function testGetBaseUrl_WithFilenameAtEndOfBasePath()
	{
		$server = array(
			'REQUEST_URI'     => '/Bachelor-Thesis/Source/Tryout/index.php/',
			'SCRIPT_FILENAME' => 'E:/Documents/Domains/localhost/Bachelor-Thesis/Source/Tryout/index.php',
			'SCRIPT_NAME'     => '/Bachelor-Thesis/Source/Tryout/index.php'
		);
		$request = new Request(array(), array(), array(), $server);
		$this->assertThat(
			$request->getBaseUrl(),
			$this->equalTo('/Bachelor-Thesis/Source/Tryout/')
		);
	}

	public function testGetRequestUri()
	{
		$this->assertThat(
			$this->object->getRequestUri(),
			$this->equalTo('/Bachelor-Thesis/Source/Tryout/default/request')
		);
	}

	public function testGetPathInfo()
	{
		$this->assertThat(
			$this->object->getPathInfo(),
			$this->equalTo('/default/request')
		);
	}

	public function testIsXmlHttpRequest()
	{
		$this->assertThat(
			$this->object->isXmlHttpRequest(),
			$this->equalTo(false)
		);

		$request = new Request(array(), array(), array(), array(
			'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'
		));

		$this->assertThat(
			$request->isXmlHttpRequest(),
			$this->equalTo(true)
		);
	}
}
