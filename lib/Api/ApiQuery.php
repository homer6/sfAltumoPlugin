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
* A query object that is used by the ApiGetQuery.
* 
* 
*/
interface ApiQuery{
    
    /**
    * Returns an array of database results.
    * 
    * Each result will be passed to the $modify_results decoractor function as
    * $model (the first paramater).
    * 
    * @return array
    */
    public function find();
    
    
    /**
    * Returns the number of results that will be returned by this query. 
    * 
    * This method should not change the way find() works.
    * 
    * @return integer
    */
    public function count();

    
    /**
     * Sets the maximum number of rows to be retrieved by this query.
     * 
     * @param integer $limit
     * 
     * @return \sfAltumoPlugin\Api\ApiQuery Returns self.
     */
	public function setLimit($limit);
	
	
	/**
	 * Sets the offset of rows to be retrieved by this query.
	 * 
	 * @param integer $offset
	 * 
	 * @return \sfAltumoPlugin\Api\ApiQuery Returns self.
	 */
	public function setOffset($offset);
    
	
}
  
