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
* This class represents an error in an API method call. There may be many 
* errors for a given API method call.
*
* @author Steve Sperandeo <steve.sperandeo@altumo.com>
*/
class ApiError{
        
    protected $remote_id = null;
    protected $message = null;


    /**
    * Constructor for this ApiError.
    * 
    * @param string $message
    * @param integer $remote_id //optional - defaults to null
    * 
    * @return \sfAltumoPlugin\Api\ApiError
    */
    public function __construct( $message, $remote_id = null ){    
    
        $this->setRemoteId( $remote_id );
        $this->setMessage( $message );
     
    }        
    
    
    /**
    * Setter for the remote_id field on this ApiError.
    * 
    * @param integer $remote_id
    */
    public function setRemoteId( $remote_id ){
    
        $this->remote_id = $remote_id;
        
    }
    
    
    /**
    * Getter for the remote_id field on this ApiError.
    * 
    * @return integer
    */
    public function getRemoteId(){
    
        return $this->remote_id;
        
    }
        
    
    /**
    * Setter for the message field on this ApiError.
    * 
    * @param string $message
    */
    public function setMessage( $message ){
    
        $this->message = $message;
        
    }
    
    
    /**
    * Getter for the message field on this ApiError.
    * 
    * @return string
    */
    public function getMessage(){
    
        return $this->message;
        
    }
        

    /**
    * Gets this model's member variable values as an array of strings for insertion into a database.
    * The array keys are the table field names.  Table field names should observere the convention.
    * 
    * @return array
    */
    public function getAsArray(){
    
        return array(
            'remote_id' => $this->getRemoteId(),
            'message' => $this->getMessage()
        );
    
    }    
    
    
}