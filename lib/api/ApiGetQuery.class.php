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
* This class represents a HTTP GET request designed to retrieve records.
* It supports paging.
*
*
*/
class ApiGetQuery{
        
    protected $request = null;
    protected $response = null;
    protected $query = null;
    protected $pager = null;

    
    /**
    * Constructor for this ApiGetQuery.
    * 
    * @param ApiRequest $request
    * @param ApiResponse $response
    * @param ModelCriteria $query
    * @param string $body_name
    * @param function $modify_result
    * 
    * @return ApiGetQuery
    */
    public function __construct( $request, $response, $query, $body_name, $modify_result = null ){    
        
        if( is_null($modify_result) ){
            $modify_result = function( &$model, &$result ){};
        }
        
    
        $pager = new ApiPager( true, $request );
        $response_body = new ApiResponseBody( array(), $body_name, $pager );
        $response->setResponseBody($response_body);
        
        $this->setRequest( $request );
        $this->setResponse( $response );
        $this->setQuery( $query );
        $this->setPager( $pager );
        $this->setModifyResult( $modify_result );
     
    }          
      
      
    /**
    * Setter for the request field on this ApiGetQuery.
    * 
    * @param ApiRequest $request
    */
    public function setRequest( $request ){
    
        $this->request = $request;
        
    }
    
    
    /**
    * Getter for the request field on this ApiGetQuery.
    * 
    * @return ApiRequest
    */
    public function getRequest(){
    
        return $this->request;
        
    }
        

    /**
    * Setter for the response field on this ApiGetQuery.
    * 
    * @param ApiResponse $response
    */
    public function setResponse( $response ){
    
        $this->response = $response;
        
    }
    
    
    /**
    * Getter for the response field on this ApiGetQuery.
    * 
    * @return ApiResponse
    */
    public function getResponse(){
    
        return $this->response;
        
    }
    
    
    /**
    * Setter for the query field on this ApiGetQuery.
    * 
    * @param ModelCriteria $query
    */
    public function setQuery( $query ){
    
        $this->query = $query;
        
    }
    
    
    /**
    * Getter for the query field on this ApiGetQuery.
    * 
    * @return ModelCriteria
    */
    public function getQuery(){
    
        return $this->query;
        
    }
        
    
    /**
    * Setter for the pager field on this ApiGetQuery.
    * 
    * @param ApiPager $pager
    */
    protected function setPager( $pager ){
    
        $this->pager = $pager;
        
    }
    
    
    /**
    * Getter for the pager field on this ApiGetQuery.
    * 
    * @return ApiPager
    */
    protected function getPager(){
    
        return $this->pager;
        
    }
        
    
    /**
    * Setter for the modify_result field on this ApiGetQuery.
    * 
    * @param function $modify_result
    */
    public function setModifyResult( $modify_result ){
    
        $this->modify_result = $modify_result;
        
    }
    
    
    /**
    * Getter for the modify_result field on this ApiGetQuery.
    * 
    * @return function
    */
    public function getModifyResult(){
    
        return $this->modify_result;
        
    }

    
    /**
    * Runs the queries that have been supplied and updates the 
    * ApiResponseBody within the ApiResponse.
    * 
    */    
    public function runQuery(){
        
        $query = $this->getQuery();
        $pager = $this->getPager();
        $modify_result = $this->getModifyResult();
        
        $count_query = clone $query;
        $pager->setTotalResults( $count_query->count() );
        $pager->decorateQuery( $query );
        $limit = $query->getLimit();
        
        $results = array();
        if( $pager->getPageSize() > 0 ){
            $db_results = $query->find();
            foreach( $db_results as $model ){                
                $result_object = $model->toArray(BasePeer::TYPE_FIELDNAME);                
                $modify_result( $model, $result_object );
                $results[] = $result_object;
            }
        }
        
        $api_response_body = $this->getResponse()->getResponseBody();
        $api_response_body->setBody($results);
        
    }
    
    
}
