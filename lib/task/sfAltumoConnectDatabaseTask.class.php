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
class sfAltumoConnectDatabaseTask extends sfAltumoBaseTask {

    /**
    * @see sfTask
    */
    protected function configure() {
        
        parent::configure();
        
        $this->addArguments(array(
            //new sfCommandArgument( 'command', sfCommandArgument::REQUIRED, 'The subcommand.' ),
        ));

        $this->addOptions(array(
            //new sfCommandOption( 'build', null, sfCommandOption::PARAMETER_OPTIONAL, 'Modifies an existing database according to available build files.', null ),            
        ));

        $this->name = 'connect-to-database';
        $this->aliases = array( $this->namespace. ':db' );

        $this->briefDescription = 'Connects to this environment\'s database using the native mysql client.';

        $database_dir = sfConfig::get( 'sf_data_dir' );
        $default_updater_configuration_file = $database_dir . '/updater-configuration.xml';
        $this->detailedDescription = <<<EOF
Connects to this environment\'s database using the native mysql client. It uses
the host, credentials and database from the database updater.

See: {$default_updater_configuration_file}
EOF;
    }

    
   /**
   * @see sfTask
   */
    protected function execute( $arguments = array(), $options = array() ) {

        $database_dir = sfConfig::get( 'sf_data_dir' );
        $default_updater_configuration_file = $database_dir . '/updater-configuration.xml';
        
        $shell_file = $database_dir . '/connect-database.sh';

        //always write the shell file before executing: parameters may have changed
            $xml_updater_configuration = new \sfAltumoPlugin\Deployment\DatabaseUpdaterConfigurationFile( $default_updater_configuration_file );
            
            $command = "mysql -u" . $xml_updater_configuration->getDatabaseUsername() .
                        " -p" . $xml_updater_configuration->getDatabasePassword() .
                        " -h" . $xml_updater_configuration->getDatabaseHostname() .
                        " " . $xml_updater_configuration->getDatabaseName() . "\n";
            
            umask(0022);            
            file_put_contents( $shell_file, $command );
            chmod( $shell_file, 0755 );
            
            `$command`;
        
    }
    
}
