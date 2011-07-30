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
* This class represents a JSON API response.
*
* @author Steve Sperandeo <steve.sperandeo@altumo.com>
*/
class ApiResponse extends \sfWebResponse{
            
    protected $action = null;
    protected $request = null;
    protected $response_body = null;
    protected $errors = array();
    protected $remote_ids = array();
    
    
    /**
    * Class constructor.
    *
    * @see initialize()
    */
    public function __construct( sfEventDispatcher $dispatcher, $options = array() ){
        
        $this->initialize($dispatcher, $options);
        $this->setResponseBody( new \sfAltumoPlugin\Api\ApiResponseBody() );
        
    }
    
    
    /**
    * Makes a JSON or JSONP response, based on the supplied response.
    * This method disables the layout and outputs to the browser.
    * 
    * @param \sfAltumoPlugin\Api\ApiResponseBody $response_body
    * @return sfView::NONE
    */
    public function respond( $response_body = null ){
        
        $request = $this->getRequest();
        $format_response = sfConfig::get('app_api_pretty_format_json_response', false);
        
        //if has errors, add them to the response
            if( $this->hasErrors() ){
                $errors = $this->getAllErrorsAsArray();
            }else{
                $errors = array();
            }
        
        //get the response body (format it if required)
            if( !is_null($response_body) && $response_body instanceof \sfAltumoPlugin\Api\ApiResponseBody ){
                $response = $response_body->getReponseBody( $format_response, $errors );
            }else{
                $response = $this->getResponseBody()->getReponseBody( $format_response, $errors );
            }
            
        //turn off html layout            
            $this->getAction()->setLayout( false );
        
        //output the response as json or jsonp
            $json_method = $request->getParameter('jsonp', null);
            if( is_null($json_method) ){
                $json_method = $request->getParameter('callback', null);
            }
            if( !is_null($json_method) && !empty($json_method) ){
                $this->setContentType('application/javascript');
                if( !empty($response) ){
                    $response_body = $json_method . '( ' . $response . ' )';
                }else{
                    $response_body = $json_method . '( {} )';
                }
            }else{
                $this->setContentType('application/json');
                if( !empty($response) ){
                    $response_body = $response;
                }else{
                    $response_body = '{}';
                }
            }
        
        $this->setContent( $response_body );
        
        return sfView::NONE;
        
    }
        
  
    /**
    * Setter for the action field on this ApiResponse.
    * 
    * @param sfActions $action
    */
    public function setAction( $action ){
    
        $this->action = $action;
        
    }
    
    
    /**
    * Getter for the action field on this ApiResponse.
    * 
    * @return sfActions
    */
    public function getAction(){
    
        if( is_null($this->action) ){
            $this->action = sfContext::getInstance()->getActionStack()->getLastEntry()->getActionInstance();
        }
        
        return $this->action;

    }
        
    
    /**
    * Setter for the request field on this ApiResponse.
    * 
    * @param \sfAltumoPlugin\Api\ApiRequest $request
    */
    public function setRequest( $request ){
    
        $this->request = $request;
        
    }
    
    
    /**
    * Getter for the request field on this ApiResponse.
    * 
    * @return \sfAltumoPlugin\Api\ApiRequest
    */
    public function getRequest(){
    
        if( is_null($this->request) ){
            $this->request = sfContext::getInstance()->getRequest();
        }
        return $this->request;
        
    }
        
    
    /**
    * Setter for the response_body field on this ApiResponse.
    * 
    * @param \sfAltumoPlugin\Api\ApiResponseBody $response_body
    */
    public function setResponseBody( $response_body ){
    
        $this->response_body = $response_body;
        
    }
    
    
    /**
    * Getter for the response_body field on this ApiResponse.
    * 
    * @return \sfAltumoPlugin\Api\ApiResponseBody
    */
    public function getResponseBody(){
    
        return $this->response_body;
        
    }
    
    
    /**
    * Setter for the errors field on this ApiResponse.
    * 
    * @param array $errors
    * @throws \Exception                    // if $errors isn't an array of 
    *                                          \sfAltumoPlugin\Api\ApiError 
    *                                          objects
    */
    public function setErrors( $errors ){
    
        if( !is_array($errors) ){
            throw new \Exception('Errors must be an array of ApiError objects.');
        }
        
        $remote_ids = array();
        foreach( $errors as $error ){
            if( !( $error instanceof \sfAltumoPlugin\Api\ApiError ) ){
                throw new \Exception('Errors must be an array of ApiError objects.');
            }
            $remote_ids[ $error->getRemoteId() ] = '';
        }
        $this->remote_ids = array_merge( $this->remote_ids, $remote_ids );
        $this->errors = $errors;

    }
    
    
    /**
    * Getter for the errors field on this ApiResponse.
    * 
    * @return array
    */
    public function getErrors(){
    
        return $this->errors;
        
    }
    
    
    /**
    * Adds a single error to this ApiResponse.
    * 
    * @param \sfAltumoPlugin\Api\ApiError|string $error  
    *                                       //Either a string (which becomes an 
    *                                         error message) or an ApiError 
    *                                         object.
    * 
    * @param integer $remote_id             //Optional - defaults to null.  Is 
    *                                         ignored if $error is an ApiError
    * 
    * @throws Exception                     // if $error isn't an 
    *                                         \sfAltumoPlugin\Api\ApiError 
    *                                         object or string
    */
    public function addError( $error, $remote_id = null ){
    
        if( !( $error instanceof \sfAltumoPlugin\Api\ApiError ) ){
            if( !is_string($error) ){
                throw new \Exception('Error must be an ApiError object or a string.');
            }else{
                if( !is_null($remote_id) ){
                    try{
                        $remote = \Altumo\Validation\Numerics::assertPositiveInteger($remote_id);
                        $this->remote_ids[$remote_id] = '';
                    }catch( Exception $e ){
                        $remote_id = null;
                    }
                }
                $error = new \sfAltumoPlugin\Api\ApiError( $error, $remote_id );
            }
        }
        $this->errors[] = $error;
        
    }


    /**
    * Adds this exception to this response as an ApiError.
    * 
    * @param \Exception $exception
    */
    public function addException( $exception ){
        
        $this->setStatusCode( '403' ); //forbidden
        $this->addError( new \sfAltumoPlugin\Api\ApiError( $exception->getMessage() ) );
        $this->addError( new \sfAltumoPlugin\Api\ApiError( $exception->getTraceAsString() ) );
        
    }
    
        
    /**
    * Determines if there are errors set for this ApiResponse.
    * 
    * @return boolean
    */
    public function hasErrors(){
        
        if( !empty($this->errors) ){
            return true;
        }else{
            return false;
        }
        
    }
     
        
    /**
    * Determines if there are errors set for this ApiResponse for a specific remote_id.
    * 
    * @param integer $remote_id //primary key of the remote system
    * @throws Exception //if $remote_id is not a positive integer or castable as one
    * @return boolean
    */
    public function hasErrorsForRemoteId( $remote_id ){
        
        $remote_id = \Altumo\Validation\Numerics::assertPositiveInteger($remote_id);
        
        return array_key_exists( $remote_id, $this->remote_ids );
        
    }
        
        
    /**
    * Returns an array of all errors.
    * 
    * @return array
    */
    public function getAllErrorsAsArray(){
        
        $errors = array();
        
        foreach( $this->getErrors() as $error ){
            $errors[] = $error->getAsArray();
        }

        return $errors;
        
    }
    
}
