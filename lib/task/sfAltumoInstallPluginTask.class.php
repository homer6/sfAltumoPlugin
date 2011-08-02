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
 * Installs sfAltumoPlugin into an existing symfony 1.4 / propel 1.6 application.
 * 
 * @author Steve Sperandeo <steve.sperandeo@altumo.com>
 */
class sfAltumoInstallPluginTask extends sfAltumoBaseTask {

    /**
    * @see sfTask
    */
    protected function configure() {
        
        parent::configure();
        
        $this->addArguments(array(
            //new sfCommandArgument( 'username', sfCommandArgument::OPTIONAL, 'The database username', 'root' ),
        ));

        /*
        $this->addOptions(array(
            new sfCommandOption( 'database-host', null, sfCommandOption::PARAMETER_REQUIRED, 'The hostname of the MySQL database.', 'localhost' ),
        ));
        */

        //./symfony altumo:install localhost my_db_user my_db_password my_database my.dev.domain.com dev_ssperandeo

        $this->name = 'install-plugin';

        $this->briefDescription = 'Installs sfAltumoPlugin into an existing symfony 1.4 / propel 1.6 application.';

    $this->detailedDescription = <<<EOF
Sets up all the things necessary to get sfAltumoPlugin installed:
 - creates the database folders
EOF;
    }


    /**
    * @see sfTask
    */
    protected function execute( $arguments = array(), $options = array() ) {
        
        
        //get the project root and database dir
            $project_root = realpath( sfConfig::get('sf_root_dir') . '/../../' );
            $database_dir = sfConfig::get('sf_data_dir');
            
            
            $create_directories = array( 
                $database_dir . '/drops',
                $database_dir . '/new',
                $database_dir . '/snapshots',
                $database_dir . '/sql',
                $database_dir . '/upgrade_scripts'            
            );
            
            foreach( $create_directories as $directory ){
                
                if( !file_exists($directory) ){
                    mkdir( $directory );
                    touch( $directory . '/.gitignore' );
                }

            }
            
            $database_dir_ignore = <<<IGNORE
update-log.xml
updater-configuration.xml            
IGNORE;
            
            file_put_contents( $database_dir . '/.gitignore', $database_dir_ignore );


            $next_steps = <<<STEPS
            
    NEXT STEPS:
        
        //make an "api" app if one doesn't already exist

        //add the following lines (replace the existing) to the "api" app's factories.yml
            response:
                class: \\sfAltumoPlugin\\Api\\ApiResponse

            request:
                class: \\sfAltumoPlugin\\Api\\ApiRequest



        //run the application install now
            ./symfony altumo:install

            
STEPS;
        
        echo $next_steps . "\n";
    }
    
}
