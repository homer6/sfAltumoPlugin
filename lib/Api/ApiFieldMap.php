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
* This class represents a mapping between an api request object field and a 
* model field.
* 
* @author Steve Sperandeo <steve.sperandeo@altumo.com>
*/
class ApiFieldMap{
        
    protected $request_field = null;
    protected $required = null;
    protected $description = null;
    protected $model_accessor = null;

    
    /**
    * Constructor for this ApiFieldMap.
    * 
    * @param string $request_field
    * @param boolean $required
    * @param string $description
    * @param string $model_accessor
    * @return \sfAltumoPlugin\Api\ApiFieldMap
    */
    public function __construct( $request_field, $required = true, $description = null, $model_accessor = null ){
    
        if( !is_string($request_field) ){
            throw new \Exception( 'Request field must be a string.' );
        }
        
        $this->setRequestField( $request_field );
        $this->setRequired( $required );
                
        if( !is_null($description) ){
            $this->setDescription( $description );
        }else{
            $description = \Altumo\String\String::formatTitleCase( str_replace('_', ' ', $request_field) );
            $this->setDescription( $description );
        }

        if( !is_null($model_accessor) ){
            $this->setModelAccessor( $model_accessor );
        }else{
            $accessor_suffix = \Altumo\String\String::formatCamelCase( $request_field );
            $this->setModelAccessor( $accessor_suffix );
        }
     
    }
    
    
    /**
    * Setter for the request_field field on this ApiFieldMap.
    * 
    * @param string $request_field
    */
    public function setRequestField( $request_field ){
    
        $this->request_field = $request_field;
        
    }
    
    
    /**
    * Getter for the request_field field on this ApiFieldMap.
    * 
    * @return string
    */
    public function getRequestField(){
    
        return $this->request_field;
        
    }
        
    
    /**
    * Setter for the required field on this ApiFieldMap.
    * 
    * @param boolean $required
    */
    public function setRequired( $required ){
    
        $this->required = $required;
        
    }
    
    
    /**
    * Getter for the required field on this ApiFieldMap.
    * 
    * @return boolean
    */
    public function isRequired(){
    
        return $this->required;
        
    }
        
    
    /**
    * Setter for the description field on this ApiFieldMap.
    * 
    * @param string $description
    */
    public function setDescription( $description ){
    
        $this->description = $description;
        
    }
    
    
    /**
    * Getter for the description field on this ApiFieldMap.
    * 
    * @return string
    */
    public function getDescription(){
    
        return $this->description;
        
    }
        
    
    /**
    * Setter for the model_accessor field on this ApiFieldMap.
    * 
    * @param string $model_accessor
    */
    public function setModelAccessor( $model_accessor ){
    
        $this->model_accessor = $model_accessor;
        
    }
    
    
    /**
    * Getter for the model_accessor field on this ApiFieldMap.
    * 
    * @return string
    */
    public function getModelAccessor(){
    
        return $this->model_accessor;
        
    }
        

    /**
    * Gets this model's member variable values as an array of strings for insertion into a database.
    * The array keys are the table field names.  Table field names should observere the convention.
    * 
    * @return array
    */
    public function getAsArray(){
    
        return array(
            'request_field' => $this->getRequestField(),
            'required' => $this->getRequired(),
            'description' => $this->getDescription(),
            'model_accessor' => $this->getModelAccessor()
        );
    
    }
    
    
}
