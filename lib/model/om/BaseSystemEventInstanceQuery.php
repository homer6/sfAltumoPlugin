<?php


/**
 * Base class that represents a query for the 'system_event_instance' table.
 *
 * 
 *
 * @method     SystemEventInstanceQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     SystemEventInstanceQuery orderBySystemEventId($order = Criteria::ASC) Order by the system_event_id column
 * @method     SystemEventInstanceQuery orderByMessage($order = Criteria::ASC) Order by the message column
 * @method     SystemEventInstanceQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     SystemEventInstanceQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     SystemEventInstanceQuery groupById() Group by the id column
 * @method     SystemEventInstanceQuery groupBySystemEventId() Group by the system_event_id column
 * @method     SystemEventInstanceQuery groupByMessage() Group by the message column
 * @method     SystemEventInstanceQuery groupByCreatedAt() Group by the created_at column
 * @method     SystemEventInstanceQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     SystemEventInstanceQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     SystemEventInstanceQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     SystemEventInstanceQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     SystemEventInstanceQuery leftJoinSystemEvent($relationAlias = null) Adds a LEFT JOIN clause to the query using the SystemEvent relation
 * @method     SystemEventInstanceQuery rightJoinSystemEvent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SystemEvent relation
 * @method     SystemEventInstanceQuery innerJoinSystemEvent($relationAlias = null) Adds a INNER JOIN clause to the query using the SystemEvent relation
 *
 * @method     SystemEventInstanceQuery leftJoinSystemEventInstanceMessage($relationAlias = null) Adds a LEFT JOIN clause to the query using the SystemEventInstanceMessage relation
 * @method     SystemEventInstanceQuery rightJoinSystemEventInstanceMessage($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SystemEventInstanceMessage relation
 * @method     SystemEventInstanceQuery innerJoinSystemEventInstanceMessage($relationAlias = null) Adds a INNER JOIN clause to the query using the SystemEventInstanceMessage relation
 *
 * @method     SystemEventInstance findOne(PropelPDO $con = null) Return the first SystemEventInstance matching the query
 * @method     SystemEventInstance findOneOrCreate(PropelPDO $con = null) Return the first SystemEventInstance matching the query, or a new SystemEventInstance object populated from the query conditions when no match is found
 *
 * @method     SystemEventInstance findOneById(int $id) Return the first SystemEventInstance filtered by the id column
 * @method     SystemEventInstance findOneBySystemEventId(int $system_event_id) Return the first SystemEventInstance filtered by the system_event_id column
 * @method     SystemEventInstance findOneByMessage(string $message) Return the first SystemEventInstance filtered by the message column
 * @method     SystemEventInstance findOneByCreatedAt(string $created_at) Return the first SystemEventInstance filtered by the created_at column
 * @method     SystemEventInstance findOneByUpdatedAt(string $updated_at) Return the first SystemEventInstance filtered by the updated_at column
 *
 * @method     array findById(int $id) Return SystemEventInstance objects filtered by the id column
 * @method     array findBySystemEventId(int $system_event_id) Return SystemEventInstance objects filtered by the system_event_id column
 * @method     array findByMessage(string $message) Return SystemEventInstance objects filtered by the message column
 * @method     array findByCreatedAt(string $created_at) Return SystemEventInstance objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return SystemEventInstance objects filtered by the updated_at column
 *
 * @package    propel.generator.plugins.sfAltumoPlugin.lib.model.om
 */
abstract class BaseSystemEventInstanceQuery extends ModelCriteria
{

	/**
	 * Initializes internal state of BaseSystemEventInstanceQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'propel', $modelName = 'SystemEventInstance', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new SystemEventInstanceQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    SystemEventInstanceQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof SystemEventInstanceQuery) {
			return $criteria;
		}
		$query = new SystemEventInstanceQuery();
		if (null !== $modelAlias) {
			$query->setModelAlias($modelAlias);
		}
		if ($criteria instanceof Criteria) {
			$query->mergeWith($criteria);
		}
		return $query;
	}

	/**
	 * Find object by primary key
	 * Use instance pooling to avoid a database query if the object exists
	 * <code>
	 * $obj  = $c->findPk(12, $con);
	 * </code>
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    SystemEventInstance|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ((null !== ($obj = SystemEventInstancePeer::getInstanceFromPool((string) $key))) && $this->getFormatter()->isObjectFormatter()) {
			// the object is alredy in the instance pool
			return $obj;
		} else {
			// the object has not been requested yet, or the formatter is not an object formatter
			$criteria = $this->isKeepQuery() ? clone $this : $this;
			$stmt = $criteria
				->filterByPrimaryKey($key)
				->getSelectStatement($con);
			return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
		}
	}

	/**
	 * Find objects by primary key
	 * <code>
	 * $objs = $c->findPks(array(12, 56, 832), $con);
	 * </code>
	 * @param     array $keys Primary keys to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    PropelObjectCollection|array|mixed the list of results, formatted by the current formatter
	 */
	public function findPks($keys, $con = null)
	{
		$criteria = $this->isKeepQuery() ? clone $this : $this;
		return $this
			->filterByPrimaryKeys($keys)
			->find($con);
	}

	/**
	 * Filter the query by primary key
	 *
	 * @param     mixed $key Primary key to use for the query
	 *
	 * @return    SystemEventInstanceQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(SystemEventInstancePeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    SystemEventInstanceQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(SystemEventInstancePeer::ID, $keys, Criteria::IN);
	}

	/**
	 * Filter the query on the id column
	 * 
	 * Example usage:
	 * <code>
	 * $query->filterById(1234); // WHERE id = 1234
	 * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
	 * $query->filterById(array('min' => 12)); // WHERE id > 12
	 * </code>
	 *
	 * @param     mixed $id The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SystemEventInstanceQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(SystemEventInstancePeer::ID, $id, $comparison);
	}

	/**
	 * Filter the query on the system_event_id column
	 * 
	 * Example usage:
	 * <code>
	 * $query->filterBySystemEventId(1234); // WHERE system_event_id = 1234
	 * $query->filterBySystemEventId(array(12, 34)); // WHERE system_event_id IN (12, 34)
	 * $query->filterBySystemEventId(array('min' => 12)); // WHERE system_event_id > 12
	 * </code>
	 *
	 * @see       filterBySystemEvent()
	 *
	 * @param     mixed $systemEventId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SystemEventInstanceQuery The current query, for fluid interface
	 */
	public function filterBySystemEventId($systemEventId = null, $comparison = null)
	{
		if (is_array($systemEventId)) {
			$useMinMax = false;
			if (isset($systemEventId['min'])) {
				$this->addUsingAlias(SystemEventInstancePeer::SYSTEM_EVENT_ID, $systemEventId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($systemEventId['max'])) {
				$this->addUsingAlias(SystemEventInstancePeer::SYSTEM_EVENT_ID, $systemEventId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(SystemEventInstancePeer::SYSTEM_EVENT_ID, $systemEventId, $comparison);
	}

	/**
	 * Filter the query on the message column
	 * 
	 * Example usage:
	 * <code>
	 * $query->filterByMessage('fooValue');   // WHERE message = 'fooValue'
	 * $query->filterByMessage('%fooValue%'); // WHERE message LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $message The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SystemEventInstanceQuery The current query, for fluid interface
	 */
	public function filterByMessage($message = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($message)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $message)) {
				$message = str_replace('*', '%', $message);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(SystemEventInstancePeer::MESSAGE, $message, $comparison);
	}

	/**
	 * Filter the query on the created_at column
	 * 
	 * Example usage:
	 * <code>
	 * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
	 * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
	 * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
	 * </code>
	 *
	 * @param     mixed $createdAt The value to use as filter.
	 *              Values can be integers (unix timestamps), DateTime objects, or strings.
	 *              Empty strings are treated as NULL.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SystemEventInstanceQuery The current query, for fluid interface
	 */
	public function filterByCreatedAt($createdAt = null, $comparison = null)
	{
		if (is_array($createdAt)) {
			$useMinMax = false;
			if (isset($createdAt['min'])) {
				$this->addUsingAlias(SystemEventInstancePeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdAt['max'])) {
				$this->addUsingAlias(SystemEventInstancePeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(SystemEventInstancePeer::CREATED_AT, $createdAt, $comparison);
	}

	/**
	 * Filter the query on the updated_at column
	 * 
	 * Example usage:
	 * <code>
	 * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
	 * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
	 * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
	 * </code>
	 *
	 * @param     mixed $updatedAt The value to use as filter.
	 *              Values can be integers (unix timestamps), DateTime objects, or strings.
	 *              Empty strings are treated as NULL.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SystemEventInstanceQuery The current query, for fluid interface
	 */
	public function filterByUpdatedAt($updatedAt = null, $comparison = null)
	{
		if (is_array($updatedAt)) {
			$useMinMax = false;
			if (isset($updatedAt['min'])) {
				$this->addUsingAlias(SystemEventInstancePeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedAt['max'])) {
				$this->addUsingAlias(SystemEventInstancePeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(SystemEventInstancePeer::UPDATED_AT, $updatedAt, $comparison);
	}

	/**
	 * Filter the query by a related SystemEvent object
	 *
	 * @param     SystemEvent|PropelCollection $systemEvent The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SystemEventInstanceQuery The current query, for fluid interface
	 */
	public function filterBySystemEvent($systemEvent, $comparison = null)
	{
		if ($systemEvent instanceof SystemEvent) {
			return $this
				->addUsingAlias(SystemEventInstancePeer::SYSTEM_EVENT_ID, $systemEvent->getId(), $comparison);
		} elseif ($systemEvent instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(SystemEventInstancePeer::SYSTEM_EVENT_ID, $systemEvent->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterBySystemEvent() only accepts arguments of type SystemEvent or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the SystemEvent relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    SystemEventInstanceQuery The current query, for fluid interface
	 */
	public function joinSystemEvent($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('SystemEvent');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'SystemEvent');
		}
		
		return $this;
	}

	/**
	 * Use the SystemEvent relation SystemEvent object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    SystemEventQuery A secondary query class using the current class as primary query
	 */
	public function useSystemEventQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinSystemEvent($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'SystemEvent', 'SystemEventQuery');
	}

	/**
	 * Filter the query by a related SystemEventInstanceMessage object
	 *
	 * @param     SystemEventInstanceMessage $systemEventInstanceMessage  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SystemEventInstanceQuery The current query, for fluid interface
	 */
	public function filterBySystemEventInstanceMessage($systemEventInstanceMessage, $comparison = null)
	{
		if ($systemEventInstanceMessage instanceof SystemEventInstanceMessage) {
			return $this
				->addUsingAlias(SystemEventInstancePeer::ID, $systemEventInstanceMessage->getSystemEventInstanceId(), $comparison);
		} elseif ($systemEventInstanceMessage instanceof PropelCollection) {
			return $this
				->useSystemEventInstanceMessageQuery()
					->filterByPrimaryKeys($systemEventInstanceMessage->getPrimaryKeys())
				->endUse();
		} else {
			throw new PropelException('filterBySystemEventInstanceMessage() only accepts arguments of type SystemEventInstanceMessage or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the SystemEventInstanceMessage relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    SystemEventInstanceQuery The current query, for fluid interface
	 */
	public function joinSystemEventInstanceMessage($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('SystemEventInstanceMessage');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'SystemEventInstanceMessage');
		}
		
		return $this;
	}

	/**
	 * Use the SystemEventInstanceMessage relation SystemEventInstanceMessage object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    SystemEventInstanceMessageQuery A secondary query class using the current class as primary query
	 */
	public function useSystemEventInstanceMessageQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinSystemEventInstanceMessage($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'SystemEventInstanceMessage', 'SystemEventInstanceMessageQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     SystemEventInstance $systemEventInstance Object to remove from the list of results
	 *
	 * @return    SystemEventInstanceQuery The current query, for fluid interface
	 */
	public function prune($systemEventInstance = null)
	{
		if ($systemEventInstance) {
			$this->addUsingAlias(SystemEventInstancePeer::ID, $systemEventInstance->getId(), Criteria::NOT_EQUAL);
	  }
	  
		return $this;
	}

} // BaseSystemEventInstanceQuery
