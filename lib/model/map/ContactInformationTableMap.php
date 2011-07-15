<?php



/**
 * This class defines the structure of the 'contact_information' table.
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
class ContactInformationTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'plugins.sfAltumoPlugin.lib.model.map.ContactInformationTableMap';

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
		$this->setName('contact_information');
		$this->setPhpName('ContactInformation');
		$this->setClassname('ContactInformation');
		$this->setPackage('plugins.sfAltumoPlugin.lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('FIRST_NAME', 'FirstName', 'VARCHAR', false, 64, null);
		$this->addColumn('LAST_NAME', 'LastName', 'VARCHAR', false, 64, null);
		$this->addColumn('EMAIL_ADDRESS', 'EmailAddress', 'VARCHAR', false, 150, null);
		$this->addColumn('PHONE_MAIN_NUMBER', 'PhoneMainNumber', 'VARCHAR', false, 32, null);
		$this->addColumn('PHONE_OTHER_NUMBER', 'PhoneOtherNumber', 'VARCHAR', false, 32, null);
		$this->addColumn('MAILING_ADDRESS', 'MailingAddress', 'VARCHAR', false, 255, null);
		$this->addColumn('CITY', 'City', 'VARCHAR', false, 64, null);
		$this->addForeignKey('STATE_ID', 'StateId', 'INTEGER', 'state', 'ID', true, null, null);
		$this->addColumn('ZIP_CODE', 'ZipCode', 'VARCHAR', false, 16, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('State', 'State', RelationMap::MANY_TO_ONE, array('state_id' => 'id', ), 'CASCADE', null);
    $this->addRelation('ClientRelatedByDefaultBillingContactInformationId', 'Client', RelationMap::ONE_TO_MANY, array('id' => 'default_billing_contact_information_id', ), 'CASCADE', null);
    $this->addRelation('ClientRelatedByDefaultShippingContactInformationId', 'Client', RelationMap::ONE_TO_MANY, array('id' => 'default_shipping_contact_information_id', ), 'CASCADE', null);
    $this->addRelation('ProductSelection', 'ProductSelection', RelationMap::ONE_TO_MANY, array('id' => 'product_id', ), 'RESTRICT', null);
    $this->addRelation('User', 'User', RelationMap::ONE_TO_MANY, array('id' => 'contact_information_id', ), 'RESTRICT', null);
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

} // ContactInformationTableMap
