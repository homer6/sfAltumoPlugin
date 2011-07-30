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
 * This class represents the body of a JSON API response.
 * 
 * @author Steve Sperandeo <steve.sperandeo@altumo.com>
 */
class ApiResponseBody{
  
    protected $body = null;
    protected $body_name = 'results';
    protected $pager = null;

    
    /**
    * Constructor for this ApiResponseBody.
    * 
    * @param array $body
    * @param string $body_name
    * @param \sfAltumoPlugin\Api\ApiPager $pager
    * 
    * @return \sfAltumoPlugin\Api\ApiResponseBody
    */
    public function __construct( $body = null, $body_name = 'results', $pager = null ){    
    
        if( is_null($pager) ){
            $pager = new \sfAltumoPlugin\Api\ApiPager();
        }
        
        $this->setPager( $pager );
        
        if( !is_null(body) ){
            $this->setBody( $body );
        }
        $this->setBodyName( $body_name );
        
    }      
    
    
    /**
    * Determines if this ApiResponseBody is paged.
    * 
    * @return boolean
    */
    public function isPaged(){
    
        return $this->getPager()->isPaged();
        
    }
        
    
    /**
    * Setter for the body field on this ApiResponseBody.
    * 
    * @param array $body
    */
    public function setBody( $body ){
    
        $this->body = $body;
        
    }
    
    
    /**
    * Getter for the body field on this ApiResponseBody.
    * 
    * @return array
    */
    public function getBody(){
    
        return $this->body;
        
    }
        
    
    /**
    * Setter for the body_name field on this ApiResponseBody.
    * 
    * @param string $body_name
    */
    public function setBodyName( $body_name ){
    
        $this->body_name = $body_name;
        
    }
    
    
    /**
    * Getter for the body_name field on this ApiResponseBody.
    * 
    * @return string
    */
    public function getBodyName(){
    
        return $this->body_name;
        
    }
    
    
    /**
    * Setter for the pager field on this ApiResponseBody.
    * 
    * @param \sfAltumoPlugin\Api\ApiPager $pager
    */
    public function setPager( $pager ){
    
        $this->pager = $pager;
        
    }
    
        
    /**
    * Getter for the pager field on this ApiResponseBody.
    * 
    * @return \sfAltumoPlugin\Api\ApiPager
    */
    public function getPager(){
    
        return $this->pager;
        
    }
    
    
    /**
    * Gets the response body as a json string.
    * 
    * @param boolean $format //pretty formats the json response 
    * 
    * @return string
    */
    public function getReponseBody( $format = false, $errors = null ){
    
        $response = new \stdClass();
        $body_name = $this->getBodyName();
        
        if( $this->isPaged() ){
            
            $response->has_many_pages = $this->getPager()->hasManyPages();
            $response->total_results = $this->getPager()->getTotalResults();
            $response->page_size = $this->getPager()->getPageSize();
            $response->page = $this->getPager()->getPageNumber();               
        }
        
        if( !empty( $body_name ) ){
            $response->$body_name = $this->getBody();
        } else {
            $response = $this->getBody();
        }
        
        
        if( $response instanceof \stdClass ){
        
            $response->errors = $errors;
        
        }elseif( is_string($response) ){
        
            $string = $response;
            $response = array();
            $response['message'] = $string;
            $response['errors'] = $errors;
        
        }else{            
            $response['errors'] = $errors;
        }

        $json_string = json_encode($response);
        
        if( $format ){
            return \Altumo\Javascript\Json\JsonFormatter::format($json_string);
        }else{
            return $json_string;
        }
        
    }

}