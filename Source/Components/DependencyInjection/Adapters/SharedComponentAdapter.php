<?php

class SharedComponentAdapter extends DecoratingComponentAdapter
{
	protected
		$sharedInstance = null;

	public function getInstance(IDependencyInjectionContainer $container)
	{
		if (is_null($this->sharedInstance))
		{
			$this->sharedInstance = parent::getInstance($container);
		}
		return $this->sharedInstance;
	}
}