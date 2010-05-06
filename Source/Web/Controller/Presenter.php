<?php

/**
 * A link between controller and view.
 *
 * @package    BachelorThesis
 * @subpackage Controller
 */
abstract class Presenter
{
	/**
	 * Every item in $data array will be bound to properties of Presenter.
	 *
	 * Item accessor will be used (if defined), either direct property
	 * assignment will be executed.
	 *
	 * @param array $data
	 * @return Presenter
	 * @throws RuntimeException when either accessor or property are not defined
	 */
	public function bind(array $data)
	{
		foreach ($data as $key => $value)
		{
			$this->bindOne($key, $value);
		}

		return $this;
	}

	/**
	 * Binds a model to a property.
	 *
	 * Uses accessor if defined, else will directly assign the model.
	 *
	 * @param string $property
	 * @param mixed $model
	 * @return Presenter
	 * @throws RuntimeException when either accessor or property are not defined
	 */
	public function bindOne($property, $model)
	{
		$accessor = 'set'.ucfirst($property);
		if (method_exists($this, $accessor))
			call_user_func(array($this, $accessor), $model);
		else if (property_exists($this, $property))
			$this->$property = $model;
		else
			throw new RuntimeException("No accessor or property defined with '{$property}' name");

		return $this;
	}
}
