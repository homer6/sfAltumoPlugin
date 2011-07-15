<?php



/**
 * This class defines the structure of the 'session' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.plugins.sfAltumoPlugin.lib.model.map
 */
class SessionTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'plugins.sfAltumoPlugin.lib.model.map.SessionTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
	  // attributes
		$this->setName('session');
		$this->setPhpName('Session');
		$this->setClassname('Session');
		$this->setPackage('plugins.sfAltumoPlugin.lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('SESSION_KEY', 'SessionKey', 'VARCHAR', true, 32, null);
		$this->addColumn('DATA', 'Data', 'BLOB', false, null, null);
		$this->addColumn('CLIENT_IP_ADDRESS', 'ClientIpAddress', 'VARCHAR', false, 39, null);
		$this->addColumn('SESSION_TYPE', 'SessionType', 'VARCHAR', false, 32, null);
		$this->addColumn('TIME', 'Time', 'INTEGER', true, null, null);
		$this->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'user', 'ID', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('User', 'User', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), 'CASCADE', null);
    $this->addRelation('SingleSignOnKey', 'SingleSignOnKey', RelationMap::ONE_TO_MANY, array('id' => 'session_id', ), 'CASCADE', null);
	} // buildRelations()

	/**
	 * 
	 * Gets the list of behaviors registered for this table
	 * 
	 * @return array Associative array (name => parameters) of behaviors
	 */
	public function getBehaviors()
	{
		return array(
			'symfony' => array('form' => 'true', 'filter' => 'true', ),
			'symfony_behaviors' => array(),
		);
	} // getBehaviors()

} // SessionTableMap
