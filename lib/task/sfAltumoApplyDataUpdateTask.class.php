<?php
/*
 * This file is part of the sfAltumoPlugin library.
 *
 * (c) Steve Sperandeo <steve.sperandeo@altumo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Applies a single data_update to the database. This task is executed automatically
 * during the update-database process and should not be called manually.
 * 
 * This process has to be performed in a separate process because the working tree
 * is taken to different commits during the process and caching, namespaces and
 * other factors would interfere.
 * 
 * @author Juan Jaramillo <juan.jaramillo@altumo.com>
 */
class sfAltumoApplyDataUpdateTask extends sfAltumoBaseTask {

    /**
    * @see sfTask
    */
    protected function configure() {
        
        parent::configure();
        
        $this->addArguments(array(
            new sfCommandArgument( 'hash', sfCommandArgument::REQUIRED, 'hash of the script to apply, or "new" to test uncommitted data_update.' )
        ));
        
        $this->addOptions(array(
            //new sfCommandOption( 'database-directory', null, sfCommandOption::PARAMETER_REQUIRED, 'The database directory.', null )
            new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', null),
            new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
            new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel')
        ));

        $this->name = 'apply-data-update';

        $this->briefDescription = 'Applies a single data_update to the database. (Do not run manually)';

    $this->detailedDescription = <<<EOF
Applies a single data_update to the database. (Do not run manually)
EOF;
    }

    
   /**
   * @see sfTask
   */
    protected function execute( $arguments = array(), $options = array() ) {

        // Initialize Updated configuration
            $data_dir = sfConfig::get( 'sf_data_dir' );

        // Initialize database
            $databaseManager = new sfDatabaseManager($this->configuration);

        // Find and include data_update script
            $hash = $arguments['hash'];

            // Run the uncommitted data_update (in the new folder) if it exists.
                if( $hash == 'new' ){

                    $script = $data_dir . '/new/' . 'data_update.php';

                } else {

                    $script = $data_dir . '/data_updates/' . 'data_update_' . $hash . '.php';

                }
                
            
            if( !is_readable( $script ) ){
                throw new \Exception( "\"{$script}\" does not exist or is not readable." );
            }
            
            
            try{
                
                require_once( $script );
                
                // Perform update
                    $data_update = new sfAltumoPlugin\Deployment\DataUpdate();
                    $data_update->run();
                    
            } catch( \Exception $e ){
                
                throw new \Exception( "The data_update {$hash} has thrown an exception:\n" . $e->getMessage() );
                
            }
            
            $this->logSection( '+ data_update', $hash );
       
    }
    
}
