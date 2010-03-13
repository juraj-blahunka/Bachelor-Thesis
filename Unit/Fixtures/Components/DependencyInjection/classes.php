<?php

class ArrayHolder
{
	public
		$holder;

	function __construct(array $input)
	{
		$this->holder = $input;
	}
}

class Cyclic
{
	public function __construct(Cyclic $obj) {}
}

interface IPunchable
{
	function punch();
}

class WeakPunch implements IPunchable
{
	public $wasPunched = false;

	public function punch()
	{
		$this->wasPunched = true;
	}
}

class MediumPunch extends WeakPunch {}

class StrongPunch implements IPunchable
{
	public $wasPunched = false;

	public function punch()
	{
		$this->wasPunched = true;
	}
}

class DependsOnPunchable
{
	public $punchable;

	public function __construct(IPunchable $punchable)
	{
		$this->punchable = $punchable;
		$this->punchable->punch();
	}
}

class DependsOnStrongPunchable
{
	public $punchable;

	public function __construct(StrongPunch $punchable)
	{
		$this->punchable = $punchable;
		$this->punchable->punch();
	}
}

class DecoratedPunchable implements IPunchable
{
	public $delegate;

	public function __construct(IPunchable $delegate)
	{
		$this->delegate = $delegate;
	}

	public function punch()
	{
		$this->delegate->punch();
	}
}

class PunchReceiver
{
	public $calledWithNothing = false;
	public $wasHit = 0;

	public function fromNothing()
	{
		$this->calledWithNothing = true;
	}

	public function fromSomePunch(IPunchable $punchable)
	{
		$punchable->punch();
		$this->wasHit++;
	}
	
	public function fromWeakPunch(WeakPunch $punchable)
	{
		$punchable->punch();
		$this->wasHit++;
	}

	public function fromPunches(WeakPunch $weak, StrongPunch $strong)
	{
		$weak->punch();
		$strong->punch();
		$this->wasHit++;
		$this->wasHit++;
	}
}
