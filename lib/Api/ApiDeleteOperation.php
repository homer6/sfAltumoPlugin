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
* This class represents a API request designed to delete records (models).
* 
* @author Steve Sperandeo <steve.sperandeo@altumo.com>
*/
class ApiDeleteOperation {
        
    protected $request = null;
    protected $response = null;

    /**
    * Constructor for this ApiWriteOperation.
    * 
    * @param \sfAltumoPlugin\Api\ApiRequest $request
    * @param \sfAltumoPlugin\Api\ApiResponse $response
    * @param \ModelCriteria $query              // Base query to use in order to retrieve objects that will be deleted.
    * @param function $delete_object           // the function to call in order to perform the delete operation.
    * 
    * @return \sfAltumoPlugin\Api\ApiGetQuery
    */
    public function __construct( $request, $response, $query, $delete_object = null){    

        if( is_null($delete_object) ){
            $delete_object = function( &$object ){
                return $object->delete();
            };
        }
        
        $response_body = new \sfAltumoPlugin\Api\ApiResponseBody( array(), $body_name, $pager );
        $response->setResponseBody($response_body);
        
        $this->setRequest( $request );
        $this->setResponse( $response );

        $this->setQuery( $query );
        
        $this->setDeleteObject( $delete_object );
     
    }          
      
    /**
    * Setter for the request field on this ApiGetQuery.
    * 
    * @param \sfAltumoPlugin\Api\ApiRequest $request
    */
    public function setRequest( $request ){
    
        $this->request = $request;
        
    }
    
    
    /**
    * Getter for the request field on this ApiGetQuery.
    * 
    * @return \sfAltumoPlugin\Api\ApiRequest
    */
    public function getRequest(){
    
        return $this->request;
        
    }
        

    /**
    * Setter for the response field on this ApiGetQuery.
    * 
    * @param \sfAltumoPlugin\Api\ApiResponse $response
    */
    public function setResponse( $response ){
    
        $this->response = $response;
        
    }
    
    
    /**
    * Getter for the response field on this ApiGetQuery.
    * 
    * @return \sfAltumoPlugin\Api\ApiResponse
    */
    public function getResponse(){
    
        return $this->response;
        
    }
    
    
    /**
    * Setter for the query field on this ApiGetQuery.
    * 
    * @param \ModelCriteria $query
    */
    public function setQuery( $query ){
    
        $this->query = $query;
        
    }
    
    
    /**
    * Getter for the query field on this ApiGetQuery.
    * 
    * @return \ModelCriteria
    */
    public function getQuery(){
    
        return $this->query;
        
    }    
    
    
    /**
    * Setter for the delete_object field on this ApiGetQuery.
    * 
    * @param function $delete_object
    */
    public function setDeleteObject( $delete_object ){
    
        $this->delete_object = $delete_object;
        
    }
    
    
    /**
    * Getter for the delete_object field on this ApiGetQuery.
    * 
    * @return function
    */
    public function getDeleteObject(){
    
        return $this->delete_object;
        
    }

    
    /**
    * Runs the write operation and sets the response body.
    * 
    * ApiResponseBody within the ApiResponse.
    * 
    */    
    public function run(){

        $delete_object = $this->getDeleteObject(); //function
        $query = $this->getQuery();
        $request = $this->getRequest();
        
        // Validate IDs
            try{
                $delete_object_ids = \Altumo\Validation\Arrays::sanitizeCsvArrayPostitiveInteger( $request->getParameter('ids', '') );
            }catch( Exception $e ){
                throw new \Exception( "One of the ids provided was invalid." );
            }
            
            if( empty( $delete_object_ids ) ){
                throw new \Exception( "No valid ids were provided for deletion." );
            }
        
        // Get objects based on $query and filtering by ids
            $query->filterById( $delete_object_ids );
            
            $objects_to_delete = $query->find();
            
            if( $objects_to_delete->isEmpty() ){
                throw new \Exception( "No valid ids were provided for deletion." );
            }
        
        // Delete objects
            $deleted_ids = array();
            foreach( $objects_to_delete as $object_to_delete ){
                $deleted_ids[] = $object_to_delete->getId();
                $delete_object( $object_to_delete );
            }

        $api_response_body = $this->getResponse()->getResponseBody();
        $api_response_body->setBody( array( "deleted" => $deleted_ids ) );
        
    }
    
}