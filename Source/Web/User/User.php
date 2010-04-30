<?php

/**
 * Abstraction around persistent data, which allows event based data hydration.
 *
 * @package    BachelorThesis
 * @subpackage User
 */
class User implements IUser
{
	protected
		$storage,
		$emitter,
		$properties;

	public function __construct(IStorage $storage, IEventEmitter $emitter)
	{
		$this->storage = $storage;
		$this->emitter = $emitter;

		$this->setProperties($storage->read('user', array()));
		$this->emitUserEvent('user.create');
	}

	public function __destruct()
	{
		$this->emitUserEvent('user.destroy');
		$this->storage->write('user', $this->properties);
	}

	public function setProperties(array $properties)
	{
		$this->properties = $properties;
	}

	public function setProperty($key, $data)
	{
		$this->properties[$key] = $data;
	}

	public function getProperty($key, $default = null)
	{
		return isset($this->properties[$key])
			? $this->properties[$key]
			: $default;
	}

	public function getProperties()
	{
		return $this->properties;
	}

	protected function emitUserEvent($name, array $additional = array())
	{
		$parameters = array_merge(
			array('user' => $this),
			$additional
		);
		$this->emitter->notify(new Event($this, $name, $parameters));
	}
}
