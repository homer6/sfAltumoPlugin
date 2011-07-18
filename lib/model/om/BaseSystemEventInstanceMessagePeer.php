<?php


/**
 * Base static class for performing query and update operations on the 'system_event_instance_message' table.
 *
 * 
 *
 * @package    propel.generator.plugins.sfAltumoPlugin.lib.model.om
 */
abstract class BaseSystemEventInstanceMessagePeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'system_event_instance_message';

	/** the related Propel class for this table */
	const OM_CLASS = 'SystemEventInstanceMessage';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'plugins.sfAltumoPlugin.lib.model.SystemEventInstanceMessage';

	/** the related TableMap class for this table */
	const TM_CLASS = 'SystemEventInstanceMessageTableMap';
	
	/** The total number of columns. */
	const NUM_COLUMNS = 8;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;

	/** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
	const NUM_HYDRATE_COLUMNS = 8;

	/** the column name for the ID field */
	const ID = 'system_event_instance_message.ID';

	/** the column name for the SYSTEM_EVENT_INSTANCE_ID field */
	const SYSTEM_EVENT_INSTANCE_ID = 'system_event_instance_message.SYSTEM_EVENT_INSTANCE_ID';

	/** the column name for the SYSTEM_EVENT_SUBSCRIPTION_ID field */
	const SYSTEM_EVENT_SUBSCRIPTION_ID = 'system_event_instance_message.SYSTEM_EVENT_SUBSCRIPTION_ID';

	/** the column name for the RECEIVED field */
	const RECEIVED = 'system_event_instance_message.RECEIVED';

	/** the column name for the RECEIVED_AT field */
	const RECEIVED_AT = 'system_event_instance_message.RECEIVED_AT';

	/** the column name for the STATUS_MESSAGE field */
	const STATUS_MESSAGE = 'system_event_instance_message.STATUS_MESSAGE';

	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'system_event_instance_message.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'system_event_instance_message.UPDATED_AT';

	/** The default string format for model objects of the related table **/
	const DEFAULT_STRING_FORMAT = 'YAML';
	
	/**
	 * An identiy map to hold any loaded instances of SystemEventInstanceMessage objects.
	 * This must be public so that other peer classes can access this when hydrating from JOIN
	 * queries.
	 * @var        array SystemEventInstanceMessage[]
	 */
	public static $instances = array();


	// symfony behavior
	
	/**
	 * Indicates whether the current model includes I18N.
	 */
	const IS_I18N = false;

	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	protected static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'SystemEventInstanceId', 'SystemEventSubscriptionId', 'Received', 'ReceivedAt', 'StatusMessage', 'CreatedAt', 'UpdatedAt', ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'systemEventInstanceId', 'systemEventSubscriptionId', 'received', 'receivedAt', 'statusMessage', 'createdAt', 'updatedAt', ),
		BasePeer::TYPE_COLNAME => array (self::ID, self::SYSTEM_EVENT_INSTANCE_ID, self::SYSTEM_EVENT_SUBSCRIPTION_ID, self::RECEIVED, self::RECEIVED_AT, self::STATUS_MESSAGE, self::CREATED_AT, self::UPDATED_AT, ),
		BasePeer::TYPE_RAW_COLNAME => array ('ID', 'SYSTEM_EVENT_INSTANCE_ID', 'SYSTEM_EVENT_SUBSCRIPTION_ID', 'RECEIVED', 'RECEIVED_AT', 'STATUS_MESSAGE', 'CREATED_AT', 'UPDATED_AT', ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'system_event_instance_id', 'system_event_subscription_id', 'received', 'received_at', 'status_message', 'created_at', 'updated_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	protected static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'SystemEventInstanceId' => 1, 'SystemEventSubscriptionId' => 2, 'Received' => 3, 'ReceivedAt' => 4, 'StatusMessage' => 5, 'CreatedAt' => 6, 'UpdatedAt' => 7, ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'systemEventInstanceId' => 1, 'systemEventSubscriptionId' => 2, 'received' => 3, 'receivedAt' => 4, 'statusMessage' => 5, 'createdAt' => 6, 'updatedAt' => 7, ),
		BasePeer::TYPE_COLNAME => array (self::ID => 0, self::SYSTEM_EVENT_INSTANCE_ID => 1, self::SYSTEM_EVENT_SUBSCRIPTION_ID => 2, self::RECEIVED => 3, self::RECEIVED_AT => 4, self::STATUS_MESSAGE => 5, self::CREATED_AT => 6, self::UPDATED_AT => 7, ),
		BasePeer::TYPE_RAW_COLNAME => array ('ID' => 0, 'SYSTEM_EVENT_INSTANCE_ID' => 1, 'SYSTEM_EVENT_SUBSCRIPTION_ID' => 2, 'RECEIVED' => 3, 'RECEIVED_AT' => 4, 'STATUS_MESSAGE' => 5, 'CREATED_AT' => 6, 'UPDATED_AT' => 7, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'system_event_instance_id' => 1, 'system_event_subscription_id' => 2, 'received' => 3, 'received_at' => 4, 'status_message' => 5, 'created_at' => 6, 'updated_at' => 7, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	/**
	 * Translates a fieldname to another type
	 *
	 * @param      string $name field name
	 * @param      string $fromType One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                         BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @param      string $toType   One of the class type constants
	 * @return     string translated name of the field.
	 * @throws     PropelException - if the specified name could not be found in the fieldname mappings.
	 */
	static public function translateFieldName($name, $fromType, $toType)
	{
		$toNames = self::getFieldNames($toType);
		$key = isset(self::$fieldKeys[$fromType][$name]) ? self::$fieldKeys[$fromType][$name] : null;
		if ($key === null) {
			throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
		}
		return $toNames[$key];
	}

	/**
	 * Returns an array of field names.
	 *
	 * @param      string $type The type of fieldnames to return:
	 *                      One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                      BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     array A list of field names
	 */

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
		}
		return self::$fieldNames[$type];
	}

	/**
	 * Convenience method which changes table.column to alias.column.
	 *
	 * Using this method you can maintain SQL abstraction while using column aliases.
	 * <code>
	 *		$c->addAlias("alias1", TablePeer::TABLE_NAME);
	 *		$c->addJoin(TablePeer::alias("alias1", TablePeer::PRIMARY_KEY_COLUMN), TablePeer::PRIMARY_KEY_COLUMN);
	 * </code>
	 * @param      string $alias The alias for the current table.
	 * @param      string $column The column name for current table. (i.e. SystemEventInstanceMessagePeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(SystemEventInstanceMessagePeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	/**
	 * Add all the columns needed to create a new object.
	 *
	 * Note: any columns that were marked with lazyLoad="true" in the
	 * XML schema will not be added to the select list and only loaded
	 * on demand.
	 *
	 * @param      Criteria $criteria object containing the columns to add.
	 * @param      string   $alias    optional table alias
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function addSelectColumns(Criteria $criteria, $alias = null)
	{
		if (null === $alias) {
			$criteria->addSelectColumn(SystemEventInstanceMessagePeer::ID);
			$criteria->addSelectColumn(SystemEventInstanceMessagePeer::SYSTEM_EVENT_INSTANCE_ID);
			$criteria->addSelectColumn(SystemEventInstanceMessagePeer::SYSTEM_EVENT_SUBSCRIPTION_ID);
			$criteria->addSelectColumn(SystemEventInstanceMessagePeer::RECEIVED);
			$criteria->addSelectColumn(SystemEventInstanceMessagePeer::RECEIVED_AT);
			$criteria->addSelectColumn(SystemEventInstanceMessagePeer::STATUS_MESSAGE);
			$criteria->addSelectColumn(SystemEventInstanceMessagePeer::CREATED_AT);
			$criteria->addSelectColumn(SystemEventInstanceMessagePeer::UPDATED_AT);
		} else {
			$criteria->addSelectColumn($alias . '.ID');
			$criteria->addSelectColumn($alias . '.SYSTEM_EVENT_INSTANCE_ID');
			$criteria->addSelectColumn($alias . '.SYSTEM_EVENT_SUBSCRIPTION_ID');
			$criteria->addSelectColumn($alias . '.RECEIVED');
			$criteria->addSelectColumn($alias . '.RECEIVED_AT');
			$criteria->addSelectColumn($alias . '.STATUS_MESSAGE');
			$criteria->addSelectColumn($alias . '.CREATED_AT');
			$criteria->addSelectColumn($alias . '.UPDATED_AT');
		}
	}

	/**
	 * Returns the number of rows matching criteria.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @return     int Number of matching rows.
	 */
	public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
	{
		// we may modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(SystemEventInstanceMessagePeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			SystemEventInstanceMessagePeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
		$criteria->setDbName(self::DATABASE_NAME); // Set the correct dbName

		if ($con === null) {
			$con = Propel::getConnection(SystemEventInstanceMessagePeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
		// symfony_behaviors behavior
		foreach (sfMixer::getCallables(self::getMixerPreSelectHook(__FUNCTION__)) as $sf_hook)
		{
		  call_user_func($sf_hook, 'BaseSystemEventInstanceMessagePeer', $criteria, $con);
		}

		// BasePeer returns a PDOStatement
		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}
	/**
	 * Method to select one object from the DB.
	 *
	 * @param      Criteria $criteria object used to create the SELECT statement.
	 * @param      PropelPDO $con
	 * @return     SystemEventInstanceMessage
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = SystemEventInstanceMessagePeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	/**
	 * Method to do selects.
	 *
	 * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
	 * @param      PropelPDO $con
	 * @return     array Array of selected Objects
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelect(Criteria $criteria, PropelPDO $con = null)
	{
		return SystemEventInstanceMessagePeer::populateObjects(SystemEventInstanceMessagePeer::doSelectStmt($criteria, $con));
	}
	/**
	 * Prepares the Criteria object and uses the parent doSelect() method to execute a PDOStatement.
	 *
	 * Use this method directly if you want to work with an executed statement durirectly (for example
	 * to perform your own object hydration).
	 *
	 * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
	 * @param      PropelPDO $con The connection to use
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 * @return     PDOStatement The executed PDOStatement object.
	 * @see        BasePeer::doSelect()
	 */
	public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(SystemEventInstanceMessagePeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		if (!$criteria->hasSelectClause()) {
			$criteria = clone $criteria;
			SystemEventInstanceMessagePeer::addSelectColumns($criteria);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);
		// symfony_behaviors behavior
		foreach (sfMixer::getCallables(self::getMixerPreSelectHook(__FUNCTION__)) as $sf_hook)
		{
		  call_user_func($sf_hook, 'BaseSystemEventInstanceMessagePeer', $criteria, $con);
		}


		// BasePeer returns a PDOStatement
		return BasePeer::doSelect($criteria, $con);
	}
	/**
	 * Adds an object to the instance pool.
	 *
	 * Propel keeps cached copies of objects in an instance pool when they are retrieved
	 * from the database.  In some cases -- especially when you override doSelect*()
	 * methods in your stub classes -- you may need to explicitly add objects
	 * to the cache in order to ensure that the same objects are always returned by doSelect*()
	 * and retrieveByPK*() calls.
	 *
	 * @param      SystemEventInstanceMessage $value A SystemEventInstanceMessage object.
	 * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
	 */
	public static function addInstanceToPool($obj, $key = null)
	{
		if (Propel::isInstancePoolingEnabled()) {
			if ($key === null) {
				$key = (string) $obj->getId();
			} // if key === null
			self::$instances[$key] = $obj;
		}
	}

	/**
	 * Removes an object from the instance pool.
	 *
	 * Propel keeps cached copies of objects in an instance pool when they are retrieved
	 * from the database.  In some cases -- especially when you override doDelete
	 * methods in your stub classes -- you may need to explicitly remove objects
	 * from the cache in order to prevent returning objects that no longer exist.
	 *
	 * @param      mixed $value A SystemEventInstanceMessage object or a primary key value.
	 */
	public static function removeInstanceFromPool($value)
	{
		if (Propel::isInstancePoolingEnabled() && $value !== null) {
			if (is_object($value) && $value instanceof SystemEventInstanceMessage) {
				$key = (string) $value->getId();
			} elseif (is_scalar($value)) {
				// assume we've been passed a primary key
				$key = (string) $value;
			} else {
				$e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or SystemEventInstanceMessage object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
				throw $e;
			}

			unset(self::$instances[$key]);
		}
	} // removeInstanceFromPool()

	/**
	 * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
	 *
	 * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
	 * a multi-column primary key, a serialize()d version of the primary key will be returned.
	 *
	 * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
	 * @return     SystemEventInstanceMessage Found object or NULL if 1) no instance exists for specified key or 2) instance pooling has been disabled.
	 * @see        getPrimaryKeyHash()
	 */
	public static function getInstanceFromPool($key)
	{
		if (Propel::isInstancePoolingEnabled()) {
			if (isset(self::$instances[$key])) {
				return self::$instances[$key];
			}
		}
		return null; // just to be explicit
	}
	
	/**
	 * Clear the instance pool.
	 *
	 * @return     void
	 */
	public static function clearInstancePool()
	{
		self::$instances = array();
	}
	
	/**
	 * Method to invalidate the instance pool of all tables related to system_event_instance_message
	 * by a foreign key with ON DELETE CASCADE
	 */
	public static function clearRelatedInstancePool()
	{
	}

	/**
	 * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
	 *
	 * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
	 * a multi-column primary key, a serialize()d version of the primary key will be returned.
	 *
	 * @param      array $row PropelPDO resultset row.
	 * @param      int $startcol The 0-based offset for reading from the resultset row.
	 * @return     string A string version of PK or NULL if the components of primary key in result array are all null.
	 */
	public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
	{
		// If the PK cannot be derived from the row, return NULL.
		if ($row[$startcol] === null) {
			return null;
		}
		return (string) $row[$startcol];
	}

	/**
	 * Retrieves the primary key from the DB resultset row 
	 * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
	 * a multi-column primary key, an array of the primary key columns will be returned.
	 *
	 * @param      array $row PropelPDO resultset row.
	 * @param      int $startcol The 0-based offset for reading from the resultset row.
	 * @return     mixed The primary key of the row
	 */
	public static function getPrimaryKeyFromRow($row, $startcol = 0)
	{
		return (int) $row[$startcol];
	}
	
	/**
	 * The returned array will contain objects of the default type or
	 * objects that inherit from the default.
	 *
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function populateObjects(PDOStatement $stmt)
	{
		$results = array();
	
		// set the class once to avoid overhead in the loop
		$cls = SystemEventInstanceMessagePeer::getOMClass(false);
		// populate the object(s)
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key = SystemEventInstanceMessagePeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj = SystemEventInstanceMessagePeer::getInstanceFromPool($key))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://www.propelorm.org/ticket/509
				// $obj->hydrate($row, 0, true); // rehydrate
				$results[] = $obj;
			} else {
				$obj = new $cls();
				$obj->hydrate($row);
				$results[] = $obj;
				SystemEventInstanceMessagePeer::addInstanceToPool($obj, $key);
			} // if key exists
		}
		$stmt->closeCursor();
		return $results;
	}
	/**
	 * Populates an object of the default type or an object that inherit from the default.
	 *
	 * @param      array $row PropelPDO resultset row.
	 * @param      int $startcol The 0-based offset for reading from the resultset row.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 * @return     array (SystemEventInstanceMessage object, last column rank)
	 */
	public static function populateObject($row, $startcol = 0)
	{
		$key = SystemEventInstanceMessagePeer::getPrimaryKeyHashFromRow($row, $startcol);
		if (null !== ($obj = SystemEventInstanceMessagePeer::getInstanceFromPool($key))) {
			// We no longer rehydrate the object, since this can cause data loss.
			// See http://www.propelorm.org/ticket/509
			// $obj->hydrate($row, $startcol, true); // rehydrate
			$col = $startcol + SystemEventInstanceMessagePeer::NUM_HYDRATE_COLUMNS;
		} else {
			$cls = SystemEventInstanceMessagePeer::OM_CLASS;
			$obj = new $cls();
			$col = $obj->hydrate($row, $startcol);
			SystemEventInstanceMessagePeer::addInstanceToPool($obj, $key);
		}
		return array($obj, $col);
	}

	/**
	 * Returns the number of rows matching criteria, joining the related SystemEventInstance table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinSystemEventInstance(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(SystemEventInstanceMessagePeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			SystemEventInstanceMessagePeer::addSelectColumns($criteria);
		}
		
		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
		
		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(SystemEventInstanceMessagePeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(SystemEventInstanceMessagePeer::SYSTEM_EVENT_INSTANCE_ID, SystemEventInstancePeer::ID, $join_behavior);

		// symfony_behaviors behavior
		foreach (sfMixer::getCallables(self::getMixerPreSelectHook(__FUNCTION__)) as $sf_hook)
		{
		  call_user_func($sf_hook, 'BaseSystemEventInstanceMessagePeer', $criteria, $con);
		}

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related SystemEventSubscription table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinSystemEventSubscription(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(SystemEventInstanceMessagePeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			SystemEventInstanceMessagePeer::addSelectColumns($criteria);
		}
		
		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
		
		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(SystemEventInstanceMessagePeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(SystemEventInstanceMessagePeer::SYSTEM_EVENT_SUBSCRIPTION_ID, SystemEventSubscriptionPeer::ID, $join_behavior);

		// symfony_behaviors behavior
		foreach (sfMixer::getCallables(self::getMixerPreSelectHook(__FUNCTION__)) as $sf_hook)
		{
		  call_user_func($sf_hook, 'BaseSystemEventInstanceMessagePeer', $criteria, $con);
		}

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}


	/**
	 * Selects a collection of SystemEventInstanceMessage objects pre-filled with their SystemEventInstance objects.
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of SystemEventInstanceMessage objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinSystemEventInstance(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		SystemEventInstanceMessagePeer::addSelectColumns($criteria);
		$startcol = SystemEventInstanceMessagePeer::NUM_HYDRATE_COLUMNS;
		SystemEventInstancePeer::addSelectColumns($criteria);

		$criteria->addJoin(SystemEventInstanceMessagePeer::SYSTEM_EVENT_INSTANCE_ID, SystemEventInstancePeer::ID, $join_behavior);

		// symfony_behaviors behavior
		foreach (sfMixer::getCallables(self::getMixerPreSelectHook(__FUNCTION__)) as $sf_hook)
		{
		  call_user_func($sf_hook, 'BaseSystemEventInstanceMessagePeer', $criteria, $con);
		}

		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = SystemEventInstanceMessagePeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = SystemEventInstanceMessagePeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://www.propelorm.org/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {

				$cls = SystemEventInstanceMessagePeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				SystemEventInstanceMessagePeer::addInstanceToPool($obj1, $key1);
			} // if $obj1 already loaded

			$key2 = SystemEventInstancePeer::getPrimaryKeyHashFromRow($row, $startcol);
			if ($key2 !== null) {
				$obj2 = SystemEventInstancePeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$cls = SystemEventInstancePeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol);
					SystemEventInstancePeer::addInstanceToPool($obj2, $key2);
				} // if obj2 already loaded

				// Add the $obj1 (SystemEventInstanceMessage) to $obj2 (SystemEventInstance)
				$obj2->addSystemEventInstanceMessage($obj1);

			} // if joined row was not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Selects a collection of SystemEventInstanceMessage objects pre-filled with their SystemEventSubscription objects.
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of SystemEventInstanceMessage objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinSystemEventSubscription(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		SystemEventInstanceMessagePeer::addSelectColumns($criteria);
		$startcol = SystemEventInstanceMessagePeer::NUM_HYDRATE_COLUMNS;
		SystemEventSubscriptionPeer::addSelectColumns($criteria);

		$criteria->addJoin(SystemEventInstanceMessagePeer::SYSTEM_EVENT_SUBSCRIPTION_ID, SystemEventSubscriptionPeer::ID, $join_behavior);

		// symfony_behaviors behavior
		foreach (sfMixer::getCallables(self::getMixerPreSelectHook(__FUNCTION__)) as $sf_hook)
		{
		  call_user_func($sf_hook, 'BaseSystemEventInstanceMessagePeer', $criteria, $con);
		}

		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = SystemEventInstanceMessagePeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = SystemEventInstanceMessagePeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://www.propelorm.org/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {

				$cls = SystemEventInstanceMessagePeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				SystemEventInstanceMessagePeer::addInstanceToPool($obj1, $key1);
			} // if $obj1 already loaded

			$key2 = SystemEventSubscriptionPeer::getPrimaryKeyHashFromRow($row, $startcol);
			if ($key2 !== null) {
				$obj2 = SystemEventSubscriptionPeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$cls = SystemEventSubscriptionPeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol);
					SystemEventSubscriptionPeer::addInstanceToPool($obj2, $key2);
				} // if obj2 already loaded

				// Add the $obj1 (SystemEventInstanceMessage) to $obj2 (SystemEventSubscription)
				$obj2->addSystemEventInstanceMessage($obj1);

			} // if joined row was not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Returns the number of rows matching criteria, joining all related tables
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(SystemEventInstanceMessagePeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			SystemEventInstanceMessagePeer::addSelectColumns($criteria);
		}
		
		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
		
		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(SystemEventInstanceMessagePeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(SystemEventInstanceMessagePeer::SYSTEM_EVENT_INSTANCE_ID, SystemEventInstancePeer::ID, $join_behavior);

		$criteria->addJoin(SystemEventInstanceMessagePeer::SYSTEM_EVENT_SUBSCRIPTION_ID, SystemEventSubscriptionPeer::ID, $join_behavior);

		// symfony_behaviors behavior
		foreach (sfMixer::getCallables(self::getMixerPreSelectHook(__FUNCTION__)) as $sf_hook)
		{
		  call_user_func($sf_hook, 'BaseSystemEventInstanceMessagePeer', $criteria, $con);
		}

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}

	/**
	 * Selects a collection of SystemEventInstanceMessage objects pre-filled with all related objects.
	 *
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of SystemEventInstanceMessage objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		SystemEventInstanceMessagePeer::addSelectColumns($criteria);
		$startcol2 = SystemEventInstanceMessagePeer::NUM_HYDRATE_COLUMNS;

		SystemEventInstancePeer::addSelectColumns($criteria);
		$startcol3 = $startcol2 + SystemEventInstancePeer::NUM_HYDRATE_COLUMNS;

		SystemEventSubscriptionPeer::addSelectColumns($criteria);
		$startcol4 = $startcol3 + SystemEventSubscriptionPeer::NUM_HYDRATE_COLUMNS;

		$criteria->addJoin(SystemEventInstanceMessagePeer::SYSTEM_EVENT_INSTANCE_ID, SystemEventInstancePeer::ID, $join_behavior);

		$criteria->addJoin(SystemEventInstanceMessagePeer::SYSTEM_EVENT_SUBSCRIPTION_ID, SystemEventSubscriptionPeer::ID, $join_behavior);

		// symfony_behaviors behavior
		foreach (sfMixer::getCallables(self::getMixerPreSelectHook(__FUNCTION__)) as $sf_hook)
		{
		  call_user_func($sf_hook, 'BaseSystemEventInstanceMessagePeer', $criteria, $con);
		}

		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = SystemEventInstanceMessagePeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = SystemEventInstanceMessagePeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://www.propelorm.org/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {
				$cls = SystemEventInstanceMessagePeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				SystemEventInstanceMessagePeer::addInstanceToPool($obj1, $key1);
			} // if obj1 already loaded

			// Add objects for joined SystemEventInstance rows

			$key2 = SystemEventInstancePeer::getPrimaryKeyHashFromRow($row, $startcol2);
			if ($key2 !== null) {
				$obj2 = SystemEventInstancePeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$cls = SystemEventInstancePeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					SystemEventInstancePeer::addInstanceToPool($obj2, $key2);
				} // if obj2 loaded

				// Add the $obj1 (SystemEventInstanceMessage) to the collection in $obj2 (SystemEventInstance)
				$obj2->addSystemEventInstanceMessage($obj1);
			} // if joined row not null

			// Add objects for joined SystemEventSubscription rows

			$key3 = SystemEventSubscriptionPeer::getPrimaryKeyHashFromRow($row, $startcol3);
			if ($key3 !== null) {
				$obj3 = SystemEventSubscriptionPeer::getInstanceFromPool($key3);
				if (!$obj3) {

					$cls = SystemEventSubscriptionPeer::getOMClass(false);

					$obj3 = new $cls();
					$obj3->hydrate($row, $startcol3);
					SystemEventSubscriptionPeer::addInstanceToPool($obj3, $key3);
				} // if obj3 loaded

				// Add the $obj1 (SystemEventInstanceMessage) to the collection in $obj3 (SystemEventSubscription)
				$obj3->addSystemEventInstanceMessage($obj1);
			} // if joined row not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related SystemEventInstance table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptSystemEventInstance(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(SystemEventInstanceMessagePeer::TABLE_NAME);
		
		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			SystemEventInstanceMessagePeer::addSelectColumns($criteria);
		}
		
		$criteria->clearOrderByColumns(); // ORDER BY should not affect count
		
		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(SystemEventInstanceMessagePeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
		$criteria->addJoin(SystemEventInstanceMessagePeer::SYSTEM_EVENT_SUBSCRIPTION_ID, SystemEventSubscriptionPeer::ID, $join_behavior);

		// symfony_behaviors behavior
		foreach (sfMixer::getCallables(self::getMixerPreSelectHook(__FUNCTION__)) as $sf_hook)
		{
		  call_user_func($sf_hook, 'BaseSystemEventInstanceMessagePeer', $criteria, $con);
		}

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related SystemEventSubscription table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptSystemEventSubscription(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(SystemEventInstanceMessagePeer::TABLE_NAME);
		
		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			SystemEventInstanceMessagePeer::addSelectColumns($criteria);
		}
		
		$criteria->clearOrderByColumns(); // ORDER BY should not affect count
		
		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(SystemEventInstanceMessagePeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
		$criteria->addJoin(SystemEventInstanceMessagePeer::SYSTEM_EVENT_INSTANCE_ID, SystemEventInstancePeer::ID, $join_behavior);

		// symfony_behaviors behavior
		foreach (sfMixer::getCallables(self::getMixerPreSelectHook(__FUNCTION__)) as $sf_hook)
		{
		  call_user_func($sf_hook, 'BaseSystemEventInstanceMessagePeer', $criteria, $con);
		}

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}


	/**
	 * Selects a collection of SystemEventInstanceMessage objects pre-filled with all related objects except SystemEventInstance.
	 *
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of SystemEventInstanceMessage objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptSystemEventInstance(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		// $criteria->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		SystemEventInstanceMessagePeer::addSelectColumns($criteria);
		$startcol2 = SystemEventInstanceMessagePeer::NUM_HYDRATE_COLUMNS;

		SystemEventSubscriptionPeer::addSelectColumns($criteria);
		$startcol3 = $startcol2 + SystemEventSubscriptionPeer::NUM_HYDRATE_COLUMNS;

		$criteria->addJoin(SystemEventInstanceMessagePeer::SYSTEM_EVENT_SUBSCRIPTION_ID, SystemEventSubscriptionPeer::ID, $join_behavior);

		// symfony_behaviors behavior
		foreach (sfMixer::getCallables(self::getMixerPreSelectHook(__FUNCTION__)) as $sf_hook)
		{
		  call_user_func($sf_hook, 'BaseSystemEventInstanceMessagePeer', $criteria, $con);
		}


		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = SystemEventInstanceMessagePeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = SystemEventInstanceMessagePeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://www.propelorm.org/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {
				$cls = SystemEventInstanceMessagePeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				SystemEventInstanceMessagePeer::addInstanceToPool($obj1, $key1);
			} // if obj1 already loaded

				// Add objects for joined SystemEventSubscription rows

				$key2 = SystemEventSubscriptionPeer::getPrimaryKeyHashFromRow($row, $startcol2);
				if ($key2 !== null) {
					$obj2 = SystemEventSubscriptionPeer::getInstanceFromPool($key2);
					if (!$obj2) {
	
						$cls = SystemEventSubscriptionPeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					SystemEventSubscriptionPeer::addInstanceToPool($obj2, $key2);
				} // if $obj2 already loaded

				// Add the $obj1 (SystemEventInstanceMessage) to the collection in $obj2 (SystemEventSubscription)
				$obj2->addSystemEventInstanceMessage($obj1);

			} // if joined row is not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Selects a collection of SystemEventInstanceMessage objects pre-filled with all related objects except SystemEventSubscription.
	 *
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of SystemEventInstanceMessage objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptSystemEventSubscription(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		// $criteria->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		SystemEventInstanceMessagePeer::addSelectColumns($criteria);
		$startcol2 = SystemEventInstanceMessagePeer::NUM_HYDRATE_COLUMNS;

		SystemEventInstancePeer::addSelectColumns($criteria);
		$startcol3 = $startcol2 + SystemEventInstancePeer::NUM_HYDRATE_COLUMNS;

		$criteria->addJoin(SystemEventInstanceMessagePeer::SYSTEM_EVENT_INSTANCE_ID, SystemEventInstancePeer::ID, $join_behavior);

		// symfony_behaviors behavior
		foreach (sfMixer::getCallables(self::getMixerPreSelectHook(__FUNCTION__)) as $sf_hook)
		{
		  call_user_func($sf_hook, 'BaseSystemEventInstanceMessagePeer', $criteria, $con);
		}


		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = SystemEventInstanceMessagePeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = SystemEventInstanceMessagePeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://www.propelorm.org/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {
				$cls = SystemEventInstanceMessagePeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				SystemEventInstanceMessagePeer::addInstanceToPool($obj1, $key1);
			} // if obj1 already loaded

				// Add objects for joined SystemEventInstance rows

				$key2 = SystemEventInstancePeer::getPrimaryKeyHashFromRow($row, $startcol2);
				if ($key2 !== null) {
					$obj2 = SystemEventInstancePeer::getInstanceFromPool($key2);
					if (!$obj2) {
	
						$cls = SystemEventInstancePeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					SystemEventInstancePeer::addInstanceToPool($obj2, $key2);
				} // if $obj2 already loaded

				// Add the $obj1 (SystemEventInstanceMessage) to the collection in $obj2 (SystemEventInstance)
				$obj2->addSystemEventInstanceMessage($obj1);

			} // if joined row is not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}

	/**
	 * Returns the TableMap related to this peer.
	 * This method is not needed for general use but a specific application could have a need.
	 * @return     TableMap
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	/**
	 * Add a TableMap instance to the database for this peer class.
	 */
	public static function buildTableMap()
	{
	  $dbMap = Propel::getDatabaseMap(BaseSystemEventInstanceMessagePeer::DATABASE_NAME);
	  if (!$dbMap->hasTable(BaseSystemEventInstanceMessagePeer::TABLE_NAME))
	  {
	    $dbMap->addTableObject(new SystemEventInstanceMessageTableMap());
	  }
	}

	/**
	 * The class that the Peer will make instances of.
	 *
	 * If $withPrefix is true, the returned path
	 * uses a dot-path notation which is tranalted into a path
	 * relative to a location on the PHP include_path.
	 * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
	 *
	 * @param      boolean $withPrefix Whether or not to return the path with the class name
	 * @return     string path.to.ClassName
	 */
	public static function getOMClass($withPrefix = true)
	{
		return $withPrefix ? SystemEventInstanceMessagePeer::CLASS_DEFAULT : SystemEventInstanceMessagePeer::OM_CLASS;
	}

	/**
	 * Method perform an INSERT on the database, given a SystemEventInstanceMessage or Criteria object.
	 *
	 * @param      mixed $values Criteria or SystemEventInstanceMessage object containing data that is used to create the INSERT statement.
	 * @param      PropelPDO $con the PropelPDO connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(SystemEventInstanceMessagePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} else {
			$criteria = $values->buildCriteria(); // build Criteria from SystemEventInstanceMessage object
		}

		if ($criteria->containsKey(SystemEventInstanceMessagePeer::ID) && $criteria->keyContainsValue(SystemEventInstanceMessagePeer::ID) ) {
			throw new PropelException('Cannot insert a value for auto-increment primary key ('.SystemEventInstanceMessagePeer::ID.')');
		}


		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		try {
			// use transaction because $criteria could contain info
			// for more than one table (I guess, conceivably)
			$con->beginTransaction();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollBack();
			throw $e;
		}

		return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a SystemEventInstanceMessage or Criteria object.
	 *
	 * @param      mixed $values Criteria or SystemEventInstanceMessage object containing data that is used to create the UPDATE statement.
	 * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(SystemEventInstanceMessagePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity

			$comparison = $criteria->getComparison(SystemEventInstanceMessagePeer::ID);
			$value = $criteria->remove(SystemEventInstanceMessagePeer::ID);
			if ($value) {
				$selectCriteria->add(SystemEventInstanceMessagePeer::ID, $value, $comparison);
			} else {
				$selectCriteria->setPrimaryTableName(SystemEventInstanceMessagePeer::TABLE_NAME);
			}

		} else { // $values is SystemEventInstanceMessage object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		return BasePeer::doUpdate($selectCriteria, $criteria, $con);
	}

	/**
	 * Method to DELETE all rows from the system_event_instance_message table.
	 *
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 */
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(SystemEventInstanceMessagePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		$affectedRows = 0; // initialize var to track total num of affected rows
		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->beginTransaction();
			$affectedRows += BasePeer::doDeleteAll(SystemEventInstanceMessagePeer::TABLE_NAME, $con, SystemEventInstanceMessagePeer::DATABASE_NAME);
			// Because this db requires some delete cascade/set null emulation, we have to
			// clear the cached instance *after* the emulation has happened (since
			// instances get re-added by the select statement contained therein).
			SystemEventInstanceMessagePeer::clearInstancePool();
			SystemEventInstanceMessagePeer::clearRelatedInstancePool();
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a SystemEventInstanceMessage or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or SystemEventInstanceMessage object or primary key or array of primary keys
	 *              which is used to create the DELETE statement
	 * @param      PropelPDO $con the connection to use
	 * @return     int 	The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
	 *				if supported by native driver or if emulated using Propel.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	 public static function doDelete($values, PropelPDO $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(SystemEventInstanceMessagePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			// invalidate the cache for all objects of this type, since we have no
			// way of knowing (without running a query) what objects should be invalidated
			// from the cache based on this Criteria.
			SystemEventInstanceMessagePeer::clearInstancePool();
			// rename for clarity
			$criteria = clone $values;
		} elseif ($values instanceof SystemEventInstanceMessage) { // it's a model object
			// invalidate the cache for this single object
			SystemEventInstanceMessagePeer::removeInstanceFromPool($values);
			// create criteria based on pk values
			$criteria = $values->buildPkeyCriteria();
		} else { // it's a primary key, or an array of pks
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(SystemEventInstanceMessagePeer::ID, (array) $values, Criteria::IN);
			// invalidate the cache for this object(s)
			foreach ((array) $values as $singleval) {
				SystemEventInstanceMessagePeer::removeInstanceFromPool($singleval);
			}
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->beginTransaction();
			
			$affectedRows += BasePeer::doDelete($criteria, $con);
			SystemEventInstanceMessagePeer::clearRelatedInstancePool();
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Validates all modified columns of given SystemEventInstanceMessage object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      SystemEventInstanceMessage $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate($obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(SystemEventInstanceMessagePeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(SystemEventInstanceMessagePeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach ($cols as $colName) {
				if ($tableMap->containsColumn($colName)) {
					$get = 'get' . $tableMap->getColumn($colName)->getPhpName();
					$columns[$colName] = $obj->$get();
				}
			}
		} else {

		}

		return BasePeer::doValidate(SystemEventInstanceMessagePeer::DATABASE_NAME, SystemEventInstanceMessagePeer::TABLE_NAME, $columns);
	}

	/**
	 * Retrieve a single object by pkey.
	 *
	 * @param      int $pk the primary key.
	 * @param      PropelPDO $con the connection to use
	 * @return     SystemEventInstanceMessage
	 */
	public static function retrieveByPK($pk, PropelPDO $con = null)
	{

		if (null !== ($obj = SystemEventInstanceMessagePeer::getInstanceFromPool((string) $pk))) {
			return $obj;
		}

		if ($con === null) {
			$con = Propel::getConnection(SystemEventInstanceMessagePeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria = new Criteria(SystemEventInstanceMessagePeer::DATABASE_NAME);
		$criteria->add(SystemEventInstanceMessagePeer::ID, $pk);

		$v = SystemEventInstanceMessagePeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	/**
	 * Retrieve multiple objects by pkey.
	 *
	 * @param      array $pks List of primary keys
	 * @param      PropelPDO $con the connection to use
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function retrieveByPKs($pks, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(SystemEventInstanceMessagePeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria(SystemEventInstanceMessagePeer::DATABASE_NAME);
			$criteria->add(SystemEventInstanceMessagePeer::ID, $pks, Criteria::IN);
			$objs = SystemEventInstanceMessagePeer::doSelect($criteria, $con);
		}
		return $objs;
	}

	// symfony behavior
	
	/**
	 * Returns an array of arrays that contain columns in each unique index.
	 *
	 * @return array
	 */
	static public function getUniqueColumnNames()
	{
	  return array();
	}

	// symfony_behaviors behavior
	
	/**
	 * Returns the name of the hook to call from inside the supplied method.
	 *
	 * @param string $method The calling method
	 *
	 * @return string A hook name for {@link sfMixer}
	 *
	 * @throws LogicException If the method name is not recognized
	 */
	static private function getMixerPreSelectHook($method)
	{
	  if (preg_match('/^do(Select|Count)(Join(All(Except)?)?|Stmt)?/', $method, $match))
	  {
	    return sprintf('BaseSystemEventInstanceMessagePeer:%s:%1$s', 'Count' == $match[1] ? 'doCount' : $match[0]);
	  }
	
	  throw new LogicException(sprintf('Unrecognized function "%s"', $method));
	}

} // BaseSystemEventInstanceMessagePeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseSystemEventInstanceMessagePeer::buildTableMap();

