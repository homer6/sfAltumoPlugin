<?php


/**
 * Base class that represents a query for the 'system_event_instance_message' table.
 *
 * 
 *
 * @method     SystemEventInstanceMessageQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     SystemEventInstanceMessageQuery orderBySystemEventInstanceId($order = Criteria::ASC) Order by the system_event_instance_id column
 * @method     SystemEventInstanceMessageQuery orderBySystemEventSubscriptionId($order = Criteria::ASC) Order by the system_event_subscription_id column
 * @method     SystemEventInstanceMessageQuery orderByReceived($order = Criteria::ASC) Order by the received column
 * @method     SystemEventInstanceMessageQuery orderByReceivedAt($order = Criteria::ASC) Order by the received_at column
 * @method     SystemEventInstanceMessageQuery orderByStatusMessage($order = Criteria::ASC) Order by the status_message column
 * @method     SystemEventInstanceMessageQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     SystemEventInstanceMessageQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     SystemEventInstanceMessageQuery groupById() Group by the id column
 * @method     SystemEventInstanceMessageQuery groupBySystemEventInstanceId() Group by the system_event_instance_id column
 * @method     SystemEventInstanceMessageQuery groupBySystemEventSubscriptionId() Group by the system_event_subscription_id column
 * @method     SystemEventInstanceMessageQuery groupByReceived() Group by the received column
 * @method     SystemEventInstanceMessageQuery groupByReceivedAt() Group by the received_at column
 * @method     SystemEventInstanceMessageQuery groupByStatusMessage() Group by the status_message column
 * @method     SystemEventInstanceMessageQuery groupByCreatedAt() Group by the created_at column
 * @method     SystemEventInstanceMessageQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     SystemEventInstanceMessageQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     SystemEventInstanceMessageQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     SystemEventInstanceMessageQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     SystemEventInstanceMessageQuery leftJoinSystemEventInstance($relationAlias = null) Adds a LEFT JOIN clause to the query using the SystemEventInstance relation
 * @method     SystemEventInstanceMessageQuery rightJoinSystemEventInstance($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SystemEventInstance relation
 * @method     SystemEventInstanceMessageQuery innerJoinSystemEventInstance($relationAlias = null) Adds a INNER JOIN clause to the query using the SystemEventInstance relation
 *
 * @method     SystemEventInstanceMessageQuery leftJoinSystemEventSubscription($relationAlias = null) Adds a LEFT JOIN clause to the query using the SystemEventSubscription relation
 * @method     SystemEventInstanceMessageQuery rightJoinSystemEventSubscription($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SystemEventSubscription relation
 * @method     SystemEventInstanceMessageQuery innerJoinSystemEventSubscription($relationAlias = null) Adds a INNER JOIN clause to the query using the SystemEventSubscription relation
 *
 * @method     SystemEventInstanceMessage findOne(PropelPDO $con = null) Return the first SystemEventInstanceMessage matching the query
 * @method     SystemEventInstanceMessage findOneOrCreate(PropelPDO $con = null) Return the first SystemEventInstanceMessage matching the query, or a new SystemEventInstanceMessage object populated from the query conditions when no match is found
 *
 * @method     SystemEventInstanceMessage findOneById(int $id) Return the first SystemEventInstanceMessage filtered by the id column
 * @method     SystemEventInstanceMessage findOneBySystemEventInstanceId(int $system_event_instance_id) Return the first SystemEventInstanceMessage filtered by the system_event_instance_id column
 * @method     SystemEventInstanceMessage findOneBySystemEventSubscriptionId(int $system_event_subscription_id) Return the first SystemEventInstanceMessage filtered by the system_event_subscription_id column
 * @method     SystemEventInstanceMessage findOneByReceived(boolean $received) Return the first SystemEventInstanceMessage filtered by the received column
 * @method     SystemEventInstanceMessage findOneByReceivedAt(string $received_at) Return the first SystemEventInstanceMessage filtered by the received_at column
 * @method     SystemEventInstanceMessage findOneByStatusMessage(string $status_message) Return the first SystemEventInstanceMessage filtered by the status_message column
 * @method     SystemEventInstanceMessage findOneByCreatedAt(string $created_at) Return the first SystemEventInstanceMessage filtered by the created_at column
 * @method     SystemEventInstanceMessage findOneByUpdatedAt(string $updated_at) Return the first SystemEventInstanceMessage filtered by the updated_at column
 *
 * @method     array findById(int $id) Return SystemEventInstanceMessage objects filtered by the id column
 * @method     array findBySystemEventInstanceId(int $system_event_instance_id) Return SystemEventInstanceMessage objects filtered by the system_event_instance_id column
 * @method     array findBySystemEventSubscriptionId(int $system_event_subscription_id) Return SystemEventInstanceMessage objects filtered by the system_event_subscription_id column
 * @method     array findByReceived(boolean $received) Return SystemEventInstanceMessage objects filtered by the received column
 * @method     array findByReceivedAt(string $received_at) Return SystemEventInstanceMessage objects filtered by the received_at column
 * @method     array findByStatusMessage(string $status_message) Return SystemEventInstanceMessage objects filtered by the status_message column
 * @method     array findByCreatedAt(string $created_at) Return SystemEventInstanceMessage objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return SystemEventInstanceMessage objects filtered by the updated_at column
 *
 * @package    propel.generator.plugins.sfAltumoPlugin.lib.model.om
 */
abstract class BaseSystemEventInstanceMessageQuery extends ModelCriteria
{

	/**
	 * Initializes internal state of BaseSystemEventInstanceMessageQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'propel', $modelName = 'SystemEventInstanceMessage', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new SystemEventInstanceMessageQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    SystemEventInstanceMessageQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof SystemEventInstanceMessageQuery) {
			return $criteria;
		}
		$query = new SystemEventInstanceMessageQuery();
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
	 * @return    SystemEventInstanceMessage|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ((null !== ($obj = SystemEventInstanceMessagePeer::getInstanceFromPool((string) $key))) && $this->getFormatter()->isObjectFormatter()) {
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
	 * @return    SystemEventInstanceMessageQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(SystemEventInstanceMessagePeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    SystemEventInstanceMessageQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(SystemEventInstanceMessagePeer::ID, $keys, Criteria::IN);
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
	 * @return    SystemEventInstanceMessageQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(SystemEventInstanceMessagePeer::ID, $id, $comparison);
	}

	/**
	 * Filter the query on the system_event_instance_id column
	 * 
	 * Example usage:
	 * <code>
	 * $query->filterBySystemEventInstanceId(1234); // WHERE system_event_instance_id = 1234
	 * $query->filterBySystemEventInstanceId(array(12, 34)); // WHERE system_event_instance_id IN (12, 34)
	 * $query->filterBySystemEventInstanceId(array('min' => 12)); // WHERE system_event_instance_id > 12
	 * </code>
	 *
	 * @see       filterBySystemEventInstance()
	 *
	 * @param     mixed $systemEventInstanceId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SystemEventInstanceMessageQuery The current query, for fluid interface
	 */
	public function filterBySystemEventInstanceId($systemEventInstanceId = null, $comparison = null)
	{
		if (is_array($systemEventInstanceId)) {
			$useMinMax = false;
			if (isset($systemEventInstanceId['min'])) {
				$this->addUsingAlias(SystemEventInstanceMessagePeer::SYSTEM_EVENT_INSTANCE_ID, $systemEventInstanceId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($systemEventInstanceId['max'])) {
				$this->addUsingAlias(SystemEventInstanceMessagePeer::SYSTEM_EVENT_INSTANCE_ID, $systemEventInstanceId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(SystemEventInstanceMessagePeer::SYSTEM_EVENT_INSTANCE_ID, $systemEventInstanceId, $comparison);
	}

	/**
	 * Filter the query on the system_event_subscription_id column
	 * 
	 * Example usage:
	 * <code>
	 * $query->filterBySystemEventSubscriptionId(1234); // WHERE system_event_subscription_id = 1234
	 * $query->filterBySystemEventSubscriptionId(array(12, 34)); // WHERE system_event_subscription_id IN (12, 34)
	 * $query->filterBySystemEventSubscriptionId(array('min' => 12)); // WHERE system_event_subscription_id > 12
	 * </code>
	 *
	 * @see       filterBySystemEventSubscription()
	 *
	 * @param     mixed $systemEventSubscriptionId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SystemEventInstanceMessageQuery The current query, for fluid interface
	 */
	public function filterBySystemEventSubscriptionId($systemEventSubscriptionId = null, $comparison = null)
	{
		if (is_array($systemEventSubscriptionId)) {
			$useMinMax = false;
			if (isset($systemEventSubscriptionId['min'])) {
				$this->addUsingAlias(SystemEventInstanceMessagePeer::SYSTEM_EVENT_SUBSCRIPTION_ID, $systemEventSubscriptionId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($systemEventSubscriptionId['max'])) {
				$this->addUsingAlias(SystemEventInstanceMessagePeer::SYSTEM_EVENT_SUBSCRIPTION_ID, $systemEventSubscriptionId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(SystemEventInstanceMessagePeer::SYSTEM_EVENT_SUBSCRIPTION_ID, $systemEventSubscriptionId, $comparison);
	}

	/**
	 * Filter the query on the received column
	 * 
	 * Example usage:
	 * <code>
	 * $query->filterByReceived(true); // WHERE received = true
	 * $query->filterByReceived('yes'); // WHERE received = true
	 * </code>
	 *
	 * @param     boolean|string $received The value to use as filter.
	 *              Non-boolean arguments are converted using the following rules:
	 *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
	 *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
	 *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SystemEventInstanceMessageQuery The current query, for fluid interface
	 */
	public function filterByReceived($received = null, $comparison = null)
	{
		if (is_string($received)) {
			$received = in_array(strtolower($received), array('false', 'off', '-', 'no', 'n', '0')) ? false : true;
		}
		return $this->addUsingAlias(SystemEventInstanceMessagePeer::RECEIVED, $received, $comparison);
	}

	/**
	 * Filter the query on the received_at column
	 * 
	 * Example usage:
	 * <code>
	 * $query->filterByReceivedAt('2011-03-14'); // WHERE received_at = '2011-03-14'
	 * $query->filterByReceivedAt('now'); // WHERE received_at = '2011-03-14'
	 * $query->filterByReceivedAt(array('max' => 'yesterday')); // WHERE received_at > '2011-03-13'
	 * </code>
	 *
	 * @param     mixed $receivedAt The value to use as filter.
	 *              Values can be integers (unix timestamps), DateTime objects, or strings.
	 *              Empty strings are treated as NULL.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SystemEventInstanceMessageQuery The current query, for fluid interface
	 */
	public function filterByReceivedAt($receivedAt = null, $comparison = null)
	{
		if (is_array($receivedAt)) {
			$useMinMax = false;
			if (isset($receivedAt['min'])) {
				$this->addUsingAlias(SystemEventInstanceMessagePeer::RECEIVED_AT, $receivedAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($receivedAt['max'])) {
				$this->addUsingAlias(SystemEventInstanceMessagePeer::RECEIVED_AT, $receivedAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(SystemEventInstanceMessagePeer::RECEIVED_AT, $receivedAt, $comparison);
	}

	/**
	 * Filter the query on the status_message column
	 * 
	 * Example usage:
	 * <code>
	 * $query->filterByStatusMessage('fooValue');   // WHERE status_message = 'fooValue'
	 * $query->filterByStatusMessage('%fooValue%'); // WHERE status_message LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $statusMessage The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SystemEventInstanceMessageQuery The current query, for fluid interface
	 */
	public function filterByStatusMessage($statusMessage = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($statusMessage)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $statusMessage)) {
				$statusMessage = str_replace('*', '%', $statusMessage);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(SystemEventInstanceMessagePeer::STATUS_MESSAGE, $statusMessage, $comparison);
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
	 * @return    SystemEventInstanceMessageQuery The current query, for fluid interface
	 */
	public function filterByCreatedAt($createdAt = null, $comparison = null)
	{
		if (is_array($createdAt)) {
			$useMinMax = false;
			if (isset($createdAt['min'])) {
				$this->addUsingAlias(SystemEventInstanceMessagePeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdAt['max'])) {
				$this->addUsingAlias(SystemEventInstanceMessagePeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(SystemEventInstanceMessagePeer::CREATED_AT, $createdAt, $comparison);
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
	 * @return    SystemEventInstanceMessageQuery The current query, for fluid interface
	 */
	public function filterByUpdatedAt($updatedAt = null, $comparison = null)
	{
		if (is_array($updatedAt)) {
			$useMinMax = false;
			if (isset($updatedAt['min'])) {
				$this->addUsingAlias(SystemEventInstanceMessagePeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedAt['max'])) {
				$this->addUsingAlias(SystemEventInstanceMessagePeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(SystemEventInstanceMessagePeer::UPDATED_AT, $updatedAt, $comparison);
	}

	/**
	 * Filter the query by a related SystemEventInstance object
	 *
	 * @param     SystemEventInstance|PropelCollection $systemEventInstance The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SystemEventInstanceMessageQuery The current query, for fluid interface
	 */
	public function filterBySystemEventInstance($systemEventInstance, $comparison = null)
	{
		if ($systemEventInstance instanceof SystemEventInstance) {
			return $this
				->addUsingAlias(SystemEventInstanceMessagePeer::SYSTEM_EVENT_INSTANCE_ID, $systemEventInstance->getId(), $comparison);
		} elseif ($systemEventInstance instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(SystemEventInstanceMessagePeer::SYSTEM_EVENT_INSTANCE_ID, $systemEventInstance->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterBySystemEventInstance() only accepts arguments of type SystemEventInstance or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the SystemEventInstance relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    SystemEventInstanceMessageQuery The current query, for fluid interface
	 */
	public function joinSystemEventInstance($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('SystemEventInstance');
		
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
			$this->addJoinObject($join, 'SystemEventInstance');
		}
		
		return $this;
	}

	/**
	 * Use the SystemEventInstance relation SystemEventInstance object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    SystemEventInstanceQuery A secondary query class using the current class as primary query
	 */
	public function useSystemEventInstanceQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinSystemEventInstance($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'SystemEventInstance', 'SystemEventInstanceQuery');
	}

	/**
	 * Filter the query by a related SystemEventSubscription object
	 *
	 * @param     SystemEventSubscription|PropelCollection $systemEventSubscription The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SystemEventInstanceMessageQuery The current query, for fluid interface
	 */
	public function filterBySystemEventSubscription($systemEventSubscription, $comparison = null)
	{
		if ($systemEventSubscription instanceof SystemEventSubscription) {
			return $this
				->addUsingAlias(SystemEventInstanceMessagePeer::SYSTEM_EVENT_SUBSCRIPTION_ID, $systemEventSubscription->getId(), $comparison);
		} elseif ($systemEventSubscription instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(SystemEventInstanceMessagePeer::SYSTEM_EVENT_SUBSCRIPTION_ID, $systemEventSubscription->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterBySystemEventSubscription() only accepts arguments of type SystemEventSubscription or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the SystemEventSubscription relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    SystemEventInstanceMessageQuery The current query, for fluid interface
	 */
	public function joinSystemEventSubscription($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('SystemEventSubscription');
		
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
			$this->addJoinObject($join, 'SystemEventSubscription');
		}
		
		return $this;
	}

	/**
	 * Use the SystemEventSubscription relation SystemEventSubscription object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    SystemEventSubscriptionQuery A secondary query class using the current class as primary query
	 */
	public function useSystemEventSubscriptionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinSystemEventSubscription($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'SystemEventSubscription', 'SystemEventSubscriptionQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     SystemEventInstanceMessage $systemEventInstanceMessage Object to remove from the list of results
	 *
	 * @return    SystemEventInstanceMessageQuery The current query, for fluid interface
	 */
	public function prune($systemEventInstanceMessage = null)
	{
		if ($systemEventInstanceMessage) {
			$this->addUsingAlias(SystemEventInstanceMessagePeer::ID, $systemEventInstanceMessage->getId(), Criteria::NOT_EQUAL);
	  }
	  
		return $this;
	}

} // BaseSystemEventInstanceMessageQuery
