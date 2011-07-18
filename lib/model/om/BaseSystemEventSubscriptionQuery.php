<?php


/**
 * Base class that represents a query for the 'system_event_subscription' table.
 *
 * 
 *
 * @method     SystemEventSubscriptionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     SystemEventSubscriptionQuery orderBySystemEventId($order = Criteria::ASC) Order by the system_event_id column
 * @method     SystemEventSubscriptionQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     SystemEventSubscriptionQuery orderByRemoteUrl($order = Criteria::ASC) Order by the remote_url column
 * @method     SystemEventSubscriptionQuery orderByEnabled($order = Criteria::ASC) Order by the enabled column
 * @method     SystemEventSubscriptionQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     SystemEventSubscriptionQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     SystemEventSubscriptionQuery groupById() Group by the id column
 * @method     SystemEventSubscriptionQuery groupBySystemEventId() Group by the system_event_id column
 * @method     SystemEventSubscriptionQuery groupByUserId() Group by the user_id column
 * @method     SystemEventSubscriptionQuery groupByRemoteUrl() Group by the remote_url column
 * @method     SystemEventSubscriptionQuery groupByEnabled() Group by the enabled column
 * @method     SystemEventSubscriptionQuery groupByCreatedAt() Group by the created_at column
 * @method     SystemEventSubscriptionQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     SystemEventSubscriptionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     SystemEventSubscriptionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     SystemEventSubscriptionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     SystemEventSubscriptionQuery leftJoinSystemEvent($relationAlias = null) Adds a LEFT JOIN clause to the query using the SystemEvent relation
 * @method     SystemEventSubscriptionQuery rightJoinSystemEvent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SystemEvent relation
 * @method     SystemEventSubscriptionQuery innerJoinSystemEvent($relationAlias = null) Adds a INNER JOIN clause to the query using the SystemEvent relation
 *
 * @method     SystemEventSubscriptionQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     SystemEventSubscriptionQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     SystemEventSubscriptionQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     SystemEventSubscriptionQuery leftJoinSystemEventInstanceMessage($relationAlias = null) Adds a LEFT JOIN clause to the query using the SystemEventInstanceMessage relation
 * @method     SystemEventSubscriptionQuery rightJoinSystemEventInstanceMessage($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SystemEventInstanceMessage relation
 * @method     SystemEventSubscriptionQuery innerJoinSystemEventInstanceMessage($relationAlias = null) Adds a INNER JOIN clause to the query using the SystemEventInstanceMessage relation
 *
 * @method     SystemEventSubscription findOne(PropelPDO $con = null) Return the first SystemEventSubscription matching the query
 * @method     SystemEventSubscription findOneOrCreate(PropelPDO $con = null) Return the first SystemEventSubscription matching the query, or a new SystemEventSubscription object populated from the query conditions when no match is found
 *
 * @method     SystemEventSubscription findOneById(int $id) Return the first SystemEventSubscription filtered by the id column
 * @method     SystemEventSubscription findOneBySystemEventId(int $system_event_id) Return the first SystemEventSubscription filtered by the system_event_id column
 * @method     SystemEventSubscription findOneByUserId(int $user_id) Return the first SystemEventSubscription filtered by the user_id column
 * @method     SystemEventSubscription findOneByRemoteUrl(string $remote_url) Return the first SystemEventSubscription filtered by the remote_url column
 * @method     SystemEventSubscription findOneByEnabled(boolean $enabled) Return the first SystemEventSubscription filtered by the enabled column
 * @method     SystemEventSubscription findOneByCreatedAt(string $created_at) Return the first SystemEventSubscription filtered by the created_at column
 * @method     SystemEventSubscription findOneByUpdatedAt(string $updated_at) Return the first SystemEventSubscription filtered by the updated_at column
 *
 * @method     array findById(int $id) Return SystemEventSubscription objects filtered by the id column
 * @method     array findBySystemEventId(int $system_event_id) Return SystemEventSubscription objects filtered by the system_event_id column
 * @method     array findByUserId(int $user_id) Return SystemEventSubscription objects filtered by the user_id column
 * @method     array findByRemoteUrl(string $remote_url) Return SystemEventSubscription objects filtered by the remote_url column
 * @method     array findByEnabled(boolean $enabled) Return SystemEventSubscription objects filtered by the enabled column
 * @method     array findByCreatedAt(string $created_at) Return SystemEventSubscription objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return SystemEventSubscription objects filtered by the updated_at column
 *
 * @package    propel.generator.plugins.sfAltumoPlugin.lib.model.om
 */
abstract class BaseSystemEventSubscriptionQuery extends ModelCriteria
{

	/**
	 * Initializes internal state of BaseSystemEventSubscriptionQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'propel', $modelName = 'SystemEventSubscription', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new SystemEventSubscriptionQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    SystemEventSubscriptionQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof SystemEventSubscriptionQuery) {
			return $criteria;
		}
		$query = new SystemEventSubscriptionQuery();
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
	 * @return    SystemEventSubscription|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ((null !== ($obj = SystemEventSubscriptionPeer::getInstanceFromPool((string) $key))) && $this->getFormatter()->isObjectFormatter()) {
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
	 * @return    SystemEventSubscriptionQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(SystemEventSubscriptionPeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    SystemEventSubscriptionQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(SystemEventSubscriptionPeer::ID, $keys, Criteria::IN);
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
	 * @return    SystemEventSubscriptionQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(SystemEventSubscriptionPeer::ID, $id, $comparison);
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
	 * @return    SystemEventSubscriptionQuery The current query, for fluid interface
	 */
	public function filterBySystemEventId($systemEventId = null, $comparison = null)
	{
		if (is_array($systemEventId)) {
			$useMinMax = false;
			if (isset($systemEventId['min'])) {
				$this->addUsingAlias(SystemEventSubscriptionPeer::SYSTEM_EVENT_ID, $systemEventId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($systemEventId['max'])) {
				$this->addUsingAlias(SystemEventSubscriptionPeer::SYSTEM_EVENT_ID, $systemEventId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(SystemEventSubscriptionPeer::SYSTEM_EVENT_ID, $systemEventId, $comparison);
	}

	/**
	 * Filter the query on the user_id column
	 * 
	 * Example usage:
	 * <code>
	 * $query->filterByUserId(1234); // WHERE user_id = 1234
	 * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
	 * $query->filterByUserId(array('min' => 12)); // WHERE user_id > 12
	 * </code>
	 *
	 * @see       filterByUser()
	 *
	 * @param     mixed $userId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SystemEventSubscriptionQuery The current query, for fluid interface
	 */
	public function filterByUserId($userId = null, $comparison = null)
	{
		if (is_array($userId)) {
			$useMinMax = false;
			if (isset($userId['min'])) {
				$this->addUsingAlias(SystemEventSubscriptionPeer::USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($userId['max'])) {
				$this->addUsingAlias(SystemEventSubscriptionPeer::USER_ID, $userId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(SystemEventSubscriptionPeer::USER_ID, $userId, $comparison);
	}

	/**
	 * Filter the query on the remote_url column
	 * 
	 * Example usage:
	 * <code>
	 * $query->filterByRemoteUrl('fooValue');   // WHERE remote_url = 'fooValue'
	 * $query->filterByRemoteUrl('%fooValue%'); // WHERE remote_url LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $remoteUrl The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SystemEventSubscriptionQuery The current query, for fluid interface
	 */
	public function filterByRemoteUrl($remoteUrl = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($remoteUrl)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $remoteUrl)) {
				$remoteUrl = str_replace('*', '%', $remoteUrl);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(SystemEventSubscriptionPeer::REMOTE_URL, $remoteUrl, $comparison);
	}

	/**
	 * Filter the query on the enabled column
	 * 
	 * Example usage:
	 * <code>
	 * $query->filterByEnabled(true); // WHERE enabled = true
	 * $query->filterByEnabled('yes'); // WHERE enabled = true
	 * </code>
	 *
	 * @param     boolean|string $enabled The value to use as filter.
	 *              Non-boolean arguments are converted using the following rules:
	 *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
	 *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
	 *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SystemEventSubscriptionQuery The current query, for fluid interface
	 */
	public function filterByEnabled($enabled = null, $comparison = null)
	{
		if (is_string($enabled)) {
			$enabled = in_array(strtolower($enabled), array('false', 'off', '-', 'no', 'n', '0')) ? false : true;
		}
		return $this->addUsingAlias(SystemEventSubscriptionPeer::ENABLED, $enabled, $comparison);
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
	 * @return    SystemEventSubscriptionQuery The current query, for fluid interface
	 */
	public function filterByCreatedAt($createdAt = null, $comparison = null)
	{
		if (is_array($createdAt)) {
			$useMinMax = false;
			if (isset($createdAt['min'])) {
				$this->addUsingAlias(SystemEventSubscriptionPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdAt['max'])) {
				$this->addUsingAlias(SystemEventSubscriptionPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(SystemEventSubscriptionPeer::CREATED_AT, $createdAt, $comparison);
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
	 * @return    SystemEventSubscriptionQuery The current query, for fluid interface
	 */
	public function filterByUpdatedAt($updatedAt = null, $comparison = null)
	{
		if (is_array($updatedAt)) {
			$useMinMax = false;
			if (isset($updatedAt['min'])) {
				$this->addUsingAlias(SystemEventSubscriptionPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedAt['max'])) {
				$this->addUsingAlias(SystemEventSubscriptionPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(SystemEventSubscriptionPeer::UPDATED_AT, $updatedAt, $comparison);
	}

	/**
	 * Filter the query by a related SystemEvent object
	 *
	 * @param     SystemEvent|PropelCollection $systemEvent The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SystemEventSubscriptionQuery The current query, for fluid interface
	 */
	public function filterBySystemEvent($systemEvent, $comparison = null)
	{
		if ($systemEvent instanceof SystemEvent) {
			return $this
				->addUsingAlias(SystemEventSubscriptionPeer::SYSTEM_EVENT_ID, $systemEvent->getId(), $comparison);
		} elseif ($systemEvent instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(SystemEventSubscriptionPeer::SYSTEM_EVENT_ID, $systemEvent->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
	 * @return    SystemEventSubscriptionQuery The current query, for fluid interface
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
	 * Filter the query by a related User object
	 *
	 * @param     User|PropelCollection $user The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SystemEventSubscriptionQuery The current query, for fluid interface
	 */
	public function filterByUser($user, $comparison = null)
	{
		if ($user instanceof User) {
			return $this
				->addUsingAlias(SystemEventSubscriptionPeer::USER_ID, $user->getId(), $comparison);
		} elseif ($user instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(SystemEventSubscriptionPeer::USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByUser() only accepts arguments of type User or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the User relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    SystemEventSubscriptionQuery The current query, for fluid interface
	 */
	public function joinUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('User');
		
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
			$this->addJoinObject($join, 'User');
		}
		
		return $this;
	}

	/**
	 * Use the User relation User object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery A secondary query class using the current class as primary query
	 */
	public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinUser($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'User', 'UserQuery');
	}

	/**
	 * Filter the query by a related SystemEventInstanceMessage object
	 *
	 * @param     SystemEventInstanceMessage $systemEventInstanceMessage  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SystemEventSubscriptionQuery The current query, for fluid interface
	 */
	public function filterBySystemEventInstanceMessage($systemEventInstanceMessage, $comparison = null)
	{
		if ($systemEventInstanceMessage instanceof SystemEventInstanceMessage) {
			return $this
				->addUsingAlias(SystemEventSubscriptionPeer::ID, $systemEventInstanceMessage->getSystemEventSubscriptionId(), $comparison);
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
	 * @return    SystemEventSubscriptionQuery The current query, for fluid interface
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
	 * @param     SystemEventSubscription $systemEventSubscription Object to remove from the list of results
	 *
	 * @return    SystemEventSubscriptionQuery The current query, for fluid interface
	 */
	public function prune($systemEventSubscription = null)
	{
		if ($systemEventSubscription) {
			$this->addUsingAlias(SystemEventSubscriptionPeer::ID, $systemEventSubscription->getId(), Criteria::NOT_EQUAL);
	  }
	  
		return $this;
	}

} // BaseSystemEventSubscriptionQuery
