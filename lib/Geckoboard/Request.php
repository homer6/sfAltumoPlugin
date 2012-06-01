<?php


namespace Geckoboard;


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
	 * Authenticates user by API key
	 *
	 * @param sfActions $action
	 * 
	 * @return void
	 * 
	 * @throws \Exception if validation fails
	 */
	public function authenticate(){

		//require SSL
		if ( ! $this->isSecure() ) {
			throw new \Exception( "Please make a SSL request" );
		}
		
		//authenticate via the API key, if provided
		$api_key = $this->getHttpRequestHeader( 'Authorization', null );

		// check if authorization string is set
		if( is_null($api_key) ){
			// if no authorization string set,
			
			// fail
			throw new \Exception( "Please provide an API key" );
			
		} else {
			// if authorization string set
			
			// extract api key from authorization string
			if( ! preg_match('/\\s*Basic\\s+(.*?)\\s*$/im', $api_key, $regs) ){
				// if format not recognized,
				
				// fail
				throw new \Exception('Unknown or inactive API user.');
				
			} else {
				// if api key extracted,
				
				$api_key = $regs[1];

				$api_key = base64_decode($api_key);
				if ( ! $api_key) throw new \Exception("Unknown or inactive API user");
				
				$api_key = $this->trimGeckoboardAuthorization($api_key);

				// find user by api key
				$user = \UserQuery::create()
					->filterByApiKey( $api_key )
					->filterByActive( true )
					->findOne()
				;
		
				// if user not found
				if( ! $user ){
					
					// fail
					throw new \Exception('Unknown or inactive API user.');
				}

				// get sf guard user
				$sf_guard_user = $user->getsfGuardUser();
				
				// check if sf guard user is active
				if( $sf_guard_user->getIsActive() ){
					// if sf guard user active,
					
					// sign in
					\sfContext::getInstance()->getUser()->signIn( $sf_guard_user, false );
					
				} else {
					// if sf guard user is not active,
					
					// fail
					throw new \Exception('Unknown or inactive API user.');
				}
			}
		}
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