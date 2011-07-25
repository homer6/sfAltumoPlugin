<?php


/**
 * Base class that represents a row from the 'contact_information' table.
 *
 * 
 *
 * @package    propel.generator.plugins.sfAltumoPlugin.lib.model.om
 */
abstract class BaseContactInformation extends BaseObject  implements Persistent
{

	/**
	 * Peer class name
	 */
	const PEER = 'ContactInformationPeer';

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        ContactInformationPeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the first_name field.
	 * @var        string
	 */
	protected $first_name;

	/**
	 * The value for the last_name field.
	 * @var        string
	 */
	protected $last_name;

	/**
	 * The value for the email_address field.
	 * @var        string
	 */
	protected $email_address;

	/**
	 * The value for the phone_main_number field.
	 * @var        string
	 */
	protected $phone_main_number;

	/**
	 * The value for the phone_other_number field.
	 * @var        string
	 */
	protected $phone_other_number;

	/**
	 * The value for the mailing_address field.
	 * @var        string
	 */
	protected $mailing_address;

	/**
	 * The value for the city field.
	 * @var        string
	 */
	protected $city;

	/**
	 * The value for the state_id field.
	 * @var        int
	 */
	protected $state_id;

	/**
	 * The value for the cxd field.
	 * @var        int
	 */
	protected $cxd;

	/**
	 * The value for the zip_code field.
	 * @var        string
	 */
	protected $zip_code;

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
	 * @var        State
	 */
	protected $aState;

	/**
	 * @var        array User[] Collection to store aggregation of User objects.
	 */
	protected $collUsers;

	/**
	 * @var        array Client[] Collection to store aggregation of Client objects.
	 */
	protected $collClientsRelatedByDefaultBillingContactInformationId;

	/**
	 * @var        array Client[] Collection to store aggregation of Client objects.
	 */
	protected $collClientsRelatedByDefaultShippingContactInformationId;

	/**
	 * @var        array Order[] Collection to store aggregation of Order objects.
	 */
	protected $collOrders;

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
	 * Get the [id] column value.
	 * 
	 * @return     int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Get the [first_name] column value.
	 * 
	 * @return     string
	 */
	public function getFirstName()
	{
		return $this->first_name;
	}

	/**
	 * Get the [last_name] column value.
	 * 
	 * @return     string
	 */
	public function getLastName()
	{
		return $this->last_name;
	}

	/**
	 * Get the [email_address] column value.
	 * 
	 * @return     string
	 */
	public function getEmailAddress()
	{
		return $this->email_address;
	}

	/**
	 * Get the [phone_main_number] column value.
	 * 
	 * @return     string
	 */
	public function getPhoneMainNumber()
	{
		return $this->phone_main_number;
	}

	/**
	 * Get the [phone_other_number] column value.
	 * 
	 * @return     string
	 */
	public function getPhoneOtherNumber()
	{
		return $this->phone_other_number;
	}

	/**
	 * Get the [mailing_address] column value.
	 * 
	 * @return     string
	 */
	public function getMailingAddress()
	{
		return $this->mailing_address;
	}

	/**
	 * Get the [city] column value.
	 * 
	 * @return     string
	 */
	public function getCity()
	{
		return $this->city;
	}

	/**
	 * Get the [state_id] column value.
	 * 
	 * @return     int
	 */
	public function getStateId()
	{
		return $this->state_id;
	}

	/**
	 * Get the [cxd] column value.
	 * 
	 * @return     int
	 */
	public function getCxd()
	{
		return $this->cxd;
	}

	/**
	 * Get the [zip_code] column value.
	 * 
	 * @return     string
	 */
	public function getZipCode()
	{
		return $this->zip_code;
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
	 * @return     ContactInformation The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ContactInformationPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [first_name] column.
	 * 
	 * @param      string $v new value
	 * @return     ContactInformation The current object (for fluent API support)
	 */
	public function setFirstName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->first_name !== $v) {
			$this->first_name = $v;
			$this->modifiedColumns[] = ContactInformationPeer::FIRST_NAME;
		}

		return $this;
	} // setFirstName()

	/**
	 * Set the value of [last_name] column.
	 * 
	 * @param      string $v new value
	 * @return     ContactInformation The current object (for fluent API support)
	 */
	public function setLastName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->last_name !== $v) {
			$this->last_name = $v;
			$this->modifiedColumns[] = ContactInformationPeer::LAST_NAME;
		}

		return $this;
	} // setLastName()

	/**
	 * Set the value of [email_address] column.
	 * 
	 * @param      string $v new value
	 * @return     ContactInformation The current object (for fluent API support)
	 */
	public function setEmailAddress($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->email_address !== $v) {
			$this->email_address = $v;
			$this->modifiedColumns[] = ContactInformationPeer::EMAIL_ADDRESS;
		}

		return $this;
	} // setEmailAddress()

	/**
	 * Set the value of [phone_main_number] column.
	 * 
	 * @param      string $v new value
	 * @return     ContactInformation The current object (for fluent API support)
	 */
	public function setPhoneMainNumber($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->phone_main_number !== $v) {
			$this->phone_main_number = $v;
			$this->modifiedColumns[] = ContactInformationPeer::PHONE_MAIN_NUMBER;
		}

		return $this;
	} // setPhoneMainNumber()

	/**
	 * Set the value of [phone_other_number] column.
	 * 
	 * @param      string $v new value
	 * @return     ContactInformation The current object (for fluent API support)
	 */
	public function setPhoneOtherNumber($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->phone_other_number !== $v) {
			$this->phone_other_number = $v;
			$this->modifiedColumns[] = ContactInformationPeer::PHONE_OTHER_NUMBER;
		}

		return $this;
	} // setPhoneOtherNumber()

	/**
	 * Set the value of [mailing_address] column.
	 * 
	 * @param      string $v new value
	 * @return     ContactInformation The current object (for fluent API support)
	 */
	public function setMailingAddress($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->mailing_address !== $v) {
			$this->mailing_address = $v;
			$this->modifiedColumns[] = ContactInformationPeer::MAILING_ADDRESS;
		}

		return $this;
	} // setMailingAddress()

	/**
	 * Set the value of [city] column.
	 * 
	 * @param      string $v new value
	 * @return     ContactInformation The current object (for fluent API support)
	 */
	public function setCity($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->city !== $v) {
			$this->city = $v;
			$this->modifiedColumns[] = ContactInformationPeer::CITY;
		}

		return $this;
	} // setCity()

	/**
	 * Set the value of [state_id] column.
	 * 
	 * @param      int $v new value
	 * @return     ContactInformation The current object (for fluent API support)
	 */
	public function setStateId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->state_id !== $v) {
			$this->state_id = $v;
			$this->modifiedColumns[] = ContactInformationPeer::STATE_ID;
		}

		if ($this->aState !== null && $this->aState->getId() !== $v) {
			$this->aState = null;
		}

		return $this;
	} // setStateId()

	/**
	 * Set the value of [cxd] column.
	 * 
	 * @param      int $v new value
	 * @return     ContactInformation The current object (for fluent API support)
	 */
	public function setCxd($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->cxd !== $v) {
			$this->cxd = $v;
			$this->modifiedColumns[] = ContactInformationPeer::CXD;
		}

		return $this;
	} // setCxd()

	/**
	 * Set the value of [zip_code] column.
	 * 
	 * @param      string $v new value
	 * @return     ContactInformation The current object (for fluent API support)
	 */
	public function setZipCode($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->zip_code !== $v) {
			$this->zip_code = $v;
			$this->modifiedColumns[] = ContactInformationPeer::ZIP_CODE;
		}

		return $this;
	} // setZipCode()

	/**
	 * Sets the value of [created_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.
	 *               Empty strings are treated as NULL.
	 * @return     ContactInformation The current object (for fluent API support)
	 */
	public function setCreatedAt($v)
	{
		$dt = PropelDateTime::newInstance($v, null, 'DateTime');
		if ($this->created_at !== null || $dt !== null) {
			$currentDateAsString = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
			if ($currentDateAsString !== $newDateAsString) {
				$this->created_at = $newDateAsString;
				$this->modifiedColumns[] = ContactInformationPeer::CREATED_AT;
			}
		} // if either are not null

		return $this;
	} // setCreatedAt()

	/**
	 * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.
	 *               Empty strings are treated as NULL.
	 * @return     ContactInformation The current object (for fluent API support)
	 */
	public function setUpdatedAt($v)
	{
		$dt = PropelDateTime::newInstance($v, null, 'DateTime');
		if ($this->updated_at !== null || $dt !== null) {
			$currentDateAsString = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
			if ($currentDateAsString !== $newDateAsString) {
				$this->updated_at = $newDateAsString;
				$this->modifiedColumns[] = ContactInformationPeer::UPDATED_AT;
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
			$this->first_name = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->last_name = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->email_address = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->phone_main_number = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->phone_other_number = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->mailing_address = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->city = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
			$this->state_id = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
			$this->cxd = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
			$this->zip_code = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
			$this->created_at = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
			$this->updated_at = ($row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			return $startcol + 13; // 13 = ContactInformationPeer::NUM_HYDRATE_COLUMNS.

		} catch (Exception $e) {
			throw new PropelException("Error populating ContactInformation object", $e);
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

		if ($this->aState !== null && $this->state_id !== $this->aState->getId()) {
			$this->aState = null;
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
			$con = Propel::getConnection(ContactInformationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = ContactInformationPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aState = null;
			$this->collUsers = null;

			$this->collClientsRelatedByDefaultBillingContactInformationId = null;

			$this->collClientsRelatedByDefaultShippingContactInformationId = null;

			$this->collOrders = null;

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
			$con = Propel::getConnection(ContactInformationPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseContactInformation:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			    return;
			  }
			}

			if ($ret) {
				ContactInformationQuery::create()
					->filterByPrimaryKey($this->getPrimaryKey())
					->delete($con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseContactInformation:delete:post') as $callable)
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
			$con = Propel::getConnection(ContactInformationPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseContactInformation:save:pre') as $callable)
			{
			  if (is_integer($affectedRows = call_user_func($callable, $this, $con)))
			  {
			  	$con->commit();
			    return $affectedRows;
			  }
			}

			// symfony_timestampable behavior
			if ($this->isModified() && !$this->isColumnModified(ContactInformationPeer::UPDATED_AT))
			{
			  $this->setUpdatedAt(time());
			}

			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
				// symfony_timestampable behavior
				if (!$this->isColumnModified(ContactInformationPeer::CREATED_AT))
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
				foreach (sfMixer::getCallables('BaseContactInformation:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				ContactInformationPeer::addInstanceToPool($this);
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

			if ($this->aState !== null) {
				if ($this->aState->isModified() || $this->aState->isNew()) {
					$affectedRows += $this->aState->save($con);
				}
				$this->setState($this->aState);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = ContactInformationPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$criteria = $this->buildCriteria();
					if ($criteria->keyContainsValue(ContactInformationPeer::ID) ) {
						throw new PropelException('Cannot insert a value for auto-increment primary key ('.ContactInformationPeer::ID.')');
					}

					$pk = BasePeer::doInsert($criteria, $con);
					$affectedRows += 1;
					$this->setId($pk);  //[IMV] update autoincrement primary key
					$this->setNew(false);
				} else {
					$affectedRows += ContactInformationPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collUsers !== null) {
				foreach ($this->collUsers as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collClientsRelatedByDefaultBillingContactInformationId !== null) {
				foreach ($this->collClientsRelatedByDefaultBillingContactInformationId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collClientsRelatedByDefaultShippingContactInformationId !== null) {
				foreach ($this->collClientsRelatedByDefaultShippingContactInformationId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collOrders !== null) {
				foreach ($this->collOrders as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
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

			if ($this->aState !== null) {
				if (!$this->aState->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aState->getValidationFailures());
				}
			}


			if (($retval = ContactInformationPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collUsers !== null) {
					foreach ($this->collUsers as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collClientsRelatedByDefaultBillingContactInformationId !== null) {
					foreach ($this->collClientsRelatedByDefaultBillingContactInformationId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collClientsRelatedByDefaultShippingContactInformationId !== null) {
					foreach ($this->collClientsRelatedByDefaultShippingContactInformationId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collOrders !== null) {
					foreach ($this->collOrders as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
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
		$pos = ContactInformationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getFirstName();
				break;
			case 2:
				return $this->getLastName();
				break;
			case 3:
				return $this->getEmailAddress();
				break;
			case 4:
				return $this->getPhoneMainNumber();
				break;
			case 5:
				return $this->getPhoneOtherNumber();
				break;
			case 6:
				return $this->getMailingAddress();
				break;
			case 7:
				return $this->getCity();
				break;
			case 8:
				return $this->getStateId();
				break;
			case 9:
				return $this->getCxd();
				break;
			case 10:
				return $this->getZipCode();
				break;
			case 11:
				return $this->getCreatedAt();
				break;
			case 12:
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
	 * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
	 * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
	 *
	 * @return    array an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
	{
		if (isset($alreadyDumpedObjects['ContactInformation'][$this->getPrimaryKey()])) {
			return '*RECURSION*';
		}
		$alreadyDumpedObjects['ContactInformation'][$this->getPrimaryKey()] = true;
		$keys = ContactInformationPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getFirstName(),
			$keys[2] => $this->getLastName(),
			$keys[3] => $this->getEmailAddress(),
			$keys[4] => $this->getPhoneMainNumber(),
			$keys[5] => $this->getPhoneOtherNumber(),
			$keys[6] => $this->getMailingAddress(),
			$keys[7] => $this->getCity(),
			$keys[8] => $this->getStateId(),
			$keys[9] => $this->getCxd(),
			$keys[10] => $this->getZipCode(),
			$keys[11] => $this->getCreatedAt(),
			$keys[12] => $this->getUpdatedAt(),
		);
		if ($includeForeignObjects) {
			if (null !== $this->aState) {
				$result['State'] = $this->aState->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
			}
			if (null !== $this->collUsers) {
				$result['Users'] = $this->collUsers->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collClientsRelatedByDefaultBillingContactInformationId) {
				$result['ClientsRelatedByDefaultBillingContactInformationId'] = $this->collClientsRelatedByDefaultBillingContactInformationId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collClientsRelatedByDefaultShippingContactInformationId) {
				$result['ClientsRelatedByDefaultShippingContactInformationId'] = $this->collClientsRelatedByDefaultShippingContactInformationId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collOrders) {
				$result['Orders'] = $this->collOrders->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
		$pos = ContactInformationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setFirstName($value);
				break;
			case 2:
				$this->setLastName($value);
				break;
			case 3:
				$this->setEmailAddress($value);
				break;
			case 4:
				$this->setPhoneMainNumber($value);
				break;
			case 5:
				$this->setPhoneOtherNumber($value);
				break;
			case 6:
				$this->setMailingAddress($value);
				break;
			case 7:
				$this->setCity($value);
				break;
			case 8:
				$this->setStateId($value);
				break;
			case 9:
				$this->setCxd($value);
				break;
			case 10:
				$this->setZipCode($value);
				break;
			case 11:
				$this->setCreatedAt($value);
				break;
			case 12:
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
		$keys = ContactInformationPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setFirstName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setLastName($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setEmailAddress($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setPhoneMainNumber($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setPhoneOtherNumber($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setMailingAddress($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setCity($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setStateId($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setCxd($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setZipCode($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setCreatedAt($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setUpdatedAt($arr[$keys[12]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(ContactInformationPeer::DATABASE_NAME);

		if ($this->isColumnModified(ContactInformationPeer::ID)) $criteria->add(ContactInformationPeer::ID, $this->id);
		if ($this->isColumnModified(ContactInformationPeer::FIRST_NAME)) $criteria->add(ContactInformationPeer::FIRST_NAME, $this->first_name);
		if ($this->isColumnModified(ContactInformationPeer::LAST_NAME)) $criteria->add(ContactInformationPeer::LAST_NAME, $this->last_name);
		if ($this->isColumnModified(ContactInformationPeer::EMAIL_ADDRESS)) $criteria->add(ContactInformationPeer::EMAIL_ADDRESS, $this->email_address);
		if ($this->isColumnModified(ContactInformationPeer::PHONE_MAIN_NUMBER)) $criteria->add(ContactInformationPeer::PHONE_MAIN_NUMBER, $this->phone_main_number);
		if ($this->isColumnModified(ContactInformationPeer::PHONE_OTHER_NUMBER)) $criteria->add(ContactInformationPeer::PHONE_OTHER_NUMBER, $this->phone_other_number);
		if ($this->isColumnModified(ContactInformationPeer::MAILING_ADDRESS)) $criteria->add(ContactInformationPeer::MAILING_ADDRESS, $this->mailing_address);
		if ($this->isColumnModified(ContactInformationPeer::CITY)) $criteria->add(ContactInformationPeer::CITY, $this->city);
		if ($this->isColumnModified(ContactInformationPeer::STATE_ID)) $criteria->add(ContactInformationPeer::STATE_ID, $this->state_id);
		if ($this->isColumnModified(ContactInformationPeer::CXD)) $criteria->add(ContactInformationPeer::CXD, $this->cxd);
		if ($this->isColumnModified(ContactInformationPeer::ZIP_CODE)) $criteria->add(ContactInformationPeer::ZIP_CODE, $this->zip_code);
		if ($this->isColumnModified(ContactInformationPeer::CREATED_AT)) $criteria->add(ContactInformationPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(ContactInformationPeer::UPDATED_AT)) $criteria->add(ContactInformationPeer::UPDATED_AT, $this->updated_at);

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
		$criteria = new Criteria(ContactInformationPeer::DATABASE_NAME);
		$criteria->add(ContactInformationPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of ContactInformation (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
	{
		$copyObj->setFirstName($this->getFirstName());
		$copyObj->setLastName($this->getLastName());
		$copyObj->setEmailAddress($this->getEmailAddress());
		$copyObj->setPhoneMainNumber($this->getPhoneMainNumber());
		$copyObj->setPhoneOtherNumber($this->getPhoneOtherNumber());
		$copyObj->setMailingAddress($this->getMailingAddress());
		$copyObj->setCity($this->getCity());
		$copyObj->setStateId($this->getStateId());
		$copyObj->setCxd($this->getCxd());
		$copyObj->setZipCode($this->getZipCode());
		$copyObj->setCreatedAt($this->getCreatedAt());
		$copyObj->setUpdatedAt($this->getUpdatedAt());

		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getUsers() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addUser($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getClientsRelatedByDefaultBillingContactInformationId() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addClientRelatedByDefaultBillingContactInformationId($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getClientsRelatedByDefaultShippingContactInformationId() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addClientRelatedByDefaultShippingContactInformationId($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getOrders() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addOrder($relObj->copy($deepCopy));
				}
			}

		} // if ($deepCopy)

		if ($makeNew) {
			$copyObj->setNew(true);
			$copyObj->setId(NULL); // this is a auto-increment column, so set to default value
		}
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
	 * @return     ContactInformation Clone of current object.
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
	 * @return     ContactInformationPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new ContactInformationPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a State object.
	 *
	 * @param      State $v
	 * @return     ContactInformation The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setState(State $v = null)
	{
		if ($v === null) {
			$this->setStateId(NULL);
		} else {
			$this->setStateId($v->getId());
		}

		$this->aState = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the State object, it will not be re-added.
		if ($v !== null) {
			$v->addContactInformation($this);
		}

		return $this;
	}


	/**
	 * Get the associated State object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     State The associated State object.
	 * @throws     PropelException
	 */
	public function getState(PropelPDO $con = null)
	{
		if ($this->aState === null && ($this->state_id !== null)) {
			$this->aState = StateQuery::create()->findPk($this->state_id, $con);
			/* The following can be used additionally to
				guarantee the related object contains a reference
				to this object.  This level of coupling may, however, be
				undesirable since it could result in an only partially populated collection
				in the referenced object.
				$this->aState->addContactInformations($this);
			 */
		}
		return $this->aState;
	}

	/**
	 * Clears out the collUsers collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addUsers()
	 */
	public function clearUsers()
	{
		$this->collUsers = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collUsers collection.
	 *
	 * By default this just sets the collUsers collection to an empty array (like clearcollUsers());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initUsers($overrideExisting = true)
	{
		if (null !== $this->collUsers && !$overrideExisting) {
			return;
		}
		$this->collUsers = new PropelObjectCollection();
		$this->collUsers->setModel('User');
	}

	/**
	 * Gets an array of User objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this ContactInformation is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array User[] List of User objects
	 * @throws     PropelException
	 */
	public function getUsers($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collUsers || null !== $criteria) {
			if ($this->isNew() && null === $this->collUsers) {
				// return empty collection
				$this->initUsers();
			} else {
				$collUsers = UserQuery::create(null, $criteria)
					->filterByContactInformation($this)
					->find($con);
				if (null !== $criteria) {
					return $collUsers;
				}
				$this->collUsers = $collUsers;
			}
		}
		return $this->collUsers;
	}

	/**
	 * Returns the number of related User objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related User objects.
	 * @throws     PropelException
	 */
	public function countUsers(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collUsers || null !== $criteria) {
			if ($this->isNew() && null === $this->collUsers) {
				return 0;
			} else {
				$query = UserQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByContactInformation($this)
					->count($con);
			}
		} else {
			return count($this->collUsers);
		}
	}

	/**
	 * Method called to associate a User object to this object
	 * through the User foreign key attribute.
	 *
	 * @param      User $l User
	 * @return     void
	 * @throws     PropelException
	 */
	public function addUser(User $l)
	{
		if ($this->collUsers === null) {
			$this->initUsers();
		}
		if (!$this->collUsers->contains($l)) { // only add it if the **same** object is not already associated
			$this->collUsers[]= $l;
			$l->setContactInformation($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ContactInformation is new, it will return
	 * an empty collection; or if this ContactInformation has previously
	 * been saved, it will retrieve related Users from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in ContactInformation.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array User[] List of User objects
	 */
	public function getUsersJoinsfGuardUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = UserQuery::create(null, $criteria);
		$query->joinWith('sfGuardUser', $join_behavior);

		return $this->getUsers($query, $con);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ContactInformation is new, it will return
	 * an empty collection; or if this ContactInformation has previously
	 * been saved, it will retrieve related Users from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in ContactInformation.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array User[] List of User objects
	 */
	public function getUsersJoinClient($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = UserQuery::create(null, $criteria);
		$query->joinWith('Client', $join_behavior);

		return $this->getUsers($query, $con);
	}

	/**
	 * Clears out the collClientsRelatedByDefaultBillingContactInformationId collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addClientsRelatedByDefaultBillingContactInformationId()
	 */
	public function clearClientsRelatedByDefaultBillingContactInformationId()
	{
		$this->collClientsRelatedByDefaultBillingContactInformationId = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collClientsRelatedByDefaultBillingContactInformationId collection.
	 *
	 * By default this just sets the collClientsRelatedByDefaultBillingContactInformationId collection to an empty array (like clearcollClientsRelatedByDefaultBillingContactInformationId());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initClientsRelatedByDefaultBillingContactInformationId($overrideExisting = true)
	{
		if (null !== $this->collClientsRelatedByDefaultBillingContactInformationId && !$overrideExisting) {
			return;
		}
		$this->collClientsRelatedByDefaultBillingContactInformationId = new PropelObjectCollection();
		$this->collClientsRelatedByDefaultBillingContactInformationId->setModel('Client');
	}

	/**
	 * Gets an array of Client objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this ContactInformation is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Client[] List of Client objects
	 * @throws     PropelException
	 */
	public function getClientsRelatedByDefaultBillingContactInformationId($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collClientsRelatedByDefaultBillingContactInformationId || null !== $criteria) {
			if ($this->isNew() && null === $this->collClientsRelatedByDefaultBillingContactInformationId) {
				// return empty collection
				$this->initClientsRelatedByDefaultBillingContactInformationId();
			} else {
				$collClientsRelatedByDefaultBillingContactInformationId = ClientQuery::create(null, $criteria)
					->filterByContactInformationRelatedByDefaultBillingContactInformationId($this)
					->find($con);
				if (null !== $criteria) {
					return $collClientsRelatedByDefaultBillingContactInformationId;
				}
				$this->collClientsRelatedByDefaultBillingContactInformationId = $collClientsRelatedByDefaultBillingContactInformationId;
			}
		}
		return $this->collClientsRelatedByDefaultBillingContactInformationId;
	}

	/**
	 * Returns the number of related Client objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Client objects.
	 * @throws     PropelException
	 */
	public function countClientsRelatedByDefaultBillingContactInformationId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collClientsRelatedByDefaultBillingContactInformationId || null !== $criteria) {
			if ($this->isNew() && null === $this->collClientsRelatedByDefaultBillingContactInformationId) {
				return 0;
			} else {
				$query = ClientQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByContactInformationRelatedByDefaultBillingContactInformationId($this)
					->count($con);
			}
		} else {
			return count($this->collClientsRelatedByDefaultBillingContactInformationId);
		}
	}

	/**
	 * Method called to associate a Client object to this object
	 * through the Client foreign key attribute.
	 *
	 * @param      Client $l Client
	 * @return     void
	 * @throws     PropelException
	 */
	public function addClientRelatedByDefaultBillingContactInformationId(Client $l)
	{
		if ($this->collClientsRelatedByDefaultBillingContactInformationId === null) {
			$this->initClientsRelatedByDefaultBillingContactInformationId();
		}
		if (!$this->collClientsRelatedByDefaultBillingContactInformationId->contains($l)) { // only add it if the **same** object is not already associated
			$this->collClientsRelatedByDefaultBillingContactInformationId[]= $l;
			$l->setContactInformationRelatedByDefaultBillingContactInformationId($this);
		}
	}

	/**
	 * Clears out the collClientsRelatedByDefaultShippingContactInformationId collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addClientsRelatedByDefaultShippingContactInformationId()
	 */
	public function clearClientsRelatedByDefaultShippingContactInformationId()
	{
		$this->collClientsRelatedByDefaultShippingContactInformationId = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collClientsRelatedByDefaultShippingContactInformationId collection.
	 *
	 * By default this just sets the collClientsRelatedByDefaultShippingContactInformationId collection to an empty array (like clearcollClientsRelatedByDefaultShippingContactInformationId());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initClientsRelatedByDefaultShippingContactInformationId($overrideExisting = true)
	{
		if (null !== $this->collClientsRelatedByDefaultShippingContactInformationId && !$overrideExisting) {
			return;
		}
		$this->collClientsRelatedByDefaultShippingContactInformationId = new PropelObjectCollection();
		$this->collClientsRelatedByDefaultShippingContactInformationId->setModel('Client');
	}

	/**
	 * Gets an array of Client objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this ContactInformation is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Client[] List of Client objects
	 * @throws     PropelException
	 */
	public function getClientsRelatedByDefaultShippingContactInformationId($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collClientsRelatedByDefaultShippingContactInformationId || null !== $criteria) {
			if ($this->isNew() && null === $this->collClientsRelatedByDefaultShippingContactInformationId) {
				// return empty collection
				$this->initClientsRelatedByDefaultShippingContactInformationId();
			} else {
				$collClientsRelatedByDefaultShippingContactInformationId = ClientQuery::create(null, $criteria)
					->filterByContactInformationRelatedByDefaultShippingContactInformationId($this)
					->find($con);
				if (null !== $criteria) {
					return $collClientsRelatedByDefaultShippingContactInformationId;
				}
				$this->collClientsRelatedByDefaultShippingContactInformationId = $collClientsRelatedByDefaultShippingContactInformationId;
			}
		}
		return $this->collClientsRelatedByDefaultShippingContactInformationId;
	}

	/**
	 * Returns the number of related Client objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Client objects.
	 * @throws     PropelException
	 */
	public function countClientsRelatedByDefaultShippingContactInformationId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collClientsRelatedByDefaultShippingContactInformationId || null !== $criteria) {
			if ($this->isNew() && null === $this->collClientsRelatedByDefaultShippingContactInformationId) {
				return 0;
			} else {
				$query = ClientQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByContactInformationRelatedByDefaultShippingContactInformationId($this)
					->count($con);
			}
		} else {
			return count($this->collClientsRelatedByDefaultShippingContactInformationId);
		}
	}

	/**
	 * Method called to associate a Client object to this object
	 * through the Client foreign key attribute.
	 *
	 * @param      Client $l Client
	 * @return     void
	 * @throws     PropelException
	 */
	public function addClientRelatedByDefaultShippingContactInformationId(Client $l)
	{
		if ($this->collClientsRelatedByDefaultShippingContactInformationId === null) {
			$this->initClientsRelatedByDefaultShippingContactInformationId();
		}
		if (!$this->collClientsRelatedByDefaultShippingContactInformationId->contains($l)) { // only add it if the **same** object is not already associated
			$this->collClientsRelatedByDefaultShippingContactInformationId[]= $l;
			$l->setContactInformationRelatedByDefaultShippingContactInformationId($this);
		}
	}

	/**
	 * Clears out the collOrders collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addOrders()
	 */
	public function clearOrders()
	{
		$this->collOrders = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collOrders collection.
	 *
	 * By default this just sets the collOrders collection to an empty array (like clearcollOrders());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initOrders($overrideExisting = true)
	{
		if (null !== $this->collOrders && !$overrideExisting) {
			return;
		}
		$this->collOrders = new PropelObjectCollection();
		$this->collOrders->setModel('Order');
	}

	/**
	 * Gets an array of Order objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this ContactInformation is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Order[] List of Order objects
	 * @throws     PropelException
	 */
	public function getOrders($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collOrders || null !== $criteria) {
			if ($this->isNew() && null === $this->collOrders) {
				// return empty collection
				$this->initOrders();
			} else {
				$collOrders = OrderQuery::create(null, $criteria)
					->filterByContactInformation($this)
					->find($con);
				if (null !== $criteria) {
					return $collOrders;
				}
				$this->collOrders = $collOrders;
			}
		}
		return $this->collOrders;
	}

	/**
	 * Returns the number of related Order objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Order objects.
	 * @throws     PropelException
	 */
	public function countOrders(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collOrders || null !== $criteria) {
			if ($this->isNew() && null === $this->collOrders) {
				return 0;
			} else {
				$query = OrderQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByContactInformation($this)
					->count($con);
			}
		} else {
			return count($this->collOrders);
		}
	}

	/**
	 * Method called to associate a Order object to this object
	 * through the Order foreign key attribute.
	 *
	 * @param      Order $l Order
	 * @return     void
	 * @throws     PropelException
	 */
	public function addOrder(Order $l)
	{
		if ($this->collOrders === null) {
			$this->initOrders();
		}
		if (!$this->collOrders->contains($l)) { // only add it if the **same** object is not already associated
			$this->collOrders[]= $l;
			$l->setContactInformation($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ContactInformation is new, it will return
	 * an empty collection; or if this ContactInformation has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in ContactInformation.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Order[] List of Order objects
	 */
	public function getOrdersJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = OrderQuery::create(null, $criteria);
		$query->joinWith('User', $join_behavior);

		return $this->getOrders($query, $con);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ContactInformation is new, it will return
	 * an empty collection; or if this ContactInformation has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in ContactInformation.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Order[] List of Order objects
	 */
	public function getOrdersJoinCreditCard($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = OrderQuery::create(null, $criteria);
		$query->joinWith('CreditCard', $join_behavior);

		return $this->getOrders($query, $con);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ContactInformation is new, it will return
	 * an empty collection; or if this ContactInformation has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in ContactInformation.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Order[] List of Order objects
	 */
	public function getOrdersJoinProductSelectionSet($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = OrderQuery::create(null, $criteria);
		$query->joinWith('ProductSelectionSet', $join_behavior);

		return $this->getOrders($query, $con);
	}

	/**
	 * Clears the current object and sets all attributes to their default values
	 */
	public function clear()
	{
		$this->id = null;
		$this->first_name = null;
		$this->last_name = null;
		$this->email_address = null;
		$this->phone_main_number = null;
		$this->phone_other_number = null;
		$this->mailing_address = null;
		$this->city = null;
		$this->state_id = null;
		$this->cxd = null;
		$this->zip_code = null;
		$this->created_at = null;
		$this->updated_at = null;
		$this->alreadyInSave = false;
		$this->alreadyInValidation = false;
		$this->clearAllReferences();
		$this->resetModified();
		$this->setNew(true);
		$this->setDeleted(false);
	}

	/**
	 * Resets all references to other model objects or collections of model objects.
	 *
	 * This method is a user-space workaround for PHP's inability to garbage collect
	 * objects with circular references (even in PHP 5.3). This is currently necessary
	 * when using Propel in certain daemon or large-volumne/high-memory operations.
	 *
	 * @param      boolean $deep Whether to also clear the references on all referrer objects.
	 */
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
			if ($this->collUsers) {
				foreach ($this->collUsers as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collClientsRelatedByDefaultBillingContactInformationId) {
				foreach ($this->collClientsRelatedByDefaultBillingContactInformationId as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collClientsRelatedByDefaultShippingContactInformationId) {
				foreach ($this->collClientsRelatedByDefaultShippingContactInformationId as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collOrders) {
				foreach ($this->collOrders as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		if ($this->collUsers instanceof PropelCollection) {
			$this->collUsers->clearIterator();
		}
		$this->collUsers = null;
		if ($this->collClientsRelatedByDefaultBillingContactInformationId instanceof PropelCollection) {
			$this->collClientsRelatedByDefaultBillingContactInformationId->clearIterator();
		}
		$this->collClientsRelatedByDefaultBillingContactInformationId = null;
		if ($this->collClientsRelatedByDefaultShippingContactInformationId instanceof PropelCollection) {
			$this->collClientsRelatedByDefaultShippingContactInformationId->clearIterator();
		}
		$this->collClientsRelatedByDefaultShippingContactInformationId = null;
		if ($this->collOrders instanceof PropelCollection) {
			$this->collOrders->clearIterator();
		}
		$this->collOrders = null;
		$this->aState = null;
	}

	/**
	 * Return the string representation of this object
	 *
	 * @return string
	 */
	public function __toString()
	{
		return (string) $this->exportTo(ContactInformationPeer::DEFAULT_STRING_FORMAT);
	}

	/**
	 * Catches calls to virtual methods
	 */
	public function __call($name, $params)
	{
		// symfony_behaviors behavior
		if ($callable = sfMixer::getCallable('BaseContactInformation:' . $name))
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

} // BaseContactInformation
