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
 * Simplified manual-mode interface for ApiWriteOperation
 *
 */
class ApiManualWriteOperation extends \sfAltumoPlugin\Api\ApiWriteOperation
{
	
	/**
	 * Simplified constructor for manual-mode
	 * 
	 * @param \sfAltumoPlugin\Api\ApiRequest $request
	 * @param \sfAltumoPlugin\Api\ApiResponse $response
	 * @param string $body_name
	 *     //the plural name of the container of the results. 
	 *     eg. system_events
	 * @param function $process_objects_manually( &$response, &$objects ){ 
	 *     //The function to call in order to perform a manual
	 *     write operation. Must return an array of saved Models or stdObjects.
	 *     $objects is an array of stdObjects that is the request body.
	 * @param function $modify_result( &$model, &$result )
	 *     // In Manual mode, $result is an empty \stdClass that you modify.
	 *     Because $result is required to be passed by reference, any 
	 *     modifications to $result will be the result that is returned from the 
	 *     API. Also, the $model is a \stdClass (or can be).
	 * @param bool $update
	 *    //Determines if this ApiWriteOperation is a POST (create) or a PUT 
     *     (update). If true, this is a PUT. Default false (POST).
	 */
	public function __construct( $request, $response, $body_name, $process_objects_manually, $modify_result, $update=false)
	{
		
		parent::__construct(
			$request, 
			$response, 
			$body_name, 
			array(), // field maps 
			$update, // update - default = false
			$modify_result,
			null, // before save
			null, // query
			null, // model name
			self::MODE_MANUAL,
			$process_objects_manually,
			null, // before setters
			null // after save
		);
		
	}
	
}
