<?php

/**
 * Provides always the same instance.
 *
 * @package    BachelorThesis
 * @subpackage DependencyInjection
 */
class SharedComponentAdapter extends DecoratingComponentAdapter
{
	/**
	 * The shared instance.
	 *
	 * @var mixed
	 */
	protected $sharedInstance = null;

	/**
	 * Get shared instance.
	 * If shared instance is null, the decorated Adapter provides
	 * object instance.
	 *
	 * @param IDependencyInjectionContainer $container
	 * @return mixed
	 */
	public function getInstance(IDependencyInjectionContainer $container)
	{
		if (is_null($this->sharedInstance))
		{
			$this->sharedInstance = parent::getInstance($container);
		}
		return $this->sharedInstance;
	}
}
