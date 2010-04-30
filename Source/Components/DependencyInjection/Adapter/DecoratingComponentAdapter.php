<?php

/**
 * For adapter decorating purposes.
 *
 * @package    BachelorThesis
 * @subpackage DependencyInjection
 */
abstract class DecoratingComponentAdapter extends BaseComponentAdapter
{
	/**
	 * The decorated adapter.
	 *
	 * @var IComponentAdapter
	 */
	private $adapter;

	/**
	 * Constructor.
	 *
	 * @param IComponentAdapter $adapter
	 */
	public function __construct(IComponentAdapter $adapter)
	{
		$this->adapter = $adapter;
	}

	/**
	 * Get the decorated adapter.
	 *
	 * @return IComponentAdapter
	 */
	public function getAdapter()
	{
		return $this->adapter;
	}

	/**
	 * Get class name of decorated adapter.
	 *
	 * @return string
	 */
	public function getClass()
	{
		return $this->getAdapter()->getClass();
	}

	/**
	 * Get the key of decorated adapter.
	 *
	 * @return string
	 */
	public function getKey()
	{
		return $this->getAdapter()->getKey();
	}

	/**
	 * Get instance of decorated adapter instantiation process.
	 *
	 * @param IDependencyInjectionContainer $container
	 * @return mixed
	 */
	public function getInstance(IDependencyInjectionContainer $container)
	{
		return $this->getAdapter()->getInstance($container);
	}
}
