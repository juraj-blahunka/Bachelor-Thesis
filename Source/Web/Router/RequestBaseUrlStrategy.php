<?php

class RequestBaseUrlStrategy implements IUrlStrategy
{
	protected $request;

	public function __construct(IRequest $request)
	{
		$this->request = $request;
	}

	public function getUrl()
	{
		return $this->request->getBaseUrl();
	}
}
