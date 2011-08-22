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
class sfAltumoUpdateDatabaseTask extends sfAltumoBaseTask {

    /**
    * @see sfTask
    */
    protected function configure() {
        
        parent::configure();
        
        $this->addArguments(array(
            new sfCommandArgument( 'command', sfCommandArgument::REQUIRED, 'update, drop or init' )
        ));
        
        $this->addOptions(array(
            //new sfCommandOption( 'database-directory', null, sfCommandOption::PARAMETER_REQUIRED, 'The database directory.', null )
            new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', null),
            new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
            new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel')
        ));

        $this->name = 'update-database';

        $this->briefDescription = 'Updates this environment\'s database.';

    $this->detailedDescription = <<<EOF
Updates this environment\'s database to the latest build in the build sequence.
EOF;
    }

    
   /**
   * @see sfTask
   */
    protected function execute( $arguments = array(), $options = array() ) {

        $databaseManager = new sfDatabaseManager($this->configuration);
        
        $database_dir = sfConfig::get( 'sf_data_dir' );
        $default_build_sequence_file = $database_dir . '/build-sequence.xml';
        $default_update_log_file = $database_dir . '/update-log.xml';
        $default_updater_configuration_file = $database_dir . '/updater-configuration.xml';
        
        $command = $arguments['command'];
        
        //initialize updater, if there is meaningful work to do
            if( in_array( $command, array('update', 'drop') ) ){
                $xml_build_sequence = new \sfAltumoPlugin\Build\DatabaseBuildSequenceFile( $default_build_sequence_file );
                $xml_sf_altumo_build_sequence = new \sfAltumoPlugin\Build\DatabaseBuildSequenceFile( $database_dir . '/../plugins/sfAltumoPlugin/data/build-sequence.xml' );
                $xml_update_log = new \sfAltumoPlugin\Deployment\DatabaseUpdateLogFile( $default_update_log_file, false );
                $xml_updater_configuration = new \sfAltumoPlugin\Deployment\DatabaseUpdaterConfigurationFile( $default_updater_configuration_file );
                $xml_updater_configuration->setDatabaseDirectory( $database_dir );
                
                $database_updater = new \sfAltumoPlugin\Deployment\DatabaseUpdater( $xml_updater_configuration, $xml_build_sequence, $xml_update_log, $xml_sf_altumo_build_sequence );
            }
                
        switch( $command ){
            
            case 'update':
                    $number_of_scripts_executed = $database_updater->update( $arguments );
                    
                break;
                
            case 'drop':
                    $number_of_scripts_executed = $database_updater->drop( $arguments );
            
                break;
                
            case 'init':                    
                    $xml_updater_configuration = new \sfAltumoPlugin\Deployment\DatabaseUpdaterConfigurationFile( $default_updater_configuration_file, false );
                    $xml_update_log = new \sfAltumoPlugin\Deployment\DatabaseUpdateLogFile( $default_update_log_file, false );
                    $number_of_scripts_executed = 0;
                break;
            
            default:
                throw new sfCommandException( sprintf('Command "%s" does not exist.', $arguments['command']) );
            
        }
        
        $this->log( $number_of_scripts_executed . ' scripts executed successfully.' . "\n" );
        
    }
    
}
