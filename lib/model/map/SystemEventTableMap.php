<?php



/**
 * This class defines the structure of the 'system_event' table.
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
class SystemEventTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'plugins.sfAltumoPlugin.lib.model.map.SystemEventTableMap';

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
		$this->setName('system_event');
		$this->setPhpName('SystemEvent');
		$this->setClassname('SystemEvent');
		$this->setPackage('plugins.sfAltumoPlugin.lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', true, 64, null);
		$this->addColumn('UNIQUE_KEY', 'UniqueKey', 'VARCHAR', true, 64, null);
		$this->addColumn('SLUG', 'Slug', 'VARCHAR', true, 255, null);
		$this->addColumn('ENABLED', 'Enabled', 'BOOLEAN', true, null, true);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('SystemEventSubscription', 'SystemEventSubscription', RelationMap::ONE_TO_MANY, array('id' => 'system_event_id', ), 'CASCADE', 'CASCADE');
    $this->addRelation('SystemEventInstance', 'SystemEventInstance', RelationMap::ONE_TO_MANY, array('id' => 'system_event_id', ), 'CASCADE', 'CASCADE');
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
			'symfony_timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', ),
		);
	} // getBehaviors()

} // SystemEventTableMap
