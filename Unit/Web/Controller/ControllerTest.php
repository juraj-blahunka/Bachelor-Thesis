<?php
require_once 'PHPUnit/Framework.php';

/**
 * Test class for Controller.
 * Generated by PHPUnit on 2010-04-26 at 21:25:20.
 */
class ControllerTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var Controller
	 */
	protected $object;

	protected function setUp()
	{
		$container = new DependencyInjectionContainer();
		$container->define('request_service')
			->setClass('Request');
		$container->define('response_service')
			->setClass('Response');
		$container->define('renderable_response_service')
			->setClass('RenderableResponse');
		$container->define('RequestBaseUrlStrategy');
		$container->define('RouterFactory');
		$container->define('RouteMatcher');
		$container->define('RoutingRuleCompiler');
		$container->define('UrlCreator');
		$container->define('router_service')
			->setClass('RouterManager');
		$container->define('EventEmitter');
		$container->define('controller_runner_service')
			->setClass('ControllerRunner');
		$container->define('user_service')->setClass('User')
			->addArgument('component', 'ArrayStorage')
			->addArgument('component', 'EventEmitter');

		$this->object = new ControllerStub();
		$this->object->setContainer($container);
	}

	protected function tearDown()
	{
	}

	public function testIsAbstract()
	{
		$reflection = new ReflectionClass('Controller');
		$this->assertThat(
			$reflection->isAbstract(),
			$this->equalTo(true)
		);
	}

	public function testGetRequest()
	{
		$this->assertThat(
			$this->object->getRequest(),
			$this->isInstanceOf('IRequest')
		);
	}

	public function testGetResponse()
	{
		$this->assertThat(
			$this->object->getResponse(),
			$this->isInstanceOf('IResponse')
		);
	}

	public function testGetRenderableResponse()
	{
		$this->assertThat(
			$this->object->getRenderableResponse(),
			$this->isInstanceOf('IRenderableResponse')
		);
	}

	public function testGetRouter()
	{
		$this->assertThat(
			$this->object->getRouter(),
			$this->isInstanceOf('IRouter')
		);
	}

	public function testGetUser()
	{
		$user = $this->object->getUser();
		$this->assertThat(
			$user,
			$this->isInstanceOf('IUser')
		);
	}

	public function testGenerateUrl()
	{
		$this->setExpectedException('RuntimeException');
		$this->object->generateUrl('by-some-name', array('router not configured'));
	}

	public function testRender()
	{
		$params = array('param1' => 'value1');
		$renderable = $this->object->render('some/view', $params);
		$this->assertThat(
			$renderable,
			$this->isInstanceOf('IRenderableResponse')
		);
		$this->assertThat(
			$renderable->getViewName(),
			$this->equalTo('some/view')
		);
		$this->assertThat(
			$renderable->getVariables(),
			$this->equalTo($params)
		);
	}

	public function testForward()
	{
		$this->setExpectedException('NotFoundHttpException');
		$this->object->forward('package', 'controller', 'action', array('params'));
	}

	public function testRedirect_Temporary()
	{
		$response = $this->object->redirect('http://www.example.com/');

		$this->assertThat(
			$response->getHttpStatus()->getCode(),
			$this->equalTo(302)
		);
		$this->assertThat(
			$response->getHeader('Location'),
			$this->equalTo('http://www.example.com/')
		);
	}

	public function testRedirect_Permanent()
	{
		$response = $this->object->redirect('http://www.example.com/', true);

		$this->assertThat(
			$response->getHttpStatus()->getCode(),
			$this->equalTo(301)
		);
		$this->assertThat(
			$response->getHeader('Location'),
			$this->equalTo('http://www.example.com/')
		);
	}
}

class ControllerStub extends Controller {}
