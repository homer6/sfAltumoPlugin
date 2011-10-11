<?php

/*
 * This file is part of the sfAltumoPlugin library.
 *
 * (c) Steve Sperandeo <steve.sperandeo@altumo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace sfAltumoPlugin\Api;



/**
* An incoming symfony 1.4 http request for the API. 
* You will need to change the factories.yml in order to use this.
*
* @author Steve Sperandeo <steve.sperandeo@altumo.com>
*/
class ApiRequest extends \sfWebRequest{
    
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
    * Gets all HTTP request headers.
    * 
    * @return array
    */
    public function getHttpRequestHeaders(){
        
        return $this->getIncomingHttpRequest()->getHeaders();
                
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
    * If the request body requires expansion (see messageBodyRequiresExpansion), the result will
    * be modified to include the ids being requested.
    * 
    * Example: 
    * 
    * PUT /community/posts/1,2,3
    * 
    * {
    *   "author_id": 40,
    *   "message": "Hello there!"
    * }
    * 
    * Will result in an expanded body that looks like:
    * 
    * array(
    *  array(
    *   id => 1,
    *   author_id => 40,
    *   messahe => "Hello there!"
    *  ),
    * 
    *  array(
    *   id => 2,
    *   author_id => 40,
    *   messahe => "Hello there!"
    *  ),
    * 
    *  array(
    *   id => 3,
    *   author_id => 40,
    *   messahe => "Hello there!"
    *  )
    * )
    * 
    * @throws Exception //if message body was empty or could not be parsed.
    * @throws Exception //if duplicate remote_ids are detected.
    * @throws Exception //provided remote_id is not a positive integer
    * @return array
    */
    public function getMessageBody(){
        
        $base_object_modifications = $this->getMessageBodyData();
        
        if( $this->messageBodyRequiresExpansion() ){
            
            // Get the ids that will be used to expand the message body
                try{
                    $object_ids = \Altumo\Validation\Arrays::sanitizeCsvArrayPostitiveInteger( $this->getParameter('ids', '') );
                }catch( Exception $e ){}
                                
            
            // The "id" parameter cannot be batch modified, so it cannot be part of the body in this type of request.
                if( isset( $base_object_modifications['id'] ) ){
                    throw new \Exception( 'When applying the same change to multiple objects, "id" cannot be included as part of the message body.' );
                }

            // $products_array will end up looking as if the request contained multiple objects with IDs to modify.
                $objects = array();
            
                foreach( $object_ids as $object_id ){
                    
                    $objects[] = array_merge( $base_object_modifications, array( 'id' => $object_id ) );
                    
                }
                
            $base_object_modifications = $objects;
            
        }
        
        //this allows a single object to be passed. this allows people that use the api
        //to not have to wrap a single object in an array
        if( !is_array($base_object_modifications[0]) ){
            $base_object_modifications = array( $base_object_modifications );
        }
        
        //get the hightest supplied remote_id; also, check that none of the supplied
        //remote_ids are duplicates
            $remote_id = 0;
            $used_remote_ids = array();
            foreach( $base_object_modifications as $index => $object ){
                
                if( array_key_exists('remote_id', $object) ){
                    
                    $current_remote_id = $object['remote_id'];
                    
                    try{
                        $current_remote_id = \Altumo\Validation\Numerics::assertPositiveInteger($current_remote_id);
                    }catch( \Exception $e ){
                        throw new \Exception('Provided remote_id must be a positive integer.');
                    }
                    
                    //ensure remote_ids are unique
                        if( array_key_exists($current_remote_id, $used_remote_ids) ){
                            throw new \Exception('Duplicate remote_id detected. Please ensure remote_ids are unique.');
                        }else{
                            $used_remote_ids[$current_remote_id] = true;
                        }
                                        
                    //if this remote_id is higher than the current highest, save the higher of the two
                        if( $current_remote_id > $remote_id ){
                            $remote_id = $current_remote_id;
                        }
                }
                
            }
            
        
        //ensure remote_id integers are present; set them if they aren't        
            foreach( $base_object_modifications as $index => &$object ){
                
                if( !array_key_exists('remote_id', $object) ){
                    $remote_id++;
                    $object['remote_id'] = $remote_id;
                }
                
            }
            
            
        return $base_object_modifications;

    }

    
    /**
    * Returns true if:
    * 
    * - This is a PUT request
    * - The "ids" parameter contains at least one integer (can be a csv list)
    * - The decoded body is not an array of arrays
    * 
    * Expansion is required when a PUT request is made to apply the same changes to
    * an array of objects specified by the "ids" parameter.
    *
    */
    protected function messageBodyRequiresExpansion(){
        
        $method = $this->getMethod();
        try{
            $object_ids = \Altumo\Validation\Arrays::sanitizeCsvArrayPostitiveInteger( $this->getParameter('ids', '') );            
        }catch( \Exception $e ){
            $id_field_map = new \sfAltumoPlugin\Api\ApiFieldMap( 'id', null, 'ID' );
            $response = \sfContext::getInstance()->getResponse();
            $response->addError( 'The primary key of the object you\'re trying to update was not set or was not a commas-separated list of integers.', $remote_id, $id_field_map );
            throw $e;
        }
        
        $raw_message_body = $this->getMessageBodyData();
        
        if( $method == self::PUT && !empty($object_ids) ){
            
            // If the body is not an array of arrays, we require expansion
                if( !isset( $raw_message_body[0] ) || !is_array( $raw_message_body[0] ) ){
                    return true;
                }
        }
        
        return false;
    } 
    
    
    /**
    * Gets the Request message body in its deserialized form (json_decoded or xml parsed array).
    *
    * @throws Exception //if message body was empty or could not be parsed.
    * @return array
    */
    public function getMessageBodyData(){
        
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
        
        
        //require SSL, if applicable
            if( \sfConfig::get( 'app_api_require_ssl', true ) ){
                if( $_SERVER["HTTPS"] != 'on' ){
                    throw new \Exception( 'HTTPS is required.' );
                }
            }
        
        
        //authenticate via the API key, if provided
            $api_key = $this->getHttpRequestHeader( 'Authorization', null );
            
            if( !is_null($api_key) ){
                
                if( preg_match('/\\s*Basic\\s+(.*?)\\s*$/im', $api_key, $regs) ){
                    $api_key = $regs[1];
                    
                    $api_user = \ApiUserQuery::create()
                                    ->filterByApiKey($api_key)
                                    ->filterByActive(true)
                                    ->findOne();
                    
                    if( !$api_user ){
                        throw new \Exception('Unknown or inactive API user.');
                    }
                    if( 0 ) $api_user = new \ApiUser();
                    $sf_guard_user = $api_user->getUser()->getsfGuardUser();
                    if( $sf_guard_user->getIsActive() ){
                        \sfContext::getInstance()->getUser()->signIn( $sf_guard_user, false );
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
                    $session = \SessionPeer::retrieveBySessionKey($session_id);
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
                        \sfContext::getInstance()->getUser()->signIn($user->getsfGuardUser(), false);
                    }
                    
                }else{
                    throw new \Exception('Please provide either a valid session or valid API key.'); 
                }
                
            }
            
        //successful authentication
                        
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
