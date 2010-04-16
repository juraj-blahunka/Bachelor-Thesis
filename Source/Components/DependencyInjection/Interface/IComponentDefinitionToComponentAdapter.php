<?php

interface IComponentDefinitionToComponentAdapter
{
	function convert($componentKey, IComponentDefinition $definition);
}
