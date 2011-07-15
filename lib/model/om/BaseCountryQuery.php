<?php


/**
 * Base class that represents a query for the 'country' table.
 *
 * 
 *
 * @method     CountryQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     CountryQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     CountryQuery orderByIsoCode($order = Criteria::ASC) Order by the iso_code column
 * @method     CountryQuery orderByIsoShortCode($order = Criteria::ASC) Order by the iso_short_code column
 * @method     CountryQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     CountryQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     CountryQuery groupById() Group by the id column
 * @method     CountryQuery groupByName() Group by the name column
 * @method     CountryQuery groupByIsoCode() Group by the iso_code column
 * @method     CountryQuery groupByIsoShortCode() Group by the iso_short_code column
 * @method     CountryQuery groupByCreatedAt() Group by the created_at column
 * @method     CountryQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     CountryQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     CountryQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     CountryQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     CountryQuery leftJoinState($relationAlias = null) Adds a LEFT JOIN clause to the query using the State relation
 * @method     CountryQuery rightJoinState($relationAlias = null) Adds a RIGHT JOIN clause to the query using the State relation
 * @method     CountryQuery innerJoinState($relationAlias = null) Adds a INNER JOIN clause to the query using the State relation
 *
 * @method     Country findOne(PropelPDO $con = null) Return the first Country matching the query
 * @method     Country findOneOrCreate(PropelPDO $con = null) Return the first Country matching the query, or a new Country object populated from the query conditions when no match is found
 *
 * @method     Country findOneById(int $id) Return the first Country filtered by the id column
 * @method     Country findOneByName(string $name) Return the first Country filtered by the name column
 * @method     Country findOneByIsoCode(string $iso_code) Return the first Country filtered by the iso_code column
 * @method     Country findOneByIsoShortCode(string $iso_short_code) Return the first Country filtered by the iso_short_code column
 * @method     Country findOneByCreatedAt(string $created_at) Return the first Country filtered by the created_at column
 * @method     Country findOneByUpdatedAt(string $updated_at) Return the first Country filtered by the updated_at column
 *
 * @method     array findById(int $id) Return Country objects filtered by the id column
 * @method     array findByName(string $name) Return Country objects filtered by the name column
 * @method     array findByIsoCode(string $iso_code) Return Country objects filtered by the iso_code column
 * @method     array findByIsoShortCode(string $iso_short_code) Return Country objects filtered by the iso_short_code column
 * @method     array findByCreatedAt(string $created_at) Return Country objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return Country objects filtered by the updated_at column
 *
 * @package    propel.generator.plugins.sfAltumoPlugin.lib.model.om
 */
abstract class BaseCountryQuery extends ModelCriteria
{

	/**
	 * Initializes internal state of BaseCountryQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'propel', $modelName = 'Country', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new CountryQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    CountryQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof CountryQuery) {
			return $criteria;
		}
		$query = new CountryQuery();
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
	 * @return    Country|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ((null !== ($obj = CountryPeer::getInstanceFromPool((string) $key))) && $this->getFormatter()->isObjectFormatter()) {
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
	 * @return    CountryQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(CountryPeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    CountryQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(CountryPeer::ID, $keys, Criteria::IN);
	}

	/**
	 * Filter the query on the id column
	 * 
	 * @param     int|array $id The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    CountryQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(CountryPeer::ID, $id, $comparison);
	}

	/**
	 * Filter the query on the name column
	 * 
	 * @param     string $name The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    CountryQuery The current query, for fluid interface
	 */
	public function filterByName($name = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($name)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $name)) {
				$name = str_replace('*', '%', $name);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(CountryPeer::NAME, $name, $comparison);
	}

	/**
	 * Filter the query on the iso_code column
	 * 
	 * @param     string $isoCode The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    CountryQuery The current query, for fluid interface
	 */
	public function filterByIsoCode($isoCode = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($isoCode)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $isoCode)) {
				$isoCode = str_replace('*', '%', $isoCode);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(CountryPeer::ISO_CODE, $isoCode, $comparison);
	}

	/**
	 * Filter the query on the iso_short_code column
	 * 
	 * @param     string $isoShortCode The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    CountryQuery The current query, for fluid interface
	 */
	public function filterByIsoShortCode($isoShortCode = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($isoShortCode)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $isoShortCode)) {
				$isoShortCode = str_replace('*', '%', $isoShortCode);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(CountryPeer::ISO_SHORT_CODE, $isoShortCode, $comparison);
	}

	/**
	 * Filter the query on the created_at column
	 * 
	 * @param     string|array $createdAt The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    CountryQuery The current query, for fluid interface
	 */
	public function filterByCreatedAt($createdAt = null, $comparison = null)
	{
		if (is_array($createdAt)) {
			$useMinMax = false;
			if (isset($createdAt['min'])) {
				$this->addUsingAlias(CountryPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdAt['max'])) {
				$this->addUsingAlias(CountryPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(CountryPeer::CREATED_AT, $createdAt, $comparison);
	}

	/**
	 * Filter the query on the updated_at column
	 * 
	 * @param     string|array $updatedAt The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    CountryQuery The current query, for fluid interface
	 */
	public function filterByUpdatedAt($updatedAt = null, $comparison = null)
	{
		if (is_array($updatedAt)) {
			$useMinMax = false;
			if (isset($updatedAt['min'])) {
				$this->addUsingAlias(CountryPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedAt['max'])) {
				$this->addUsingAlias(CountryPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(CountryPeer::UPDATED_AT, $updatedAt, $comparison);
	}

	/**
	 * Filter the query by a related State object
	 *
	 * @param     State $state  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    CountryQuery The current query, for fluid interface
	 */
	public function filterByState($state, $comparison = null)
	{
		return $this
			->addUsingAlias(CountryPeer::ID, $state->getCountryId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the State relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    CountryQuery The current query, for fluid interface
	 */
	public function joinState($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('State');
		
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
			$this->addJoinObject($join, 'State');
		}
		
		return $this;
	}

	/**
	 * Use the State relation State object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    StateQuery A secondary query class using the current class as primary query
	 */
	public function useStateQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinState($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'State', 'StateQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     Country $country Object to remove from the list of results
	 *
	 * @return    CountryQuery The current query, for fluid interface
	 */
	public function prune($country = null)
	{
		if ($country) {
			$this->addUsingAlias(CountryPeer::ID, $country->getId(), Criteria::NOT_EQUAL);
	  }
	  
		return $this;
	}

} // BaseCountryQuery
