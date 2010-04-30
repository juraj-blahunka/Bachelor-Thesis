<?php

/**
 * Converts component data to its resolvable form.
 *
 * @package    BachelorThesis
 * @subpackage DependencyInjection
 */
interface IComponentDefinitionToComponentAdapter
{
	function convert(IComponentDefinition $definition);
}
