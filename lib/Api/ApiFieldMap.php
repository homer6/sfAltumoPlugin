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
    protected $description = null;
    protected $model_accessor = null;
    protected $flags = 0;

    //If you add a flag here, the next number must be double the last (eg. 4)
    const FLAG_REQUIRED = 1;
    const FLAG_READONLY = 2;
    
    
    /**
    * Constructor for this ApiFieldMap.
    * 
    * @param string $request_field
    * @param integer $flags                  //a combination of flags of this field
    * @param string $description
    * @param string $model_accessor
    * @return \sfAltumoPlugin\Api\ApiFieldMap
    */
    public function __construct( $request_field, $flags = null, $description = null, $model_accessor = null ){
    
        if( !is_string($request_field) ){
            throw new \Exception( 'Request field must be a string.' );
        }
        
        $this->setRequestField( $request_field );
        
        if( !is_null($flags) ){
            $this->setFlags( $flags );
        }
                
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
    
        $this->setFlag( self::FLAG_REQUIRED, \Altumo\Validation\Booleans::assertLooseBoolean($required) );
        
    }
    
    
    /**
    * Getter for the required field on this ApiFieldMap.
    * 
    * @return boolean
    */
    public function isRequired(){
    
        return $this->testFlag( self::FLAG_REQUIRED );
        
    }
        
    
    /**
    * Setter for the read_only field on this \sfAltumoPlugin\Api\ApiFieldMap.
    * 
    * @param boolean $read_only
    */
    public function setReadOnly( $read_only ){
    
        $this->setFlag( self::FLAG_READONLY, \Altumo\Validation\Booleans::assertLooseBoolean($read_only) );
        
    }
    
    
    /**
    * Getter for the read_only field on this \sfAltumoPlugin\Api\ApiFieldMap.
    * 
    * @return boolean
    */
    public function isReadOnly(){
    
        return $this->testFlag( self::FLAG_READONLY );
        
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
    * Setter for the flags field on this \sfAltumoPlugin\Api\ApiFieldMap.
    * 
    * @param integer $flags
    */
    public function setFlags( $flags ){
    
        $flags = \Altumo\Validation\Numerics::assertUnsignedInteger( $flags );
        
        $this->flags = $flags;
                        
        $this->validateFlags();
        
    }
    
    
    /**
    * Getter for the flags field on this \sfAltumoPlugin\Api\ApiFieldMap.
    * 
    * @return integer
    */
    public function getFlags(){
    
        return $this->flags;
        
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
    
    
    /**
    * Determines if this flag is set within $this->flags.
    * 
    * @param integer $flag                  //one of the FLAG constants.
    * 
    * @return boolean
    */
    protected function testFlag( $flag ){

        if( ($flag & $this->flags) == $flag ){
            return true;
        }else{
            return false;
        }
        
    }
    
    
    /**
    * Determines if this flag is set within $this->flags.
    * 
    * @param integer $flag                  //one of the FLAG constants.
    * @param boolean $enable                //whether to enable or disable
    * 
    * @return boolean
    */
    protected function setFlag( $flag, $enable ){
        
        if( $enable ){
            $this->flags = $flag | $this->flags;
        }else{
            $this->flags = ~$flag & $this->flags;
        }
        
        $this->validateFlags();
        
    }
    
    
    /**
    * Validates that the flags make sense.
    * 
    * @throws \Exception                    //if they don't
    */
    protected function validateFlags(){
        
        if( $this->isReadOnly() && $this->isRequired() ){
            throw new \Exception( 'You can\'t have a field that is both required and readonly.' );
        }
                
    }
    
    
    
}
