<?php
/*
* This file is part of the sfAltumoPlugin library.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace sfAltumoPlugin\Query;

abstract class RawQuery
{ 

	
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
	 * @return BaseRawQuery Returns itself
	 */
	public function setLimit( $limit )
	{
		$this->limit = $limit;
		
		return $this;
	}
	
	
	/**
	 * Sets the offset for retrieved data
	 * 
	 * @param integer $offset
	 * 
	 * @return BaseRawQuery Returns itself
	 */
	public function setOffset( $offset )
	{
		$this->offset = $offset;
		
		return $this;
	}
	
	
	/**
	 * Returns the limit for retrieved data
	 * 
	 * @return integer
	 */
	public function getLimit()
	{
		return $this->limit;
	}
	
	
	/**
	 * Returns the offset for retrieved data 
	 * 
	 * @return integer
	 */
	public function getOffset()
	{
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
	 * @param array $bindings
	 * @param integer $return_type
	 * 
	 * @return array
	 */	
	protected function runSelectQuery( $query, $bindings = array(), $return_type = PDO::FETCH_ASSOC )
	{
		$connection = $this->getConnection();
		
		$statement = $connection->prepare($query);
	
		$statement->execute($bindings);
		
		$rows = $statement->fetchAll($return_type);
		
		return $rows;
	}
		
	
	/**
	 * @return PDO
	 */
	protected function getConnection()
	{
		return Propel::getConnection();  
	}

	

	/**
	 * @param array $statements
	 * 
	 * @return string
	 */
	protected function concatenateStatementsWithAnd( $statements )
	{
		if ( count($statements) == 0 ) return '1';
		
		return join(' AND ', $statements);
	}
	
}
