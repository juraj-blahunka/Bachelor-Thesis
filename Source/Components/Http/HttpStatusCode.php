<?php

class HttpStatusCode implements IStatusCode
{
	protected
		$code,
		$version;

	public function __construct($code = 200, $version = '1.0')
	{
		$this->setCode($code);
		$this->setProtocolVersion($version);
	}

	public function setCode($code)
	{
		$code = (int) $code;
		if (! isset(self::$statusCodes[$code]))
			throw new InvalidArgumentException("Code '{$code}' supplied is not valid Http status code");
		$this->code = $code;
	}

	public function getCode()
	{
		return $this->code;
	}

	public function getCodeText()
	{
		return self::$statusCodes[$this->code];
	}

	public function setProtocolVersion($version)
	{
		$this->version = $version;
	}

	public function getProtocolVersion()
	{
		return $this->version;
	}

	public function getHeaderText()
	{
		$version = $this->getProtocolVersion();
		$code    = $this->getCode();
		$text    = $this->getCodeText();

		return sprintf('HTTP/%s %s %s', $version, $code, $text);
	}

	/**
	 * Array of status codes with their status text, extracted from
	 * <a href="http://en.wikipedia.org/wiki/List_of_HTTP_status_codes">Status codes</a>
	 *
	 * @var array
	 */
	static public $statusCodes = array(
		'100' => 'Continue',
		'101' => 'Switching Protocols',
		'102' => 'Processing (WebDAV) (RFC 2518)',
		'200' => 'OK',
		'201' => 'Created',
		'202' => 'Accepted',
		'203' => 'Non-Authoritative Information (since HTTP/1.1)',
		'204' => 'No Content',
		'205' => 'Reset Content',
		'206' => 'Partial Content',
		'207' => 'Multi-Status (WebDAV) (RFC 4918)',
		'300' => 'Multiple Choices',
		'301' => 'Moved Permanently',
		'302' => 'Found',
		'303' => 'See Other (since HTTP/1.1)',
		'304' => 'Not Modified',
		'305' => 'Use Proxy (since HTTP/1.1)',
		'306' => 'Switch Proxy',
		'307' => 'Temporary Redirect (since HTTP/1.1)',
		'400' => 'Bad Request',
		'401' => 'Unauthorized',
		'402' => 'Payment Required',
		'403' => 'Forbidden',
		'404' => 'Not Found',
		'405' => 'Method Not Allowed',
		'406' => 'Not Acceptable',
		'407' => 'Proxy Authentication Required[2]',
		'408' => 'Request Timeout',
		'409' => 'Conflict',
		'410' => 'Gone',
		'411' => 'Length Required',
		'412' => 'Precondition Failed',
		'413' => 'Request Entity Too Large',
		'414' => 'Request-URI Too Long',
		'415' => 'Unsupported Media Type',
		'416' => 'Requested Range Not Satisfiable',
		'417' => 'Expectation Failed',
		'418' => 'I____m a teapot',
		'421' => 'There are too many connections from your internet address',
		'422' => 'Unprocessable Entity (WebDAV) (RFC 4918)',
		'423' => 'Locked (WebDAV) (RFC 4918)',
		'424' => 'Failed Dependency (WebDAV) (RFC 4918)',
		'425' => 'Unordered Collection (RFC 3648)',
		'426' => 'Upgrade Required (RFC 2817)',
		'449' => 'Retry With',
		'450' => 'Blocked by Windows Parental Controls',
		'500' => 'Internal Server Error',
		'501' => 'Not Implemented',
		'502' => 'Bad Gateway',
		'503' => 'Service Unavailable',
		'504' => 'Gateway Timeout',
		'505' => 'HTTP Version Not Supported',
		'506' => 'Variant Also Negotiates (RFC 2295)',
		'507' => 'Insufficient Storage (WebDAV) (RFC 4918)[4]',
		'509' => 'Bandwidth Limit Exceeded (Apache bw/limited extension)',
		'510' => 'Not Extended (RFC 2774)',
		'530' => 'User access denied'
	);
}
