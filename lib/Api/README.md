API Write Operation Sequence
----------------------------

* If object is set up as manual,

	* It checks if $process_objects_manually callback is defined and callable
	
		* If it is not, it throws an exception.
		* If it is, it calls the $process_objects_manually callback.
		* If results of the callback are not an array of saved models or stdObjects, it throws an exception.
		
		* It loops through the results,
			* Calls the $modify_result callback for each result and addes the modified result to $returned_models.
			 
	* Object verifies if model_type is an existing Propel class.
	* Object verifies if the $before_save callback is callable. (It can be used for various integrity and access checks.)
	 
	* Object then loops through $request_objects:
	
		* Checks for 'remote_id' field in $request_object, throws an exception if it's not set. (@todo Why that?)
	
		* If operation is a PUT (= edit):
		
			* It creates a new field map for field 'id'
			* If field 'id' is set in $request_object, it checks that it's a positive int and throws an exception if not. (Because without this field we wouldn't know which row to edit.) 
			* If field 'id' is not set in $request_object, it throws an exception
			* It tries locating a row using the 'id' value and throws an exception if a row is not found
	
		* Otherwise (i.e. if operation is a POST = insert):
			* It creates a new object of class specified in constructor
			* Calls the $before_setters callback on this object
	
		* Iterates through $field_maps,
			* and calls a setter for each entry
	
		* If defined, the $before_save callback is invoked
	
		* If there are no errors for this $request_object,
			* new object is saved
			* and added into $returned_models array
	
		* Object returns $returned_models. 
