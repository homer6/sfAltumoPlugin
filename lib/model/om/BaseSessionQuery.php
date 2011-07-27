<?php


/**
 * Base class that represents a query for the 'session' table.
 *
 * 
 *
 * @method     SessionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     SessionQuery orderBySessionKey($order = Criteria::ASC) Order by the session_key column
 * @method     SessionQuery orderByData($order = Criteria::ASC) Order by the data column
 * @method     SessionQuery orderByClientIpAddress($order = Criteria::ASC) Order by the client_ip_address column
 * @method     SessionQuery orderBySessionType($order = Criteria::ASC) Order by the session_type column
 * @method     SessionQuery orderByTime($order = Criteria::ASC) Order by the time column
 *
 * @method     SessionQuery groupById() Group by the id column
 * @method     SessionQuery groupBySessionKey() Group by the session_key column
 * @method     SessionQuery groupByData() Group by the data column
 * @method     SessionQuery groupByClientIpAddress() Group by the client_ip_address column
 * @method     SessionQuery groupBySessionType() Group by the session_type column
 * @method     SessionQuery groupByTime() Group by the time column
 *
 * @method     SessionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     SessionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     SessionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     SessionQuery leftJoinSingleSignOnKey($relationAlias = null) Adds a LEFT JOIN clause to the query using the SingleSignOnKey relation
 * @method     SessionQuery rightJoinSingleSignOnKey($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SingleSignOnKey relation
 * @method     SessionQuery innerJoinSingleSignOnKey($relationAlias = null) Adds a INNER JOIN clause to the query using the SingleSignOnKey relation
 *
 * @method     Session findOne(PropelPDO $con = null) Return the first Session matching the query
 * @method     Session findOneOrCreate(PropelPDO $con = null) Return the first Session matching the query, or a new Session object populated from the query conditions when no match is found
 *
 * @method     Session findOneById(int $id) Return the first Session filtered by the id column
 * @method     Session findOneBySessionKey(string $session_key) Return the first Session filtered by the session_key column
 * @method     Session findOneByData(resource $data) Return the first Session filtered by the data column
 * @method     Session findOneByClientIpAddress(string $client_ip_address) Return the first Session filtered by the client_ip_address column
 * @method     Session findOneBySessionType(string $session_type) Return the first Session filtered by the session_type column
 * @method     Session findOneByTime(int $time) Return the first Session filtered by the time column
 *
 * @method     array findById(int $id) Return Session objects filtered by the id column
 * @method     array findBySessionKey(string $session_key) Return Session objects filtered by the session_key column
 * @method     array findByData(resource $data) Return Session objects filtered by the data column
 * @method     array findByClientIpAddress(string $client_ip_address) Return Session objects filtered by the client_ip_address column
 * @method     array findBySessionType(string $session_type) Return Session objects filtered by the session_type column
 * @method     array findByTime(int $time) Return Session objects filtered by the time column
 *
 * @package    propel.generator.plugins.sfAltumoPlugin.lib.model.om
 */
abstract class BaseSessionQuery extends ModelCriteria
{

	/**
	 * Initializes internal state of BaseSessionQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'propel', $modelName = 'Session', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new SessionQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    SessionQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof SessionQuery) {
			return $criteria;
		}
		$query = new SessionQuery();
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
	 * @return    Session|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ((null !== ($obj = SessionPeer::getInstanceFromPool((string) $key))) && $this->getFormatter()->isObjectFormatter()) {
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
	 * @return    SessionQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(SessionPeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    SessionQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(SessionPeer::ID, $keys, Criteria::IN);
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
	 * @return    SessionQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(SessionPeer::ID, $id, $comparison);
	}

	/**
	 * Filter the query on the session_key column
	 * 
	 * Example usage:
	 * <code>
	 * $query->filterBySessionKey('fooValue');   // WHERE session_key = 'fooValue'
	 * $query->filterBySessionKey('%fooValue%'); // WHERE session_key LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $sessionKey The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SessionQuery The current query, for fluid interface
	 */
	public function filterBySessionKey($sessionKey = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($sessionKey)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $sessionKey)) {
				$sessionKey = str_replace('*', '%', $sessionKey);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(SessionPeer::SESSION_KEY, $sessionKey, $comparison);
	}

	/**
	 * Filter the query on the data column
	 * 
	 * @param     mixed $data The value to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SessionQuery The current query, for fluid interface
	 */
	public function filterByData($data = null, $comparison = null)
	{
		return $this->addUsingAlias(SessionPeer::DATA, $data, $comparison);
	}

	/**
	 * Filter the query on the client_ip_address column
	 * 
	 * Example usage:
	 * <code>
	 * $query->filterByClientIpAddress('fooValue');   // WHERE client_ip_address = 'fooValue'
	 * $query->filterByClientIpAddress('%fooValue%'); // WHERE client_ip_address LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $clientIpAddress The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SessionQuery The current query, for fluid interface
	 */
	public function filterByClientIpAddress($clientIpAddress = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($clientIpAddress)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $clientIpAddress)) {
				$clientIpAddress = str_replace('*', '%', $clientIpAddress);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(SessionPeer::CLIENT_IP_ADDRESS, $clientIpAddress, $comparison);
	}

	/**
	 * Filter the query on the session_type column
	 * 
	 * Example usage:
	 * <code>
	 * $query->filterBySessionType('fooValue');   // WHERE session_type = 'fooValue'
	 * $query->filterBySessionType('%fooValue%'); // WHERE session_type LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $sessionType The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SessionQuery The current query, for fluid interface
	 */
	public function filterBySessionType($sessionType = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($sessionType)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $sessionType)) {
				$sessionType = str_replace('*', '%', $sessionType);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(SessionPeer::SESSION_TYPE, $sessionType, $comparison);
	}

	/**
	 * Filter the query on the time column
	 * 
	 * Example usage:
	 * <code>
	 * $query->filterByTime(1234); // WHERE time = 1234
	 * $query->filterByTime(array(12, 34)); // WHERE time IN (12, 34)
	 * $query->filterByTime(array('min' => 12)); // WHERE time > 12
	 * </code>
	 *
	 * @param     mixed $time The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SessionQuery The current query, for fluid interface
	 */
	public function filterByTime($time = null, $comparison = null)
	{
		if (is_array($time)) {
			$useMinMax = false;
			if (isset($time['min'])) {
				$this->addUsingAlias(SessionPeer::TIME, $time['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($time['max'])) {
				$this->addUsingAlias(SessionPeer::TIME, $time['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(SessionPeer::TIME, $time, $comparison);
	}

	/**
	 * Filter the query by a related SingleSignOnKey object
	 *
	 * @param     SingleSignOnKey $singleSignOnKey  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SessionQuery The current query, for fluid interface
	 */
	public function filterBySingleSignOnKey($singleSignOnKey, $comparison = null)
	{
		if ($singleSignOnKey instanceof SingleSignOnKey) {
			return $this
				->addUsingAlias(SessionPeer::ID, $singleSignOnKey->getSessionId(), $comparison);
		} elseif ($singleSignOnKey instanceof PropelCollection) {
			return $this
				->useSingleSignOnKeyQuery()
					->filterByPrimaryKeys($singleSignOnKey->getPrimaryKeys())
				->endUse();
		} else {
			throw new PropelException('filterBySingleSignOnKey() only accepts arguments of type SingleSignOnKey or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the SingleSignOnKey relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    SessionQuery The current query, for fluid interface
	 */
	public function joinSingleSignOnKey($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('SingleSignOnKey');
		
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
			$this->addJoinObject($join, 'SingleSignOnKey');
		}
		
		return $this;
	}

	/**
	 * Use the SingleSignOnKey relation SingleSignOnKey object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    SingleSignOnKeyQuery A secondary query class using the current class as primary query
	 */
	public function useSingleSignOnKeyQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinSingleSignOnKey($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'SingleSignOnKey', 'SingleSignOnKeyQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     Session $session Object to remove from the list of results
	 *
	 * @return    SessionQuery The current query, for fluid interface
	 */
	public function prune($session = null)
	{
		if ($session) {
			$this->addUsingAlias(SessionPeer::ID, $session->getId(), Criteria::NOT_EQUAL);
	  }
	  
		return $this;
	}

} // BaseSessionQuery
