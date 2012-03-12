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
* This class represents an API request designed to write records (models).
* 
* It is used for PUT and POST methods.
* 
* It effectively has two "modes", or ways to use it:
* 
*   1) Automatic: To write an API method that updates a Propel model cleanly, 
*      you can provide a field_map and use the $before_save callback
*      to make minor tweaks, if necessary. This mode relies on exceptions being
*      thrown within the model accessors for error messages and validation.
*      You will then have to build the $result with the modify_result callback.
*      If an exception is thrown during the creation/update of an object,
*      that one object will get rolled back (but not the entire set of objects).
*  
*   2) Manual: To write an API method that doesn't correspond with a Propel 
*      model, you can provide the $process_objects_manually callback to do
*      all of the work.
* 
* @author Steve Sperandeo <steve.sperandeo@altumo.com>
*/
class ApiWriteOperation {
        
    protected $request = null;
    protected $response = null;
    
    //automatic mode variables
    protected $model_name = null;
    protected $field_maps = null;
    protected $before_save = null;
    protected $after_save = null;
    protected $query = null;
    protected $before_setters = null;
    
    //manual mode variables
    protected $process_objects_manually = null;


    const MODE_AUTOMATIC = 0;
    const MODE_MANUAL = 1;
    
    /**
    * Constructor for this ApiWriteOperation.
    * 
    * 
    * @param \sfAltumoPlugin\Api\ApiRequest $request
    * 
    * @param \sfAltumoPlugin\Api\ApiResponse $response
    * 
    * @param string $body_name
    *   //the plural name of the container of the results. 
    *     eg. system_events
    * 
    * @param function $modify_result( &$model, &$result )
    *   //Used in both Automatic and Manual Modes. The function that turns the 
    *     array of model objects into an array of \stdClass objects (the final 
    *     result). Must return an array of \stdClass objects.
    *       In Manual mode, $result is an empty \stdClass that you modify.
    *     Because $result is required to be passed by reference, any 
    *     modifications to $result will be the result that is returned from the 
    *     API. Also, the $model is a \stdClass (or can be).
    *       In Automatic mode, $result will have to be constructed with
    *     the modify_result callback. You should be able to share the 
    *     modify_result callback with GET, POST and PUT. Also, in auto, the 
    *     $model object is guaranteed to be a model object.
    * 
    * @param function $before_save( &$model, &$request_object, &$response, 
    *     $remote_id ) 
    *   //Used in Automatic Mode. The function to call that is invoked just
    *     just before the model is saved (after all of the accessor have been
    *     called). You can attached an Error to the response with this remote_id
    *     to prevent this model from being saved and output an appropriate error
    *     message.
    * 
    * @param \ModelCriteria $query
    *   //The model Query that is used to look up an existing record for
    *     PUT operations. If null, it will just use the default one from the
    *     model.
    * 
    * @param string $model_name
    *   //Used in Automatic Mode. The model's class name. If null, it tries to
    *     guess based off of the $body_name.  
    *      eg. 
    *           system_events
    *      becomes 
    *           SystemEvent
    * 
    * @param array $field_maps
    *   //Used in Automatic Mode. An array of ApiFieldMap objects that describes 
    *     each of the fields' relationship with a the $model_name model. 
    *     Defaults to a required field. If null, description and setter_method 
    *     are generated according to the naming convention, unless overridden.
    *      eg.
    *      //legend:  [ field_key, required, description, setter_method ]
    *      $field_maps = array(
    *          new \sfAltumoPlugin\Api\ApiFieldMap( 'system_event' ),
    *          new \sfAltumoPlugin\Api\ApiFieldMap( 'remote_url', true, 
    *               'Remote URL' ),
    *          new \sfAltumoPlugin\Api\ApiFieldMap( 'enabled', false, null, 
    *               'Enabled' )  //will become setEnabled and getEnabled
    *      );
    * 
    * @param boolean 
    *   //Determines if this ApiWriteOperation is a POST (create) or a PUT 
    *     (update). If true, this is a PUT. Default false (POST).
    * 
    * @param integer $mode
    *   //Whether this is \sfAltumoPlugin\Api\ApiWriteOperation::MODE_AUTOMATIC
    *     or \sfAltumoPlugin\Api\ApiWriteOperation::MODE_AUTOMATIC. Defaults to 
    *     automatic.
    * 
    * @param function $process_objects_manually( &$response, &$objects ){ 
    *   //Used in Manual Mode. The function to call in order to perform a manual
    *     write operation. Must return an array of saved Models or stdObjects.
    *     $objects is an array of stdObjects that is the request body.
    * 
    * @param function $before_setters( &$model, &$request_object, &$response )
    *   //Used in Automatic Mode. The function to call that is invoked just
    *     after the model is created (before all of the accessor have been
    *     called). This will only be invoked if this is a create (POST).    
    * 
    * @param function $after_save( $new_model, $request_object, $response, $remote_id, $update )
    *   //Used in Automatic Mode. The function to call that is invoked just after the model is saved.
    *     Any exception thrown will cause the entire operation to be rolled-back.
    * 
    * @throws \Exception
    *   //if $field_maps is not an array
    * 
    * @return \sfAltumoPlugin\Api\ApiWriteOperation
    */
    public function __construct( $request, $response, $body_name, $field_maps=array(), $update = false, $modify_result = null, $before_save = null, $query = null, $model_name = null, $mode = self::MODE_AUTOMATIC, $process_objects_manually = null, $before_setters = null, $after_save = null ){    
        
        //request
            $this->setRequest( $request );
        
        //response and body name
            $response_body = new \sfAltumoPlugin\Api\ApiResponseBody( array(), $body_name );
            $response->setResponseBody( $response_body );
            $this->setResponse( $response );

        //field maps
			if( ! is_array($field_maps) ){
				throw new \Exception('Field maps must be an array of ApiFieldMap objects.');
			}        
	        $this->setFieldMaps( $field_maps );
            
        //update
            $this->setUpdate( $update );
        
        //modify result callback
            if( is_callable($modify_result) ){
                $this->setModifyResult( $modify_result );
            }
            
        //before save
            if( is_callable($before_save) ){
                $this->setBeforeSave( $before_save );
            }
            
        // after save
        	if( is_callable($after_save) ){
        		$this->setAfterSave( $after_save );
        	}
            
        //query
            $this->setQuery( $query );
                
        //model name
            if( is_null($model_name) ){
                $plural_model = \Altumo\String\String::formatCamelCase($body_name);
                $this->setModelName( substr( $plural_model, 0, strlen($plural_model) - 1 ) );
            }else{
                $this->setModelName( $model_name );
            }        

        //mode
            $this->setMode( $mode );
        
        //manually process objects
            if( is_callable($process_objects_manually) ){
                $this->setProcessObjectsManually( $process_objects_manually );
            }
            
        //before save
            if( is_callable($before_setters) ){
                $this->setBeforeSetters($before_setters);
            }
     
    }
      

    /**
    * Setter for the request field on this ApiWriteOperation.
    * 
    * @param \sfAltumoPlugin\Api\ApiRequest $request
    */
    public function setRequest( $request ){
    
        $this->request = $request;
        
    }
    
    
    /**
    * Getter for the request field on this ApiWriteOperation.
    * 
    * @return \sfAltumoPlugin\Api\ApiRequest
    */
    public function getRequest(){
    
        return $this->request;
        
    }
        
    
    /**
    * Setter for the response field on this ApiWriteOperation.
    * 
    * @param \sfAltumoPlugin\Api\ApiResponse $response
    */
    public function setResponse( $response ){
    
        $this->response = $response;
        
    }
    
    
    /**
    * Getter for the response field on this ApiWriteOperation.
    * 
    * @return \sfAltumoPlugin\Api\ApiResponse
    */
    public function getResponse(){
    
        return $this->response;
        
    }

    
    /**
    * Setter for the field_maps field on this ApiWriteOperation.
    * 
    * @param array $field_maps
    */
    public function setFieldMaps( $field_maps ){
    
        $this->field_maps = $field_maps;
        
    }
    
    
    /**
    * Getter for the field_maps field on this ApiWriteOperation.
    * 
    * @return array
    */
    public function getFieldMaps(){
    
        return $this->field_maps;
        
    }
        
    
    /**
    * Setter for the update field on this ApiWriteOperation.
    * 
    * @param boolean $update
    * @throws \Exception //if $update cannot be interpreted as a boolean
    */
    public function setUpdate( $update ){    
        
        $this->update = \Altumo\Validation\Booleans::assertLooseBoolean($update);
        
    }
    
    
    /**
    * Determines if this ApiWriteOperation is a POST (create) or a PUT (update).
    * If true, this is a PUT.
    * 
    * @return boolean
    */
    public function isUpdate(){
    
        return $this->update;
        
    }
                    
    
    /**
    * Setter for the modify_result field on this ApiWriteOperation.
    * 
    * @param function( &$model, &$result ) $modify_result
    */
    public function setModifyResult( $modify_result ){
    
        $this->modify_result = $modify_result;
        
    }
    
    
    /**
    * Getter for the modify_result field on this ApiWriteOperation.
    * 
    * @return function( &$model, &$result )
    */
    public function getModifyResult(){
    
        return $this->modify_result;
        
    }
        
    
    /**
    * Setter for the before_save field on this ApiWriteOperation.
    * 
    * @param function( &$model ) $before_save
    */
    public function setBeforeSave( $before_save ){
    
        $this->before_save = $before_save;
        
    }
    
    
    /**
    * Getter for the before_save field on this ApiWriteOperation.
    * 
    * @return function( &$model )
    */
    public function getBeforeSave(){
    
        return $this->before_save;
        
    }
        

    /**
    * Setter for the after_save field on this ApiWriteOperation.
    * 
    * @param function( &$model ) $after_save
    */
    public function setAfterSave( $after_save ){
    
        $this->after_save = $after_save;
        
    }
    
    
    /**
     * Getter for the after_save field on this ApiWriteOperation
     */
    public function getAfterSave(){
    	
    	return $this->after_save;

    }
    
    
    /**
    * Setter for the query field on this ApiWriteOperation.
    * 
    * @param \ModelCriteria $query
    */
    public function setQuery( $query ){
    
        $this->query = $query;
        
    }
    
    
    /**
    * Getter for the query field on this ApiWriteOperation.
    * 
    * @throws \Exception                    //if model query class is not found
    * @return \ModelCriteria
    */
    public function getQuery(){
    
        if( is_null($this->query) ){
            $query_class = $this->getModelName() . 'Query';
            if( !class_exists($query_class) ){
                throw new \Exception( 'Invalid Query class: .' );
            }
            $this->query = $query_class::create();
        }
        
        return $this->query;
        
    }   
    
    
    /**
    * Setter for the model_name field on this ApiWriteOperation.
    * Adds a global namespace if no namespace is specified; therefore, the 
    * provided namespace MUST be absolute and not relative.
    * 
    * @param string $model_name
    */
    public function setModelName( $model_name ){
    
        //if no namespace specified, mark as global
        if( substr($model_name, 0, 1) !== '\\' ){
            $model_name = '\\' . $model_name;
        }
        $this->model_name = $model_name;
        
    }
    
    
    /**
    * Getter for the model_name field on this ApiWriteOperation.
    * 
    * @return string
    */
    public function getModelName(){
    
        return $this->model_name;
        
    }
        
    
    /**
    * Setter for the mode field on this ApiWriteOperation.
    * 
    * @param integer $mode
    */
    public function setMode( $mode ){
    
        $this->mode = $mode;
        
    }
    
    
    /**
    * Getter for the mode field on this ApiWriteOperation.
    * 
    * @return integer
    */
    public function getMode(){
    
        return $this->mode;
        
    }
    
    /**
    * Determines if this is in manual mode.
    * 
    * @return boolean
    */
    public function isManual(){
        
        return ( $this->getMode() === self::MODE_MANUAL );
        
    }
    
    /**
    * Determines if this is in automatic mode.
    * 
    * @return boolean
    */
    public function isAutomatic(){
        
        return ( $this->getMode() === self::MODE_AUTOMATIC );
        
    }
        
    
    /**
    * Setter for the process_objects_manually field on this ApiWriteOperation.
    * 
    * @param function( &$response, &$objects ) $process_objects_manually
    */
    public function setProcessObjectsManually( $process_objects_manually ){
    
        $this->process_objects_manually = $process_objects_manually;
        
    }
    
    
    /**
    * Getter for the process_objects_manually field on this ApiWriteOperation.
    * 
    * @return function( &$response, &$objects )
    */
    public function getProcessObjectsManually(){
    
        return $this->process_objects_manually;
        
    }
    
    
    /**
    * Setter for the before_setters field on this ApiWriteOperation.
    * 
    * @param function( &$model, &$request_object, &$response ) $before_setters
    */
    public function setBeforeSetters( $before_setters ){
    
        $this->before_setters = $before_setters;
        
    }
    
    
    /**
    * Getter for the before_setters field on this ApiWriteOperation.
    * 
    * @return function( &$model, &$request_object, &$response )
    */
    public function getBeforeSetters(){
    
        return $this->before_setters;
        
    }
                 

    /**
    * Calls the ProcessObject once, then calls ModifyResult on each of the 
    * results in the array returned from ProcessObject (which modify each
    * of the result objects). It then sets the Response body to that modified
    * results.
    * 
    * @throws \Exception                    //if process_objects() doesn't return
    *                                         an array;
    * 
    */
    public function run(){
                
        $modify_result = $this->getModifyResult();
        $request_message_body = $this->getRequest()->getMessageBody();
        $response = $this->getResponse();
        
        if( $this->isAutomatic() ){
            
            //Execute write operation
                $write_operation_results = $this->saveGenericModels( $request_message_body );
                if( !is_array($write_operation_results) ){
                    throw new \Exception( 'Write operations result must be an array.' );
                }
                
            //Extract the results
                $results = array();
                foreach( $write_operation_results as $model ){
                    
                    if( !($model instanceof \BaseObject) ){
                        throw new \Exception( 'Process objects must return an array of Model objects.' );
                    }
                    $result_object = array();

                    if( is_callable($modify_result) ){
                        $modify_result( $model, $result_object );
                    }
                    $results[] = $result_object;
                    
                }
                
            
        }else if( $this->isManual() ){
            
            //Execute the manual write operation
                $process_objects_manually = $this->getProcessObjectsManually();
                if( is_callable($process_objects_manually) ){
                    $write_operation_results = $process_objects_manually( $response, $request_message_body );                    
                    if( !is_array($write_operation_results) ){
                        throw new \Exception( 'Process objects manually callback must return an array of saved Models or stdObjects.' );
                    }
                }else{
                    throw new \Exception( 'If ApiWriteOperation is in manual mode, process objects callback must be defined.' );
                }

            //Extract the results
                $results = array();
                foreach( $write_operation_results as $model ){
                    if( !($model instanceof \stdClass) && !($model instanceof \BaseObject) ){
                        throw new \Exception( 'Process objects must return an array of \stdClass objects or \BaseObject.' );
                    }
                    $result_object = array();
                    if( is_callable($modify_result) ){
                        $modify_result( $model, $result_object );
                    }
                    $results[] = $result_object;
                }
            
        }else{
            
            throw new \Exception( 'Unknown mode.' );
            
        }

        //write the results to the response body
            $api_response_body = $response->getResponseBody();
            $api_response_body->setBody( $results );
        
    }
    
    
    /**
    * Uses the field map to take the fields that are in each of the 
    * $request_objects and save them as individual $model_type models.
    * 
    * @param array $request_objects 
    *   //an array of objects with new values that should be written
    * 
    * @throws \Exception
    *   //if $model_type is not a Propel-1.5 model type.
    * 
    * @return array 
    *   //an array of $type objects (models)
    */
    protected function saveGenericModels( $request_objects ){
                
        $field_maps = $this->getFieldMaps();
        $response = $this->getResponse();
        $model_type = $this->getModelName();
        $before_save = $this->getBeforeSave();
        $after_save = $this->getAfterSave();
        $update = $this->isUpdate();
        
        //validate $request_objects
            if( !is_array($request_objects) ){
                throw new \Exception('Request objects must be an array.');
            }
        
        //validate $field_map
            if( !is_array($field_maps) ){
                throw new \Exception('Field maps must be an array.');
            }
        
        //validate the $model_type and get the peer and query classes.
            if( !in_array('BaseObject', class_parents($model_type)) ){
                throw new \Exception('Model Type must be an existing propel model class.');
            }
            
            $query_class = $model_type . 'Query';
            if( !class_exists($query_class) ){
                throw new \Exception('Invalid Query class.');
            }
            
            $peer_class = $model_type . 'Peer';
            if( !class_exists($peer_class) ){
                throw new \Exception('Invalid Peer class.');
            }
        
        //validate $before_save
            if( !is_null($before_save) ){
                if( !is_callable($before_save) ){
                    throw new \Exception('If provided, the before_save callback must be a function.');
                }
            }

		//validate $after_save
            if( !is_null($after_save) ){
                if( !is_callable($after_save) ){
                    throw new \Exception('If provided, the after_save callback must be a function.');
                }
            }
            
                
        $returned_models = array();
        
        
        foreach( $request_objects as $request_object ){

            try{
                
                $connection = \Propel::getConnection( $peer_class::DATABASE_NAME, \Propel::CONNECTION_WRITE );
                $connection->beginTransaction();
                    
                    //validate the remote_id (it should always be set, this is just a sanity check)
                        if( is_array($request_object) && array_key_exists( 'remote_id', $request_object ) ){                            
                            $remote_id = $request_object['remote_id'];                            
                        }else{
                            throw new \Exception( 'Remote ID not found in record.' );
                        }
                    
                    //if this is an update (PUT) write operation, as opposed to a create (POST)
                        if( $update ){
                            
                            $id_field_map = new \sfAltumoPlugin\Api\ApiFieldMap( 'id', null, 'ID' );
                            
                            //get the object by id
                                if( array_key_exists( 'id', $request_object ) ){
                                    
                                    $id = $request_object['id'];                                    
                                    
                                    try{
                                        $id = \Altumo\Validation\Numerics::assertPositiveInteger( $id );                                
                                    }catch( Exception $e ){
                                        $response->addError( 'An id was passed that is not a positive integer.', $remote_id, $id_field_map );
                                        $connection->rollBack();
                                        continue;
                                    }

                                    $current_query = clone $this->query;
                                    
                                    $new_model = $current_query
                                            ->filterById( $id )
                                            ->findOne();
                                    
                                    if( !$new_model ){
                                        $response->addError( 'Object with the id: ' . $id . ' could not be found.', $remote_id, $id_field_map );
                                        $connection->rollBack();
                                        continue;
                                    }
                                    
                                }else{
                                    $response->addError( 'There was a record sent that doesn\'t have an id.', $remote_id, $id_field_map );
                                    $connection->rollBack();
                                    continue;
                                }
                                
                        }else{
                            $new_model = new $model_type();
                            
                            //invoke the $before_settors callback
                                $before_setters = $this->getBeforeSetters();
                                if( is_callable($before_setters) ){
                                    $before_setters( $new_model, $request_object, $response );
                                }
                            
                        }

                    //try to apply the values in the $request_object to the $model_type accessors      
                        foreach( $field_maps as $field_map ){
                            
                            //if( 0 ) $field_map = new \sfAltumoPlugin\Api\ApiFieldMap();
                            
                            $field_key = $field_map->getRequestField();
                            if( array_key_exists( $field_key, $request_object ) ){
                                
                                $method = 'set' . $field_map->getModelAccessor();
                                if( !method_exists($new_model, $method) ){                                    
                                    throw new \Exception( 'Accessor: ' . $method . ' does not exist.' );
                                }
                                
                                try{
                                    //call the setter, it should throw an exception if the value is invalid
                                    call_user_func_array( array($new_model, $method), array( $request_object[$field_key] ) );
                                }catch( \Exception $e ){
                                    //catch the exception and add it to the error list if the field contain an invalid value
                                    $response->addError( $field_map->getDescription() . ': '. $e->getMessage(), $remote_id, $field_map );
                                }
                                
                            }else{
                                
                                if( $field_map->isRequired() ){
                                    if( !$update ){
                                        $response->addError( $field_map->getDescription() . ' is required.', $remote_id, $field_map );
                                    }
                                }
                                
                            }
                            
                        }
                    
                        
                    //invoke the $before_save callback
                        if( !is_null($before_save) && is_callable($before_save) ){
                            $before_save( $new_model, $request_object, $response, $remote_id, $update );
                        }
                        
                    //if there were errors with this record, don't save it
                        if( $response->hasErrorsForRemoteId($remote_id) ){
                            $connection->rollBack();
                        }else{
                            try{
                                $new_model->save();
                                
                                //invoke the $after_save callback
                        			if( !is_null($after_save) && is_callable($after_save) ){
                            			$after_save( $new_model, $request_object, $response, $remote_id, $update );
                        			}
                                
                                //intentionally commit after $after_save for atomicity
                                    $connection->commit();

                                $returned_models[] = $new_model;
                                
                            }catch( \Exception $e ){
                                
                                // exceptions thrown from $after_save will roll back the entire request.
                                    $connection->rollBack();
                                 
                                $response->addError( $e->getMessage(), $remote_id );
                                
                            }
                        }
                
            }catch( \Exception $e ){

                $connection->rollBack();
		$response->addError( $e->getMessage(), $remote_id );

            }
        
        }

        return $returned_models;
        
    }
    
    
    /**
    * This method calls the setters on the provided $model with the values from 
    * $request_object, according to the $field_maps.
    * 
    * @param boolean $update
    *   //PUT (update) request if true, POST (create) if false
    * 
    * @param \sfAltumoPlugin\Api\ApiResponse $response
    *   //the response that will contain the errors
    * 
    * @param \BaseObject $model
    *   //the model the is having its accessors called
    * 
    * @param array $field_maps
    *   //the field maps from $request_object array keys to $model accessors
    * 
    * @param mixed $request_object
    *   //the array that contains the fields the will be placed into the model
    * 
    * @param integer $remote_id
    *   //the remote_id of the record being referenced. If this is null, the
    *     $request_object must contain it
    * 
    * @throws \Exception
    *   //if the accessor method doesn't exist
    * 
    * @throws \Exception                    
    *   //if the accessor method doesn't exist
    * 
    * @throws \Exception                    
    *   //if the field is required and couldn't be found in $request_object
    * 
    * @throws \Exception
    *   //if $remote_id is not an integer
    * 
    * @return array 
    *   //an array of $type objects (models)
    */
    static public function callObjectSetters( $update, $response, $model, &$field_maps, &$request_object, $remote_id = null ){

        
        foreach( $field_maps as $field_map ){
            
            //validate the accessor
                $accessor_suffix = $field_map->getModelAccessor();
                $setter_method = 'set' . $accessor_suffix;
                $getter_method = 'get' . $accessor_suffix;
                if( !method_exists($model, $setter_method) ){
                    continue; //skip it if method doesn't exist
                    throw new \Exception('Accessor method does not exist: ' . $setter_method );
                }
                
            //validate the remote_id
                if( is_null($remote_id) ){
                    if( !array_key_exists('remote_id', $request_object) ){
                        throw new \Exception('The request_object must have a remote_id' );
                    }else{
                        $remote_id = $request_object['remote_id'];
                    }
                }else{
                    $remote_id = \Altumo\Validation\Numerics::assertPositiveInteger($remote_id);
                }                

            //validate that the field exists in the request
            //don't worry about the field not being there if this is an update
                $field_key = $field_map->getRequestField();
                if( !array_key_exists($field_key, $request_object) ){
                    if( !$update ){
                        if( $field_map->isRequired() ){
                            $response->addError( 'Field does not exist: ' . $field_map->getDescription(), $remote_id, $field_map );
                        }
                    }
                    continue;
                }
                
            //invoke the setter and attach error, if there is one
                try{
                    call_user_func_array( array($model, $setter_method), array($request_object[$field_key]) );                    
                }catch( \Exception $e ){
                    $response->addError( $e->getMessage(), $remote_id, $field_map );
                }
            
        }
        
    }
    
    
}



