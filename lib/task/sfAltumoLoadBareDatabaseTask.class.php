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
 * Updates an existing application environement.
 * 
 * This script pulls from the default remote, updates the database (or applies
 * deltas) and clears the project cache.
 * 
 * @author Steve Sperandeo <steve.sperandeo@altumo.com>
 */
class sfAltumoLoadBareDatabaseTask extends sfAltumoBaseTask {

    /**
    * @see sfTask
    */
    protected function configure() {
        
        parent::configure();
        
        $this->addArguments(array(
            new sfCommandArgument( 'bare-database-target', sfCommandArgument::OPTIONAL, 'Specify a custom name to load the bare database onto.', null )
        ));
        
        $this->addOptions(array(
            //new sfCommandOption( 'database-directory', null, sfCommandOption::PARAMETER_REQUIRED, 'The database directory.', null )
        ));

        $this->name = 'load-bare-database';

        $this->briefDescription = 'Loads a blank copy of the schema that Propel would generate onto the database.';


        $this->detailedDescription = <<<EOF
It first uses Propel's tasks to create SQL files for the application and plugin schemas. It then loads these sql files onto a database by the same name as the one used by the project but with "_bare" appended to it.

The resulting database is intended for reference use only. For example, to do a schema comparisson (using a diff tool like Toad for MySQL) between the current application database and a bare database after making some schema changes.

** If a database by the same name exists, it will be replaced **
EOF;
    }

    
   /**
   * @see sfTask
   */
    protected function execute( $arguments = array(), $options = array() ) {

        $database_dir = sfConfig::get( 'sf_data_dir' );
        $default_updater_configuration_file = $database_dir . '/updater-configuration.xml';
        
        $bare_database_target = $arguments['bare-database-target'];

        $xml_updater_configuration = new \sfAltumoPlugin\Deployment\DatabaseUpdaterConfigurationFile( $default_updater_configuration_file );
        $xml_updater_configuration->setDatabaseDirectory( $database_dir );

        $bare_database_loader = new \sfAltumoPlugin\Deployment\BareDatabaseLoader( $xml_updater_configuration );
        
        
        
        
        // First reload propel sql files
        
            $this->log( "\nReloading Propel SQL files\n" );
            
            \Altumo\Utils\Shell::runWithPipedOutput( sfConfig::get( 'sf_root_dir' ) . '/symfony propel:build-sql' );
        
        
        // Load bare database
            
            $this->log( "\nApplying to bare database\n" );
            
            $commands_executed = $bare_database_loader->loadBareDatabase();
            
            
        foreach( $commands_executed as $command ){
            
            $this->logSection( 'sh', $command );
            
        }

        
        $this->log( "\nA fresh Propel database has been loaded to the bare database.\n");
        
    }
    
}
