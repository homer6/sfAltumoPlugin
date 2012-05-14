<?php

class sfAltumoCollectSessionGarbageTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
    	new sfCommandOption( 'application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend' ),
    	new sfCommandOption( 'env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev' ),
    	new sfCommandOption( 'connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel' ),
    ));

    $this->namespace        = 'altumo';
    $this->name             = 'collect-session-garbage';
    $this->briefDescription = 'Remove old session data';
    $this->detailedDescription = <<<EOF
The [collect-session-garbage|INFO] task empties expired session data from current session storage.
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
	// initialize the database connection
  	$configuration = ProjectConfiguration::getApplicationConfiguration( $options['application'], $options['env'], false );
  	$databaseManager = new sfDatabaseManager( $configuration );  	
  	$connection = $databaseManager->getDatabase( $options['connection'] )->getConnection();

  	/*
  	 * Get the context object - we'll use it to factory the session storage object
  	 */
	if ( ! sfContext::hasInstance()) sfContext::createInstance( $configuration );
	
	
	/*
	 * Get the session storage object
	 * We need it 1) to retrieve the session/cookie lifetime setting and
	 * 2) for its sessionGC($lifetime) method
	 * 
	 * (It throws a notice because Symfony assumes it's a web request)
	 */
	
    $storage = sfContext::getInstance()->getStorage();
    
    
    // get session cookie lifetime
    $options = $storage->getOptions();
    $lifetime = isset( $options['session_cookie_lifetime'] )
    	? $options['session_cookie_lifetime']
    	: null
    ;
    
	// assert lifetime is set
	\Altumo\Validation\Numerics::assertPositiveInteger(
		$lifetime,
		'Session lifetime must be a positive integer'
	);
	
	$this->log( sprintf( 'Session lifetime is %s s', $lifetime ) );
	$this->log( sprintf( 'Found %s sessions for GC', SessionPeer::countGarbageCollectible( $lifetime ) ) );
	$this->log( sprintf( 'Deleting ...') );

	// call session storage's implementation of garbage collect
	$storage->sessionGC( $lifetime );
	
	$this->log( 'Done' );
  }
  
}
