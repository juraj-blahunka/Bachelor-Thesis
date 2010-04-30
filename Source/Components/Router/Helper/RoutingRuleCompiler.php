<?php

/**
 * Compiles Rule pattern in regular expression.
 *
 * @package    BachelorThesis
 * @subpackage Router
 */
class RoutingRuleCompiler implements IRoutingRuleCompiler
{
	/**
	 * Relation between name of requirement and its regular expression
	 *
	 * @var IRouterFactory $factory
	 * @var array $patterns
	 */
	protected
		$factory,
		$patterns;

	public function __construct(IRouterFactory $factory, array $patterns = array())
	{
		$this->factory  = $factory;
		$this->patterns = array_merge(array(
			'string' => '[a-zA-Z0-9-_\s]+',
			'int'    => '[0-9]+',
		), $patterns);
	}

	/**
	 * Creates regular expression, which represents requirements and pattern
	 * provided by IRoutingRule
	 *
	 * @param IRoutingRule $rule
	 * @return CompiledRule
	 */
	public function compile(IRoutingRule $rule)
	{
		$regex = $this->escapePattern($rule->getPattern());

		list($variableStrings, $variableNames) =
			$this->findVariablesInPattern($regex);

		$unassigned = array();
		foreach ($variableNames as $name)
			$unassigned[$name] = null;

		$rawRequirements = array_merge($unassigned, $rule->getRequirements());
		$assigned = $this->prepareSubPatterns($rawRequirements);

		for ($i = 0; $i < count($variableStrings); $i++)
		{
			$regex = str_replace(
				$variableStrings[$i],
				$assigned[$variableNames[$i]],
				$regex
			);
		}

		$regex = '/^'.$regex.'$/';

		return $this->factory->createCompiledRule($rule, $regex);
	}

	/**
	 * Match variables names and strings in url pattern.
	 * Variables in pattern are marked up with {} like {controller} or {action}
	 *
	 * @param string $url
	 * @return array
	 */
	private function findVariablesInPattern($url)
	{
		$findVariablesPattern = '/{([a-zA-Z0-9-_]+)}/';
		preg_match_all($findVariablesPattern, $url, $matches);

		return $matches;
	}

	/**
	 * Takes requirement array as parameter, transforms requirement names
	 * to their relevant regular expression representation
	 *
	 * array(
	 *     'month'=>'int'
	 * )
	 *
	 * becomes (will be transformed to)
	 *
	 * array(
	 *     'month'=>'(?<month>[0-9]+)'
	 * )
	 *
	 * @param array $requirements
	 * @return array
	 */
	private function prepareSubPatterns(array $requirements)
	{
		$defaultRequirement = 'string';
		foreach ($requirements as $name => $requirement)
		{
			if ($requirement === null)
				$requirement = $defaultRequirement;

			if (! isset($this->patterns[$requirement]))
				throw new InvalidArgumentException('Requirement "'.$requirement.'" for route "'.$name.'" not found in patterns');

			$pattern = $this->patterns[$requirement];
			$requirements[$name] =
				'(?<'.$name.'>'.$pattern.')';
		}
		return $requirements;
	}

	private function escapePattern($pattern)
	{
		return str_replace(
			array('/',  '.'),
			array('\/', '\.'),
			$pattern
		);
	}
}
