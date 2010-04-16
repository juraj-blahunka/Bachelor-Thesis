<?php

abstract class DecoratingComponentAdapter extends BaseComponentAdapter
{
	private
		$adapter;

	public function __construct(IComponentAdapter $adapter)
	{
		$this->adapter = $adapter;
	}

	public function getAdapter()
	{
		return $this->adapter;
	}

	public function getClass()
	{
		return $this->getAdapter()->getClass();
	}

	public function getInstance(IDependencyInjectionContainer $container)
	{
		return $this->getAdapter()->getInstance($container);
	}

	public function getKey()
	{
		return $this->getAdapter()->getKey();
	}
}
