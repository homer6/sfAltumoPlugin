<?php


/**
 * Base class that represents a query for the 'contact_information' table.
 *
 * 
 *
 * @method     ContactInformationQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ContactInformationQuery orderByFirstName($order = Criteria::ASC) Order by the first_name column
 * @method     ContactInformationQuery orderByLastName($order = Criteria::ASC) Order by the last_name column
 * @method     ContactInformationQuery orderByEmailAddress($order = Criteria::ASC) Order by the email_address column
 * @method     ContactInformationQuery orderByPhoneMainNumber($order = Criteria::ASC) Order by the phone_main_number column
 * @method     ContactInformationQuery orderByPhoneOtherNumber($order = Criteria::ASC) Order by the phone_other_number column
 * @method     ContactInformationQuery orderByMailingAddress($order = Criteria::ASC) Order by the mailing_address column
 * @method     ContactInformationQuery orderByCity($order = Criteria::ASC) Order by the city column
 * @method     ContactInformationQuery orderByStateId($order = Criteria::ASC) Order by the state_id column
 * @method     ContactInformationQuery orderByZipCode($order = Criteria::ASC) Order by the zip_code column
 * @method     ContactInformationQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ContactInformationQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ContactInformationQuery groupById() Group by the id column
 * @method     ContactInformationQuery groupByFirstName() Group by the first_name column
 * @method     ContactInformationQuery groupByLastName() Group by the last_name column
 * @method     ContactInformationQuery groupByEmailAddress() Group by the email_address column
 * @method     ContactInformationQuery groupByPhoneMainNumber() Group by the phone_main_number column
 * @method     ContactInformationQuery groupByPhoneOtherNumber() Group by the phone_other_number column
 * @method     ContactInformationQuery groupByMailingAddress() Group by the mailing_address column
 * @method     ContactInformationQuery groupByCity() Group by the city column
 * @method     ContactInformationQuery groupByStateId() Group by the state_id column
 * @method     ContactInformationQuery groupByZipCode() Group by the zip_code column
 * @method     ContactInformationQuery groupByCreatedAt() Group by the created_at column
 * @method     ContactInformationQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ContactInformationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ContactInformationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ContactInformationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ContactInformationQuery leftJoinState($relationAlias = null) Adds a LEFT JOIN clause to the query using the State relation
 * @method     ContactInformationQuery rightJoinState($relationAlias = null) Adds a RIGHT JOIN clause to the query using the State relation
 * @method     ContactInformationQuery innerJoinState($relationAlias = null) Adds a INNER JOIN clause to the query using the State relation
 *
 * @method     ContactInformationQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ContactInformationQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ContactInformationQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ContactInformationQuery leftJoinClientRelatedByDefaultBillingContactInformationId($relationAlias = null) Adds a LEFT JOIN clause to the query using the ClientRelatedByDefaultBillingContactInformationId relation
 * @method     ContactInformationQuery rightJoinClientRelatedByDefaultBillingContactInformationId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ClientRelatedByDefaultBillingContactInformationId relation
 * @method     ContactInformationQuery innerJoinClientRelatedByDefaultBillingContactInformationId($relationAlias = null) Adds a INNER JOIN clause to the query using the ClientRelatedByDefaultBillingContactInformationId relation
 *
 * @method     ContactInformationQuery leftJoinClientRelatedByDefaultShippingContactInformationId($relationAlias = null) Adds a LEFT JOIN clause to the query using the ClientRelatedByDefaultShippingContactInformationId relation
 * @method     ContactInformationQuery rightJoinClientRelatedByDefaultShippingContactInformationId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ClientRelatedByDefaultShippingContactInformationId relation
 * @method     ContactInformationQuery innerJoinClientRelatedByDefaultShippingContactInformationId($relationAlias = null) Adds a INNER JOIN clause to the query using the ClientRelatedByDefaultShippingContactInformationId relation
 *
 * @method     ContactInformationQuery leftJoinClientRelatedByContactInformationId($relationAlias = null) Adds a LEFT JOIN clause to the query using the ClientRelatedByContactInformationId relation
 * @method     ContactInformationQuery rightJoinClientRelatedByContactInformationId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ClientRelatedByContactInformationId relation
 * @method     ContactInformationQuery innerJoinClientRelatedByContactInformationId($relationAlias = null) Adds a INNER JOIN clause to the query using the ClientRelatedByContactInformationId relation
 *
 * @method     ContactInformation findOne(PropelPDO $con = null) Return the first ContactInformation matching the query
 * @method     ContactInformation findOneOrCreate(PropelPDO $con = null) Return the first ContactInformation matching the query, or a new ContactInformation object populated from the query conditions when no match is found
 *
 * @method     ContactInformation findOneById(int $id) Return the first ContactInformation filtered by the id column
 * @method     ContactInformation findOneByFirstName(string $first_name) Return the first ContactInformation filtered by the first_name column
 * @method     ContactInformation findOneByLastName(string $last_name) Return the first ContactInformation filtered by the last_name column
 * @method     ContactInformation findOneByEmailAddress(string $email_address) Return the first ContactInformation filtered by the email_address column
 * @method     ContactInformation findOneByPhoneMainNumber(string $phone_main_number) Return the first ContactInformation filtered by the phone_main_number column
 * @method     ContactInformation findOneByPhoneOtherNumber(string $phone_other_number) Return the first ContactInformation filtered by the phone_other_number column
 * @method     ContactInformation findOneByMailingAddress(string $mailing_address) Return the first ContactInformation filtered by the mailing_address column
 * @method     ContactInformation findOneByCity(string $city) Return the first ContactInformation filtered by the city column
 * @method     ContactInformation findOneByStateId(int $state_id) Return the first ContactInformation filtered by the state_id column
 * @method     ContactInformation findOneByZipCode(string $zip_code) Return the first ContactInformation filtered by the zip_code column
 * @method     ContactInformation findOneByCreatedAt(string $created_at) Return the first ContactInformation filtered by the created_at column
 * @method     ContactInformation findOneByUpdatedAt(string $updated_at) Return the first ContactInformation filtered by the updated_at column
 *
 * @method     array findById(int $id) Return ContactInformation objects filtered by the id column
 * @method     array findByFirstName(string $first_name) Return ContactInformation objects filtered by the first_name column
 * @method     array findByLastName(string $last_name) Return ContactInformation objects filtered by the last_name column
 * @method     array findByEmailAddress(string $email_address) Return ContactInformation objects filtered by the email_address column
 * @method     array findByPhoneMainNumber(string $phone_main_number) Return ContactInformation objects filtered by the phone_main_number column
 * @method     array findByPhoneOtherNumber(string $phone_other_number) Return ContactInformation objects filtered by the phone_other_number column
 * @method     array findByMailingAddress(string $mailing_address) Return ContactInformation objects filtered by the mailing_address column
 * @method     array findByCity(string $city) Return ContactInformation objects filtered by the city column
 * @method     array findByStateId(int $state_id) Return ContactInformation objects filtered by the state_id column
 * @method     array findByZipCode(string $zip_code) Return ContactInformation objects filtered by the zip_code column
 * @method     array findByCreatedAt(string $created_at) Return ContactInformation objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ContactInformation objects filtered by the updated_at column
 *
 * @package    propel.generator.plugins.sfAltumoPlugin.lib.model.om
 */
abstract class BaseContactInformationQuery extends ModelCriteria
{

	/**
	 * Initializes internal state of BaseContactInformationQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'propel', $modelName = 'ContactInformation', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new ContactInformationQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    ContactInformationQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof ContactInformationQuery) {
			return $criteria;
		}
		$query = new ContactInformationQuery();
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
	 * @return    ContactInformation|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ((null !== ($obj = ContactInformationPeer::getInstanceFromPool((string) $key))) && $this->getFormatter()->isObjectFormatter()) {
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
	 * @return    ContactInformationQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(ContactInformationPeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    ContactInformationQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(ContactInformationPeer::ID, $keys, Criteria::IN);
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
	 * @return    ContactInformationQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(ContactInformationPeer::ID, $id, $comparison);
	}

	/**
	 * Filter the query on the first_name column
	 * 
	 * Example usage:
	 * <code>
	 * $query->filterByFirstName('fooValue');   // WHERE first_name = 'fooValue'
	 * $query->filterByFirstName('%fooValue%'); // WHERE first_name LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $firstName The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    ContactInformationQuery The current query, for fluid interface
	 */
	public function filterByFirstName($firstName = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($firstName)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $firstName)) {
				$firstName = str_replace('*', '%', $firstName);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(ContactInformationPeer::FIRST_NAME, $firstName, $comparison);
	}

	/**
	 * Filter the query on the last_name column
	 * 
	 * Example usage:
	 * <code>
	 * $query->filterByLastName('fooValue');   // WHERE last_name = 'fooValue'
	 * $query->filterByLastName('%fooValue%'); // WHERE last_name LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $lastName The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    ContactInformationQuery The current query, for fluid interface
	 */
	public function filterByLastName($lastName = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($lastName)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $lastName)) {
				$lastName = str_replace('*', '%', $lastName);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(ContactInformationPeer::LAST_NAME, $lastName, $comparison);
	}

	/**
	 * Filter the query on the email_address column
	 * 
	 * Example usage:
	 * <code>
	 * $query->filterByEmailAddress('fooValue');   // WHERE email_address = 'fooValue'
	 * $query->filterByEmailAddress('%fooValue%'); // WHERE email_address LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $emailAddress The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    ContactInformationQuery The current query, for fluid interface
	 */
	public function filterByEmailAddress($emailAddress = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($emailAddress)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $emailAddress)) {
				$emailAddress = str_replace('*', '%', $emailAddress);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(ContactInformationPeer::EMAIL_ADDRESS, $emailAddress, $comparison);
	}

	/**
	 * Filter the query on the phone_main_number column
	 * 
	 * Example usage:
	 * <code>
	 * $query->filterByPhoneMainNumber('fooValue');   // WHERE phone_main_number = 'fooValue'
	 * $query->filterByPhoneMainNumber('%fooValue%'); // WHERE phone_main_number LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $phoneMainNumber The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    ContactInformationQuery The current query, for fluid interface
	 */
	public function filterByPhoneMainNumber($phoneMainNumber = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($phoneMainNumber)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $phoneMainNumber)) {
				$phoneMainNumber = str_replace('*', '%', $phoneMainNumber);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(ContactInformationPeer::PHONE_MAIN_NUMBER, $phoneMainNumber, $comparison);
	}

	/**
	 * Filter the query on the phone_other_number column
	 * 
	 * Example usage:
	 * <code>
	 * $query->filterByPhoneOtherNumber('fooValue');   // WHERE phone_other_number = 'fooValue'
	 * $query->filterByPhoneOtherNumber('%fooValue%'); // WHERE phone_other_number LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $phoneOtherNumber The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    ContactInformationQuery The current query, for fluid interface
	 */
	public function filterByPhoneOtherNumber($phoneOtherNumber = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($phoneOtherNumber)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $phoneOtherNumber)) {
				$phoneOtherNumber = str_replace('*', '%', $phoneOtherNumber);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(ContactInformationPeer::PHONE_OTHER_NUMBER, $phoneOtherNumber, $comparison);
	}

	/**
	 * Filter the query on the mailing_address column
	 * 
	 * Example usage:
	 * <code>
	 * $query->filterByMailingAddress('fooValue');   // WHERE mailing_address = 'fooValue'
	 * $query->filterByMailingAddress('%fooValue%'); // WHERE mailing_address LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $mailingAddress The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    ContactInformationQuery The current query, for fluid interface
	 */
	public function filterByMailingAddress($mailingAddress = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($mailingAddress)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $mailingAddress)) {
				$mailingAddress = str_replace('*', '%', $mailingAddress);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(ContactInformationPeer::MAILING_ADDRESS, $mailingAddress, $comparison);
	}

	/**
	 * Filter the query on the city column
	 * 
	 * Example usage:
	 * <code>
	 * $query->filterByCity('fooValue');   // WHERE city = 'fooValue'
	 * $query->filterByCity('%fooValue%'); // WHERE city LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $city The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    ContactInformationQuery The current query, for fluid interface
	 */
	public function filterByCity($city = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($city)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $city)) {
				$city = str_replace('*', '%', $city);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(ContactInformationPeer::CITY, $city, $comparison);
	}

	/**
	 * Filter the query on the state_id column
	 * 
	 * Example usage:
	 * <code>
	 * $query->filterByStateId(1234); // WHERE state_id = 1234
	 * $query->filterByStateId(array(12, 34)); // WHERE state_id IN (12, 34)
	 * $query->filterByStateId(array('min' => 12)); // WHERE state_id > 12
	 * </code>
	 *
	 * @see       filterByState()
	 *
	 * @param     mixed $stateId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    ContactInformationQuery The current query, for fluid interface
	 */
	public function filterByStateId($stateId = null, $comparison = null)
	{
		if (is_array($stateId)) {
			$useMinMax = false;
			if (isset($stateId['min'])) {
				$this->addUsingAlias(ContactInformationPeer::STATE_ID, $stateId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($stateId['max'])) {
				$this->addUsingAlias(ContactInformationPeer::STATE_ID, $stateId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(ContactInformationPeer::STATE_ID, $stateId, $comparison);
	}

	/**
	 * Filter the query on the zip_code column
	 * 
	 * Example usage:
	 * <code>
	 * $query->filterByZipCode('fooValue');   // WHERE zip_code = 'fooValue'
	 * $query->filterByZipCode('%fooValue%'); // WHERE zip_code LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $zipCode The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    ContactInformationQuery The current query, for fluid interface
	 */
	public function filterByZipCode($zipCode = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($zipCode)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $zipCode)) {
				$zipCode = str_replace('*', '%', $zipCode);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(ContactInformationPeer::ZIP_CODE, $zipCode, $comparison);
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
	 * @return    ContactInformationQuery The current query, for fluid interface
	 */
	public function filterByCreatedAt($createdAt = null, $comparison = null)
	{
		if (is_array($createdAt)) {
			$useMinMax = false;
			if (isset($createdAt['min'])) {
				$this->addUsingAlias(ContactInformationPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdAt['max'])) {
				$this->addUsingAlias(ContactInformationPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(ContactInformationPeer::CREATED_AT, $createdAt, $comparison);
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
	 * @return    ContactInformationQuery The current query, for fluid interface
	 */
	public function filterByUpdatedAt($updatedAt = null, $comparison = null)
	{
		if (is_array($updatedAt)) {
			$useMinMax = false;
			if (isset($updatedAt['min'])) {
				$this->addUsingAlias(ContactInformationPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedAt['max'])) {
				$this->addUsingAlias(ContactInformationPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(ContactInformationPeer::UPDATED_AT, $updatedAt, $comparison);
	}

	/**
	 * Filter the query by a related State object
	 *
	 * @param     State|PropelCollection $state The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    ContactInformationQuery The current query, for fluid interface
	 */
	public function filterByState($state, $comparison = null)
	{
		if ($state instanceof State) {
			return $this
				->addUsingAlias(ContactInformationPeer::STATE_ID, $state->getId(), $comparison);
		} elseif ($state instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(ContactInformationPeer::STATE_ID, $state->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByState() only accepts arguments of type State or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the State relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    ContactInformationQuery The current query, for fluid interface
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
	 * Filter the query by a related User object
	 *
	 * @param     User $user  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    ContactInformationQuery The current query, for fluid interface
	 */
	public function filterByUser($user, $comparison = null)
	{
		if ($user instanceof User) {
			return $this
				->addUsingAlias(ContactInformationPeer::ID, $user->getContactInformationId(), $comparison);
		} elseif ($user instanceof PropelCollection) {
			return $this
				->useUserQuery()
					->filterByPrimaryKeys($user->getPrimaryKeys())
				->endUse();
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
	 * @return    ContactInformationQuery The current query, for fluid interface
	 */
	public function joinUser($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function useUserQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinUser($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'User', 'UserQuery');
	}

	/**
	 * Filter the query by a related Client object
	 *
	 * @param     Client $client  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    ContactInformationQuery The current query, for fluid interface
	 */
	public function filterByClientRelatedByDefaultBillingContactInformationId($client, $comparison = null)
	{
		if ($client instanceof Client) {
			return $this
				->addUsingAlias(ContactInformationPeer::ID, $client->getDefaultBillingContactInformationId(), $comparison);
		} elseif ($client instanceof PropelCollection) {
			return $this
				->useClientRelatedByDefaultBillingContactInformationIdQuery()
					->filterByPrimaryKeys($client->getPrimaryKeys())
				->endUse();
		} else {
			throw new PropelException('filterByClientRelatedByDefaultBillingContactInformationId() only accepts arguments of type Client or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the ClientRelatedByDefaultBillingContactInformationId relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    ContactInformationQuery The current query, for fluid interface
	 */
	public function joinClientRelatedByDefaultBillingContactInformationId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('ClientRelatedByDefaultBillingContactInformationId');
		
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
			$this->addJoinObject($join, 'ClientRelatedByDefaultBillingContactInformationId');
		}
		
		return $this;
	}

	/**
	 * Use the ClientRelatedByDefaultBillingContactInformationId relation Client object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    ClientQuery A secondary query class using the current class as primary query
	 */
	public function useClientRelatedByDefaultBillingContactInformationIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinClientRelatedByDefaultBillingContactInformationId($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'ClientRelatedByDefaultBillingContactInformationId', 'ClientQuery');
	}

	/**
	 * Filter the query by a related Client object
	 *
	 * @param     Client $client  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    ContactInformationQuery The current query, for fluid interface
	 */
	public function filterByClientRelatedByDefaultShippingContactInformationId($client, $comparison = null)
	{
		if ($client instanceof Client) {
			return $this
				->addUsingAlias(ContactInformationPeer::ID, $client->getDefaultShippingContactInformationId(), $comparison);
		} elseif ($client instanceof PropelCollection) {
			return $this
				->useClientRelatedByDefaultShippingContactInformationIdQuery()
					->filterByPrimaryKeys($client->getPrimaryKeys())
				->endUse();
		} else {
			throw new PropelException('filterByClientRelatedByDefaultShippingContactInformationId() only accepts arguments of type Client or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the ClientRelatedByDefaultShippingContactInformationId relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    ContactInformationQuery The current query, for fluid interface
	 */
	public function joinClientRelatedByDefaultShippingContactInformationId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('ClientRelatedByDefaultShippingContactInformationId');
		
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
			$this->addJoinObject($join, 'ClientRelatedByDefaultShippingContactInformationId');
		}
		
		return $this;
	}

	/**
	 * Use the ClientRelatedByDefaultShippingContactInformationId relation Client object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    ClientQuery A secondary query class using the current class as primary query
	 */
	public function useClientRelatedByDefaultShippingContactInformationIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinClientRelatedByDefaultShippingContactInformationId($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'ClientRelatedByDefaultShippingContactInformationId', 'ClientQuery');
	}

	/**
	 * Filter the query by a related Client object
	 *
	 * @param     Client $client  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    ContactInformationQuery The current query, for fluid interface
	 */
	public function filterByClientRelatedByContactInformationId($client, $comparison = null)
	{
		if ($client instanceof Client) {
			return $this
				->addUsingAlias(ContactInformationPeer::ID, $client->getContactInformationId(), $comparison);
		} elseif ($client instanceof PropelCollection) {
			return $this
				->useClientRelatedByContactInformationIdQuery()
					->filterByPrimaryKeys($client->getPrimaryKeys())
				->endUse();
		} else {
			throw new PropelException('filterByClientRelatedByContactInformationId() only accepts arguments of type Client or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the ClientRelatedByContactInformationId relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    ContactInformationQuery The current query, for fluid interface
	 */
	public function joinClientRelatedByContactInformationId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('ClientRelatedByContactInformationId');
		
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
			$this->addJoinObject($join, 'ClientRelatedByContactInformationId');
		}
		
		return $this;
	}

	/**
	 * Use the ClientRelatedByContactInformationId relation Client object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    ClientQuery A secondary query class using the current class as primary query
	 */
	public function useClientRelatedByContactInformationIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinClientRelatedByContactInformationId($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'ClientRelatedByContactInformationId', 'ClientQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     ContactInformation $contactInformation Object to remove from the list of results
	 *
	 * @return    ContactInformationQuery The current query, for fluid interface
	 */
	public function prune($contactInformation = null)
	{
		if ($contactInformation) {
			$this->addUsingAlias(ContactInformationPeer::ID, $contactInformation->getId(), Criteria::NOT_EQUAL);
	  }
	  
		return $this;
	}

} // BaseContactInformationQuery
