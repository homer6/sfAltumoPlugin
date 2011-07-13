<?php

/*
 * This file is part of the Altumo library.
 *
 * (c) Steve Sperandeo <steve.sperandeo@altumo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Altumo\Api;



/**
* An incoming symfony 1.4 http request for the API. 
* You will need to change the factories.yml in order to use this.
* 
*/
class ApiRequest extends sfWebRequest{
    
    protected $incoming_http_request = null;
    
    
    /**
    * Class constructor.
    *
    * @see initialize()
    */
    public function __construct( sfEventDispatcher $dispatcher, $parameters = array(), $attributes = array(), $options = array() ){
        
        $this->initialize($dispatcher, $parameters, $attributes, $options);
        $this->setIncomingHttpRequest( new \Altumo\Http\IncomingHttpRequest() );
        
    }
    
    
    /**
    * Gets a specified HTTP Request header.
    * Return null or $default, if not found.
    * 
    * @param string $name
    * @param mixed $default
    * @return string
    */
    public function getHttpRequestHeader( $name, $default = null ){
        
        return $this->getIncomingHttpRequest()->getHeader( $name, $default );
                
    }
    
    
    /**
    * Gets the HTTP Request message body.
    * 
    * @return string
    */
    public function getHttpRequestMessageBody(){
        
        return $this->getIncomingHttpRequest()->getMessageBody();
                
    }
    
    
    /**
    * Gets the Request message body in its deserialized form (json_decoded or xml parsed array).
    * 
    * @throws Exception //if message body was empty or could not be parsed.
    * @return array
    */
    public function getMessageBody(){
        
        $message_body = $this->getIncomingHttpRequest()->getMessageBody();
        if( !is_string($message_body) || empty($message_body) ){
            throw new \Exception('Please include a message body.');
        }
        
        $parsed_message_body = json_decode( $message_body, true );
        if( is_null($parsed_message_body) ){
            throw new \Exception('Invalid message body format.');
        }
        
        return $parsed_message_body;
                
    }

    
    /**
    * Authenticates this user and signs them in, if the API key or session is valid.
    * 
    * @param sfActions $action
    * @throws Exception if validation fails.
    */
    public function authenticate(){
        
        //authenticate via the API key, if provided
            $api_key = $this->getHttpRequestHeader( 'Authorization', null );

            if( !is_null($api_key) ){
                
                if( preg_match('/\\s*Basic\\s+(.*?)\\s*$/im', $api_key, $regs) ){
                    $api_key = $regs[1];
                    
                    $api_user = ApiUserQuery::create()
                                    ->filterByApiKey($api_key)
                                    ->filterByActive(true)
                                    ->findOne();
                    
                    if( !$api_user ){
                        throw new \Exception('Unknown or inactive API user.');
                    }
                    if( 0 ) $api_user = new ApiUser();
                    $sf_guard_user = $api_user->getUser()->getsfGuardUser();
                    if( $sf_guard_user->getIsActive() ){
                        sfContext::getInstance()->getUser()->signIn($sf_guard_user, false);
                    }else{
                        throw new \Exception('Unknown or inactive API user.');
                    }
                    
                }else{
                    throw new \Exception('API key format not recognized');
                }
                
            }
        
            
        
        //try to authenticate via the session, if the api key was not provided
            if( is_null($api_key) ){
                              
                $session_id = $this->getCookie( sfConfig::get('altumo_api_session_cookie_name', 'my_session_name'), null );
                if( !is_null($session_id) ){
                    $session = SessionPeer::retrieveBySessionKey($session_id);
                    if( !$session ){
                        throw new \Exception('Invalid session.'); 
                    }
                    $user = $session->getUser();
                    if( !$user ){
                        throw new \Exception('Invalid session.'); 
                    }
                    if( !$user->hasApiUser() ){
                        throw new \Exception('Invalid session.');
                    }
                    $api_user = $user->getApiUser();
                    if( !$api_user->isActive() ){
                        throw new \Exception('Inactive API user.');
                    }else{
                        sfContext::getInstance()->getUser()->signIn($user->getsfGuardUser(), false);
                    }
                    
                }else{
                    throw new \Exception('Please provide either a valid session or valid API key.'); 
                }
                
            }
            
        //successful validation
            
    }
    
    
    
    /**
    * Setter for the incoming_http_request field on this ApiRequest.
    * 
    * @param \Altumo\Http\IncomingHttpRequest $incoming_http_request
    */
    protected function setIncomingHttpRequest( $incoming_http_request ){
    
        $this->incoming_http_request = $incoming_http_request;
        
    }
    
    
    /**
    * Getter for the incoming_http_request field on this ApiRequest.
    * 
    * @return \Altumo\Http\IncomingHttpRequest
    */
    protected function getIncomingHttpRequest(){
    
        return $this->incoming_http_request;
        
    }
    
    
}
