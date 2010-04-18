<?php

class ApplicationFactory
{
	public function createContainer()
	{
		return new DependencyInjectionContainer();
	}

	public function createContainerBuilder()
	{
		return new ContainerBuilder();
	}
}
