<?php


/**
 * Base class that represents a row from the 'system_event_instance_message' table.
 *
 * 
 *
 * @package    propel.generator.plugins.sfAltumoPlugin.lib.model.om
 */
abstract class BaseSystemEventInstanceMessage extends BaseObject  implements Persistent
{

	/**
	 * Peer class name
	 */
  const PEER = 'SystemEventInstanceMessagePeer';

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        SystemEventInstanceMessagePeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the system_event_instance_id field.
	 * @var        int
	 */
	protected $system_event_instance_id;

	/**
	 * The value for the system_event_subscription_id field.
	 * @var        int
	 */
	protected $system_event_subscription_id;

	/**
	 * The value for the received field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $received;

	/**
	 * The value for the received_at field.
	 * @var        string
	 */
	protected $received_at;

	/**
	 * The value for the status_message field.
	 * @var        string
	 */
	protected $status_message;

	/**
	 * The value for the created_at field.
	 * @var        string
	 */
	protected $created_at;

	/**
	 * The value for the updated_at field.
	 * @var        string
	 */
	protected $updated_at;

	/**
	 * @var        SystemEventInstance
	 */
	protected $aSystemEventInstance;

	/**
	 * @var        SystemEventSubscription
	 */
	protected $aSystemEventSubscription;

	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInSave = false;

	/**
	 * Flag to prevent endless validation loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInValidation = false;

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->received = false;
	}

	/**
	 * Initializes internal state of BaseSystemEventInstanceMessage object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	/**
	 * Get the [id] column value.
	 * 
	 * @return     int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Get the [system_event_instance_id] column value.
	 * 
	 * @return     int
	 */
	public function getSystemEventInstanceId()
	{
		return $this->system_event_instance_id;
	}

	/**
	 * Get the [system_event_subscription_id] column value.
	 * 
	 * @return     int
	 */
	public function getSystemEventSubscriptionId()
	{
		return $this->system_event_subscription_id;
	}

	/**
	 * Get the [received] column value.
	 * 
	 * @return     boolean
	 */
	public function getReceived()
	{
		return $this->received;
	}

	/**
	 * Get the [optionally formatted] temporal [received_at] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getReceivedAt($format = 'Y-m-d H:i:s')
	{
		if ($this->received_at === null) {
			return null;
		}


		if ($this->received_at === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->received_at);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->received_at, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [status_message] column value.
	 * 
	 * @return     string
	 */
	public function getStatusMessage()
	{
		return $this->status_message;
	}

	/**
	 * Get the [optionally formatted] temporal [created_at] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getCreatedAt($format = 'Y-m-d H:i:s')
	{
		if ($this->created_at === null) {
			return null;
		}


		if ($this->created_at === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->created_at);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->created_at, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [optionally formatted] temporal [updated_at] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getUpdatedAt($format = 'Y-m-d H:i:s')
	{
		if ($this->updated_at === null) {
			return null;
		}


		if ($this->updated_at === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->updated_at);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->updated_at, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     SystemEventInstanceMessage The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = SystemEventInstanceMessagePeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [system_event_instance_id] column.
	 * 
	 * @param      int $v new value
	 * @return     SystemEventInstanceMessage The current object (for fluent API support)
	 */
	public function setSystemEventInstanceId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->system_event_instance_id !== $v) {
			$this->system_event_instance_id = $v;
			$this->modifiedColumns[] = SystemEventInstanceMessagePeer::SYSTEM_EVENT_INSTANCE_ID;
		}

		if ($this->aSystemEventInstance !== null && $this->aSystemEventInstance->getId() !== $v) {
			$this->aSystemEventInstance = null;
		}

		return $this;
	} // setSystemEventInstanceId()

	/**
	 * Set the value of [system_event_subscription_id] column.
	 * 
	 * @param      int $v new value
	 * @return     SystemEventInstanceMessage The current object (for fluent API support)
	 */
	public function setSystemEventSubscriptionId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->system_event_subscription_id !== $v) {
			$this->system_event_subscription_id = $v;
			$this->modifiedColumns[] = SystemEventInstanceMessagePeer::SYSTEM_EVENT_SUBSCRIPTION_ID;
		}

		if ($this->aSystemEventSubscription !== null && $this->aSystemEventSubscription->getId() !== $v) {
			$this->aSystemEventSubscription = null;
		}

		return $this;
	} // setSystemEventSubscriptionId()

	/**
	 * Set the value of [received] column.
	 * 
	 * @param      boolean $v new value
	 * @return     SystemEventInstanceMessage The current object (for fluent API support)
	 */
	public function setReceived($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->received !== $v || $this->isNew()) {
			$this->received = $v;
			$this->modifiedColumns[] = SystemEventInstanceMessagePeer::RECEIVED;
		}

		return $this;
	} // setReceived()

	/**
	 * Sets the value of [received_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     SystemEventInstanceMessage The current object (for fluent API support)
	 */
	public function setReceivedAt($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->received_at !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->received_at !== null && $tmpDt = new DateTime($this->received_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->received_at = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = SystemEventInstanceMessagePeer::RECEIVED_AT;
			}
		} // if either are not null

		return $this;
	} // setReceivedAt()

	/**
	 * Set the value of [status_message] column.
	 * 
	 * @param      string $v new value
	 * @return     SystemEventInstanceMessage The current object (for fluent API support)
	 */
	public function setStatusMessage($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->status_message !== $v) {
			$this->status_message = $v;
			$this->modifiedColumns[] = SystemEventInstanceMessagePeer::STATUS_MESSAGE;
		}

		return $this;
	} // setStatusMessage()

	/**
	 * Sets the value of [created_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     SystemEventInstanceMessage The current object (for fluent API support)
	 */
	public function setCreatedAt($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->created_at !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->created_at = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = SystemEventInstanceMessagePeer::CREATED_AT;
			}
		} // if either are not null

		return $this;
	} // setCreatedAt()

	/**
	 * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     SystemEventInstanceMessage The current object (for fluent API support)
	 */
	public function setUpdatedAt($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->updated_at !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->updated_at = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = SystemEventInstanceMessagePeer::UPDATED_AT;
			}
		} // if either are not null

		return $this;
	} // setUpdatedAt()

	/**
	 * Indicates whether the columns in this object are only set to default values.
	 *
	 * This method can be used in conjunction with isModified() to indicate whether an object is both
	 * modified _and_ has some values set which are non-default.
	 *
	 * @return     boolean Whether the columns in this object are only been set with default values.
	 */
	public function hasOnlyDefaultValues()
	{
			if ($this->received !== false) {
				return false;
			}

		// otherwise, everything was equal, so return TRUE
		return true;
	} // hasOnlyDefaultValues()

	/**
	 * Hydrates (populates) the object variables with values from the database resultset.
	 *
	 * An offset (0-based "start column") is specified so that objects can be hydrated
	 * with a subset of the columns in the resultset rows.  This is needed, for example,
	 * for results of JOIN queries where the resultset row includes columns from two or
	 * more tables.
	 *
	 * @param      array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
	 * @param      int $startcol 0-based offset column which indicates which restultset column to start with.
	 * @param      boolean $rehydrate Whether this object is being re-hydrated from the database.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->system_event_instance_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->system_event_subscription_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
			$this->received = ($row[$startcol + 3] !== null) ? (boolean) $row[$startcol + 3] : null;
			$this->received_at = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->status_message = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->created_at = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->updated_at = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			return $startcol + 8; // 8 = SystemEventInstanceMessagePeer::NUM_COLUMNS - SystemEventInstanceMessagePeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating SystemEventInstanceMessage object", $e);
		}
	}

	/**
	 * Checks and repairs the internal consistency of the object.
	 *
	 * This method is executed after an already-instantiated object is re-hydrated
	 * from the database.  It exists to check any foreign keys to make sure that
	 * the objects related to the current object are correct based on foreign key.
	 *
	 * You can override this method in the stub class, but you should always invoke
	 * the base method from the overridden method (i.e. parent::ensureConsistency()),
	 * in case your model changes.
	 *
	 * @throws     PropelException
	 */
	public function ensureConsistency()
	{

		if ($this->aSystemEventInstance !== null && $this->system_event_instance_id !== $this->aSystemEventInstance->getId()) {
			$this->aSystemEventInstance = null;
		}
		if ($this->aSystemEventSubscription !== null && $this->system_event_subscription_id !== $this->aSystemEventSubscription->getId()) {
			$this->aSystemEventSubscription = null;
		}
	} // ensureConsistency

	/**
	 * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
	 *
	 * This will only work if the object has been saved and has a valid primary key set.
	 *
	 * @param      boolean $deep (optional) Whether to also de-associated any related objects.
	 * @param      PropelPDO $con (optional) The PropelPDO connection to use.
	 * @return     void
	 * @throws     PropelException - if this object is deleted, unsaved or doesn't have pk match in db
	 */
	public function reload($deep = false, PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("Cannot reload a deleted object.");
		}

		if ($this->isNew()) {
			throw new PropelException("Cannot reload an unsaved object.");
		}

		if ($con === null) {
			$con = Propel::getConnection(SystemEventInstanceMessagePeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = SystemEventInstanceMessagePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aSystemEventInstance = null;
			$this->aSystemEventSubscription = null;
		} // if (deep)
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      PropelPDO $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(SystemEventInstanceMessagePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseSystemEventInstanceMessage:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			    return;
			  }
			}

			if ($ret) {
				SystemEventInstanceMessageQuery::create()
					->filterByPrimaryKey($this->getPrimaryKey())
					->delete($con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseSystemEventInstanceMessage:delete:post') as $callable)
				{
				  call_user_func($callable, $this, $con);
				}

				$con->commit();
				$this->setDeleted(true);
			} else {
				$con->commit();
			}
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Persists this object to the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All modified related objects will also be persisted in the doSave()
	 * method.  This method wraps all precipitate database operations in a
	 * single transaction.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(SystemEventInstanceMessagePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseSystemEventInstanceMessage:save:pre') as $callable)
			{
			  if (is_integer($affectedRows = call_user_func($callable, $this, $con)))
			  {
			  	$con->commit();
			    return $affectedRows;
			  }
			}

			// symfony_timestampable behavior
			if ($this->isModified() && !$this->isColumnModified(SystemEventInstanceMessagePeer::UPDATED_AT))
			{
			  $this->setUpdatedAt(time());
			}

			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
				// symfony_timestampable behavior
				if (!$this->isColumnModified(SystemEventInstanceMessagePeer::CREATED_AT))
				{
				  $this->setCreatedAt(time());
				}

			} else {
				$ret = $ret && $this->preUpdate($con);
			}
			if ($ret) {
				$affectedRows = $this->doSave($con);
				if ($isInsert) {
					$this->postInsert($con);
				} else {
					$this->postUpdate($con);
				}
				$this->postSave($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseSystemEventInstanceMessage:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				SystemEventInstanceMessagePeer::addInstanceToPool($this);
			} else {
				$affectedRows = 0;
			}
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Performs the work of inserting or updating the row in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave(PropelPDO $con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;

			// We call the save method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aSystemEventInstance !== null) {
				if ($this->aSystemEventInstance->isModified() || $this->aSystemEventInstance->isNew()) {
					$affectedRows += $this->aSystemEventInstance->save($con);
				}
				$this->setSystemEventInstance($this->aSystemEventInstance);
			}

			if ($this->aSystemEventSubscription !== null) {
				if ($this->aSystemEventSubscription->isModified() || $this->aSystemEventSubscription->isNew()) {
					$affectedRows += $this->aSystemEventSubscription->save($con);
				}
				$this->setSystemEventSubscription($this->aSystemEventSubscription);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = SystemEventInstanceMessagePeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$criteria = $this->buildCriteria();
					if ($criteria->keyContainsValue(SystemEventInstanceMessagePeer::ID) ) {
						throw new PropelException('Cannot insert a value for auto-increment primary key ('.SystemEventInstanceMessagePeer::ID.')');
					}

					$pk = BasePeer::doInsert($criteria, $con);
					$affectedRows += 1;
					$this->setId($pk);  //[IMV] update autoincrement primary key
					$this->setNew(false);
				} else {
					$affectedRows += SystemEventInstanceMessagePeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			$this->alreadyInSave = false;

		}
		return $affectedRows;
	} // doSave()

	/**
	 * Array of ValidationFailed objects.
	 * @var        array ValidationFailed[]
	 */
	protected $validationFailures = array();

	/**
	 * Gets any ValidationFailed objects that resulted from last call to validate().
	 *
	 *
	 * @return     array ValidationFailed[]
	 * @see        validate()
	 */
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	/**
	 * Validates the objects modified field values and all objects related to this table.
	 *
	 * If $columns is either a column name or an array of column names
	 * only those columns are validated.
	 *
	 * @param      mixed $columns Column name or an array of column names.
	 * @return     boolean Whether all columns pass validation.
	 * @see        doValidate()
	 * @see        getValidationFailures()
	 */
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	/**
	 * This function performs the validation work for complex object models.
	 *
	 * In addition to checking the current object, all related objects will
	 * also be validated.  If all pass then <code>true</code> is returned; otherwise
	 * an aggreagated array of ValidationFailed objects will be returned.
	 *
	 * @param      array $columns Array of column names to validate.
	 * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
	 */
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			// We call the validate method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aSystemEventInstance !== null) {
				if (!$this->aSystemEventInstance->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aSystemEventInstance->getValidationFailures());
				}
			}

			if ($this->aSystemEventSubscription !== null) {
				if (!$this->aSystemEventSubscription->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aSystemEventSubscription->getValidationFailures());
				}
			}


			if (($retval = SystemEventInstanceMessagePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	/**
	 * Retrieves a field from the object by name passed in as a string.
	 *
	 * @param      string $name name
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = SystemEventInstanceMessagePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	/**
	 * Retrieves a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @return     mixed Value of field at $pos
	 */
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getSystemEventInstanceId();
				break;
			case 2:
				return $this->getSystemEventSubscriptionId();
				break;
			case 3:
				return $this->getReceived();
				break;
			case 4:
				return $this->getReceivedAt();
				break;
			case 5:
				return $this->getStatusMessage();
				break;
			case 6:
				return $this->getCreatedAt();
				break;
			case 7:
				return $this->getUpdatedAt();
				break;
			default:
				return null;
				break;
		} // switch()
	}

	/**
	 * Exports the object as an array.
	 *
	 * You can specify the key type of the array by passing one of the class
	 * type constants.
	 *
	 * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
	 *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. 
	 *                    Defaults to BasePeer::TYPE_PHPNAME.
	 * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
	 * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
	 *
	 * @return    array an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $includeForeignObjects = false)
	{
		$keys = SystemEventInstanceMessagePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getSystemEventInstanceId(),
			$keys[2] => $this->getSystemEventSubscriptionId(),
			$keys[3] => $this->getReceived(),
			$keys[4] => $this->getReceivedAt(),
			$keys[5] => $this->getStatusMessage(),
			$keys[6] => $this->getCreatedAt(),
			$keys[7] => $this->getUpdatedAt(),
		);
		if ($includeForeignObjects) {
			if (null !== $this->aSystemEventInstance) {
				$result['SystemEventInstance'] = $this->aSystemEventInstance->toArray($keyType, $includeLazyLoadColumns, true);
			}
			if (null !== $this->aSystemEventSubscription) {
				$result['SystemEventSubscription'] = $this->aSystemEventSubscription->toArray($keyType, $includeLazyLoadColumns, true);
			}
		}
		return $result;
	}

	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name peer name
	 * @param      mixed $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     void
	 */
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = SystemEventInstanceMessagePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	/**
	 * Sets a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @param      mixed $value field value
	 * @return     void
	 */
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setSystemEventInstanceId($value);
				break;
			case 2:
				$this->setSystemEventSubscriptionId($value);
				break;
			case 3:
				$this->setReceived($value);
				break;
			case 4:
				$this->setReceivedAt($value);
				break;
			case 5:
				$this->setStatusMessage($value);
				break;
			case 6:
				$this->setCreatedAt($value);
				break;
			case 7:
				$this->setUpdatedAt($value);
				break;
		} // switch()
	}

	/**
	 * Populates the object using an array.
	 *
	 * This is particularly useful when populating an object from one of the
	 * request arrays (e.g. $_POST).  This method goes through the column
	 * names, checking to see whether a matching key exists in populated
	 * array. If so the setByName() method is called for that column.
	 *
	 * You can specify the key type of the array by additionally passing one
	 * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
	 * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
	 * The default key type is the column's phpname (e.g. 'AuthorId')
	 *
	 * @param      array  $arr     An array to populate the object from.
	 * @param      string $keyType The type of keys the array uses.
	 * @return     void
	 */
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = SystemEventInstanceMessagePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setSystemEventInstanceId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setSystemEventSubscriptionId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setReceived($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setReceivedAt($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setStatusMessage($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setCreatedAt($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setUpdatedAt($arr[$keys[7]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(SystemEventInstanceMessagePeer::DATABASE_NAME);

		if ($this->isColumnModified(SystemEventInstanceMessagePeer::ID)) $criteria->add(SystemEventInstanceMessagePeer::ID, $this->id);
		if ($this->isColumnModified(SystemEventInstanceMessagePeer::SYSTEM_EVENT_INSTANCE_ID)) $criteria->add(SystemEventInstanceMessagePeer::SYSTEM_EVENT_INSTANCE_ID, $this->system_event_instance_id);
		if ($this->isColumnModified(SystemEventInstanceMessagePeer::SYSTEM_EVENT_SUBSCRIPTION_ID)) $criteria->add(SystemEventInstanceMessagePeer::SYSTEM_EVENT_SUBSCRIPTION_ID, $this->system_event_subscription_id);
		if ($this->isColumnModified(SystemEventInstanceMessagePeer::RECEIVED)) $criteria->add(SystemEventInstanceMessagePeer::RECEIVED, $this->received);
		if ($this->isColumnModified(SystemEventInstanceMessagePeer::RECEIVED_AT)) $criteria->add(SystemEventInstanceMessagePeer::RECEIVED_AT, $this->received_at);
		if ($this->isColumnModified(SystemEventInstanceMessagePeer::STATUS_MESSAGE)) $criteria->add(SystemEventInstanceMessagePeer::STATUS_MESSAGE, $this->status_message);
		if ($this->isColumnModified(SystemEventInstanceMessagePeer::CREATED_AT)) $criteria->add(SystemEventInstanceMessagePeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(SystemEventInstanceMessagePeer::UPDATED_AT)) $criteria->add(SystemEventInstanceMessagePeer::UPDATED_AT, $this->updated_at);

		return $criteria;
	}

	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return     Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(SystemEventInstanceMessagePeer::DATABASE_NAME);
		$criteria->add(SystemEventInstanceMessagePeer::ID, $this->id);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	/**
	 * Generic method to set the primary key (id column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	/**
	 * Returns true if the primary key for this object is null.
	 * @return     boolean
	 */
	public function isPrimaryKeyNull()
	{
		return null === $this->getId();
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of SystemEventInstanceMessage (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{
		$copyObj->setSystemEventInstanceId($this->system_event_instance_id);
		$copyObj->setSystemEventSubscriptionId($this->system_event_subscription_id);
		$copyObj->setReceived($this->received);
		$copyObj->setReceivedAt($this->received_at);
		$copyObj->setStatusMessage($this->status_message);
		$copyObj->setCreatedAt($this->created_at);
		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setNew(true);
		$copyObj->setId(NULL); // this is a auto-increment column, so set to default value
	}

	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return     SystemEventInstanceMessage Clone of current object.
	 * @throws     PropelException
	 */
	public function copy($deepCopy = false)
	{
		// we use get_class(), because this might be a subclass
		$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	/**
	 * Returns a peer instance associated with this om.
	 *
	 * Since Peer classes are not to have any instance attributes, this method returns the
	 * same instance for all member of this class. The method could therefore
	 * be static, but this would prevent one from overriding the behavior.
	 *
	 * @return     SystemEventInstanceMessagePeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new SystemEventInstanceMessagePeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a SystemEventInstance object.
	 *
	 * @param      SystemEventInstance $v
	 * @return     SystemEventInstanceMessage The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setSystemEventInstance(SystemEventInstance $v = null)
	{
		if ($v === null) {
			$this->setSystemEventInstanceId(NULL);
		} else {
			$this->setSystemEventInstanceId($v->getId());
		}

		$this->aSystemEventInstance = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the SystemEventInstance object, it will not be re-added.
		if ($v !== null) {
			$v->addSystemEventInstanceMessage($this);
		}

		return $this;
	}


	/**
	 * Get the associated SystemEventInstance object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     SystemEventInstance The associated SystemEventInstance object.
	 * @throws     PropelException
	 */
	public function getSystemEventInstance(PropelPDO $con = null)
	{
		if ($this->aSystemEventInstance === null && ($this->system_event_instance_id !== null)) {
			$this->aSystemEventInstance = SystemEventInstanceQuery::create()->findPk($this->system_event_instance_id, $con);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aSystemEventInstance->addSystemEventInstanceMessages($this);
			 */
		}
		return $this->aSystemEventInstance;
	}

	/**
	 * Declares an association between this object and a SystemEventSubscription object.
	 *
	 * @param      SystemEventSubscription $v
	 * @return     SystemEventInstanceMessage The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setSystemEventSubscription(SystemEventSubscription $v = null)
	{
		if ($v === null) {
			$this->setSystemEventSubscriptionId(NULL);
		} else {
			$this->setSystemEventSubscriptionId($v->getId());
		}

		$this->aSystemEventSubscription = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the SystemEventSubscription object, it will not be re-added.
		if ($v !== null) {
			$v->addSystemEventInstanceMessage($this);
		}

		return $this;
	}


	/**
	 * Get the associated SystemEventSubscription object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     SystemEventSubscription The associated SystemEventSubscription object.
	 * @throws     PropelException
	 */
	public function getSystemEventSubscription(PropelPDO $con = null)
	{
		if ($this->aSystemEventSubscription === null && ($this->system_event_subscription_id !== null)) {
			$this->aSystemEventSubscription = SystemEventSubscriptionQuery::create()->findPk($this->system_event_subscription_id, $con);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aSystemEventSubscription->addSystemEventInstanceMessages($this);
			 */
		}
		return $this->aSystemEventSubscription;
	}

	/**
	 * Clears the current object and sets all attributes to their default values
	 */
	public function clear()
	{
		$this->id = null;
		$this->system_event_instance_id = null;
		$this->system_event_subscription_id = null;
		$this->received = null;
		$this->received_at = null;
		$this->status_message = null;
		$this->created_at = null;
		$this->updated_at = null;
		$this->alreadyInSave = false;
		$this->alreadyInValidation = false;
		$this->clearAllReferences();
		$this->applyDefaultValues();
		$this->resetModified();
		$this->setNew(true);
		$this->setDeleted(false);
	}

	/**
	 * Resets all collections of referencing foreign keys.
	 *
	 * This method is a user-space workaround for PHP's inability to garbage collect objects
	 * with circular references.  This is currently necessary when using Propel in certain
	 * daemon or large-volumne/high-memory operations.
	 *
	 * @param      boolean $deep Whether to also clear the references on all associated objects.
	 */
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
		} // if ($deep)

		$this->aSystemEventInstance = null;
		$this->aSystemEventSubscription = null;
	}

	/**
	 * Catches calls to virtual methods
	 */
	public function __call($name, $params)
	{
		// symfony_behaviors behavior
		if ($callable = sfMixer::getCallable('BaseSystemEventInstanceMessage:' . $name))
		{
		  array_unshift($params, $this);
		  return call_user_func_array($callable, $params);
		}

		if (preg_match('/get(\w+)/', $name, $matches)) {
			$virtualColumn = $matches[1];
			if ($this->hasVirtualColumn($virtualColumn)) {
				return $this->getVirtualColumn($virtualColumn);
			}
			// no lcfirst in php<5.3...
			$virtualColumn[0] = strtolower($virtualColumn[0]);
			if ($this->hasVirtualColumn($virtualColumn)) {
				return $this->getVirtualColumn($virtualColumn);
			}
		}
		return parent::__call($name, $params);
	}

} // BaseSystemEventInstanceMessage
