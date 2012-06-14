<?php


namespace sfAltumoPlugin\Geckoboard;


class Request extends \sfWebRequest {

	
	/**
	 * @var \Altumo\Http\IncomingHttpRequest
	 */
	protected $incoming_http_request = null;
	
	
	/**
	 * Class constructor.
	 *
	 * @see initialize()
	 */
	public function __construct( \sfEventDispatcher $dispatcher, $parameters = array(), $attributes = array(), $options = array() ){
	
		$this->initialize( $dispatcher, $parameters, $attributes, $options );
		
		$this->setIncomingHttpRequest( new \Altumo\Http\IncomingHttpRequest() );
	
	}
	
	
	/**
	 * Setter for the incoming_http_request field
	 *
	 * @param \Altumo\Http\IncomingHttpRequest $incoming_http_request
	 */
	protected function setIncomingHttpRequest( $incoming_http_request ){
	
		$this->incoming_http_request = $incoming_http_request;
	
	}
	
	
	/**
	 * Gets a specified HTTP Request header.
	 * Return null or $default, if not found.
	 *
	 * @param string $name
	 * @param mixed $default
	 * 
	 * @return string
	 */
	protected function getHttpRequestHeader( $name, $default = null ){
	
		return $this->getIncomingHttpRequest()->getHeader( $name, $default );
	
	}
	
	
	/**
	 * Getter for the incoming_http_request field on this ApiRequest.
	 *
	 * @return \Altumo\Http\IncomingHttpRequest
	 */
	protected function getIncomingHttpRequest(){
	
		return $this->incoming_http_request;
	
	}
	
	
	/**
	 * Geckoboard will send input as [base64 encoded api key]:X,
	 * this method returns the api key part
	 * 
	 * @param string $value
	 * 
	 * @return string
	 */
	protected function trimGeckoboardAuthorization( $value )
	{
		return str_replace(':X', '', $value);
	}

}
