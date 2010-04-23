<?php
require_once 'PHPUnit/Framework.php';

/**
 * Test class for Response.
 * Generated by PHPUnit on 2010-04-23 at 17:33:32.
 */
class ResponseTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var Response
	 */
	protected $object;

	/**
	 * @var array
	 */
	protected $headers;

	/**
	 * @var array
	 */
	protected $cookies;

	protected function setUp()
	{
		$this->headers = array();
		$this->cookies = array();
		$this->object = new Response($this->headers, $this->cookies);
	}

	protected function tearDown()
	{
	}

	protected function getDispatchedResponse()
	{
		ob_start();
		$this->object->dispatch();
		return ob_get_clean();
	}

	public function testDispatch_OnEmptyResponse()
	{
		$response = $this->getDispatchedResponse();

		$this->assertThat(
			$response,
			$this->equalTo('')
		);
	}

	public function testDispatch_WithContent()
	{
		$content = '<html><head><title>Response sample text</title></head><body><p>Response text</p></body></html>';
		$this->object->setContent($content);
		$this->object->setHeader('Content-Type', 'text/html');
		$response = $this->getDispatchedResponse();

		$this->assertThat(
			$response,
			$this->equalTo($content)
		);
	}

	public function testGetHeaders()
	{
		$this->assertThat(
			$this->object->getHeaders(),
			$this->equalTo($this->headers)
		);
	}

	public function testSetHeader()
	{
		$this->object->setHeader('Location', 'http://www.example.com/');
		$this->assertThat(
			$this->object->getHeader('Location'),
			$this->equalTo('http://www.example.com/')
		);
	}

	public function testGetHeader()
	{
		$this->assertThat(
			$this->object->getHeader('undefined'),
			$this->equalTo(null)
		);

		$this->assertThat(
			$this->object->getHeader('undefined', 'default'),
			$this->equalTo('default')
		);
	}

	public function testSetHeaders()
	{
		$this->object->setHeaders(array(
			'Location'     => 'http://www.example.com/',
			'Content-type' => 'text/html',
		));
		$this->assertThat(
			$this->object->getHeaders(),
			$this->equalTo(array(
				'location'     => 'http://www.example.com/',
				'content-type' => 'text/html',
			))
		);
	}

	public function testAddHeader()
	{
		$this->object->addHeader('Sample', 'value1');
		$this->object->addHeader('sample', 'value2');
		$this->assertThat(
			$this->object->getHeader('Sample'),
			$this->equalTo('value1,value2')
		);
	}

	public function testDeleteHeader()
	{
		$this->object->setHeader('Sample', 'value');
		$this->assertThat(
			$this->object->getHeader('sample'),
			$this->equalTo('value')
		);
		$this->object->deleteHeader('Sample');
		$this->assertThat(
			$this->object->getHeader('sample'),
			$this->equalTo(null)
		);
	}

	public function testDeleteHeader_Undefined()
	{
		// fails silently
		$this->object->deleteHeader('undefined');
	}

	public function testSetContent()
	{
		$this->object->setContent('some new content');
		$this->assertThat(
			$this->object->getContent(),
			$this->equalTo('some new content')
		);
	}

	public function testGetContent()
	{
		$this->assertThat(
			$this->object->getContent(),
			$this->equalTo('')
		);
	}

	public function testWrite()
	{
		$this->object->write('1');
		$this->object->write('2');
		$this->assertThat(
			$this->object->getContent(),
			$this->equalTo('12')
		);
	}

	public function testSetHttpStatusCode()
	{
		$this->object->setHttpStatusCode(404);
		$this->assertThat(
			$this->object->getHttpStatus()->getCode(),
			$this->equalTo(404)
		);
	}

	public function testGetCookies()
	{
		$this->assertThat(
			$this->object->getCookies(),
			$this->equalTo($this->cookies)
		);
	}

	public function testSetCookies()
	{
		$this->object->setCookies(array(
			'user' => array(
				'value'    => 'john doe',
				'expire'   => null,
				'path'     => '/',
				'domain'   => '',
				'secure'   => false,
				'httponly' => false,
			)
		));
		$this->assertThat(
			$this->object->getCookie('user'),
			$this->equalTo(array(
				'name'     => 'user',
				'value'    => 'john doe',
				'expire'   => null,
				'path'     => '/',
				'domain'   => '',
				'secure'   => false,
				'httponly' => false,
			))
		);
	}

	public function testSetCookie()
	{
		$this->object->setCookie('user', 'john doe');
		$this->assertThat(
			$this->object->getCookie('user'),
			$this->equalTo(array(
				'name'     => 'user',
				'value'    => 'john doe',
				'expire'   => null,
				'path'     => '/',
				'domain'   => '',
				'secure'   => false,
				'httponly' => false,
			))
		);
	}

	public function testSetCookie_NumericExpire()
	{
		$this->object->setCookie('user', 'john doe', '12345');
		$this->assertThat(
			$this->object->getCookie('user'),
			$this->equalTo(array(
				'name'     => 'user',
				'value'    => 'john doe',
				'expire'   => 12345,
				'path'     => '/',
				'domain'   => '',
				'secure'   => false,
				'httponly' => false,
			))
		);
	}

	public function testSetCookie_StringExpire()
	{
		$this->object->setCookie('user', 'john doe', 'now');
		$this->assertThat(
			$this->object->getCookie('user'),
			$this->equalTo(array(
				'name'     => 'user',
				'value'    => 'john doe',
				'expire'   => time(),
				'path'     => '/',
				'domain'   => '',
				'secure'   => false,
				'httponly' => false,
			))
		);
	}

	public function testSetCookie_InvalidStringExpire()
	{
		$this->setExpectedException('InvalidArgumentException');
		$this->object->setCookie('user', 'john doe', 'some invalid string');
	}

	public function testDeleteCookie()
	{
		$this->object->deleteCookie('user');
		$cookie = $this->object->getCookie('user');
		$this->assertTrue($cookie['expire'] < time());
	}
}
