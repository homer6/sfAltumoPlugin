<?php

/*
 * This file is part of the sfAltumoPlugin library.
 *
 * (c) Steve Sperandeo <steve.sperandeo@altumo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace sfAltumoPlugin\Query;


/**
* This class represents [.. WIP ..]
* 
* @author karlvonbahnhof <https://github.com/karlvonbahnhof>
*/
abstract class RawQuery { 

	/**
	 * @var integer
	 */
	protected $limit = null;
	
	
	/**
	 * @var integer
	 */
	protected $offset = 0;

	
	
	/**
	 * Sets the limit for retrieved data
	 * 
	 * @param integer $limit
	 * 
	 * @return RawQuery Returns itself
	 */
	public function setLimit( $limit ){

		$this->limit = \Altumo\Validation\Numerics::assertInteger( $limit );
		
		return $this;
	}
	
	
	/**
	 * Sets the offset for retrieved data
	 * 
	 * @param integer $offset
	 * 
	 * @return RawQuery Returns itself
	 */
	public function setOffset( $offset ){
		$this->offset = \Altumo\Validation\Numerics::assertInteger( $offset );
		
		return $this;
	}
	
	
	/**
	 * Returns the limit for retrieved data
	 * 
	 * @return integer
	 */
	public function getLimit(){
        
		return $this->limit;
        
	}
	
	
	/**
	 * Returns the offset for retrieved data 
	 * 
	 * @return integer
	 */
	public function getOffset(){
        
		return $this->offset;
        
	}
	

	/**
	 * Returns the total number of rows
	 * 
	 * @return int
	 */
	abstract public function count();

	
	/**
	 * Returns dataset with offset and limit applied
	 * 
	 * @return array
	 */
	abstract public function find();

	
	/**
	 * Runs a select query with optional bindings and returns data
	 *  
	 * @param string $query
     *      // what does this query look like?
     * 
	 * @param array $bindings
     *      // what does this array look like?
     * 
	 * @param integer $return_type
     *      // what are the options?
	 * 
	 * @return array
     *      // what's the array keyed like? what are the values?
	 */	
	protected function runSelectQuery( $query, $bindings = array(), $return_type = PDO::FETCH_ASSOC ){

        // validate query
            $query = \Altumo\Validation\Strings::assertNonEmptyString( $query );
        
        // ensure $bindings is an array
            if( !is_array($bindings) ){
                throw new \Exception( '$bindings is expected to be an Array' );
            }
        
        // validate $return_type if possible
            // ....
        
        
		$connection = $this->getConnection();
		
		$statement = $connection->prepare( $query );
	
		$statement->execute( $bindings );
		
		$rows = $statement->fetchAll( $return_type );
		
		return $rows;
        
	}
		
	
    /**
    * Describe me
    * 
    * @return PDO
    */
	protected function getConnection(){

		return Propel::getConnection();

	}


    /**
    * Describe me
    * 
    * @param array $statements
    *   // ....
    * 
    * @return string
    *   // ....
    */
	protected function concatenateStatementsWithAnd( $statements ){
        
        // ensure $statements is an array
            if( !is_array($statements) ){
                throw new \Exception( '$statements is expected to be an Array' );
            }
        
		if( count($statements) == 0 ) return '1';
		
		return join( ' AND ', $statements );
        
	}
	
}
