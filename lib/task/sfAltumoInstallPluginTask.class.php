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
            
            $make_git_ignore = function( $directory, $contents = null ){
                    
                if( !file_exists($directory) ){
                    mkdir( $directory, 0775, true );                    
                }
                if( is_null($contents) ){
                    touch( $directory . '/.gitignore' );
                }else{
                    file_put_contents( $directory . '/.gitignore', $contents );
                }                
                
            };
            
            
        //add all of the gitignore files
            $create_directories = array( 
                $database_dir . '/drops',
                $database_dir . '/new',
                $database_dir . '/snapshots',
                $database_dir . '/sql',
                $database_dir . '/upgrade_scripts',
                $project_root . '/htdocs/project/test',
                $project_root . '/documents/technical',
                $project_root . '/documents/design/published'
            );            
            foreach( $create_directories as $directory ){                
                $make_git_ignore( $directory );
            }
            
            $ignore_pattern = <<<IGNORE
*
!.gitignore

IGNORE;
            $make_git_ignore( $project_root . '/htdocs/project/log', $ignore_pattern );
            $make_git_ignore( $project_root . '/htdocs/project/cache', $ignore_pattern );
            $make_git_ignore( $project_root . '/htdocs/logs', '*.log' );
            
            $database_dir_ignore = <<<IGNORE
update-log.xml
updater-configuration.xml

IGNORE;
            $make_git_ignore( $database_dir, $database_dir_ignore );
            
            $ignore = <<<IGNORE
index.php
api.php

IGNORE;
            $make_git_ignore( sfConfig::get('sf_web_dir'), $ignore );

            
            //create the web symlink to sfAltumoPlugin/web
                symlink( '../plugins/sfAltumoPlugin/web', $project_root . '/htdocs/project/web/altumo' );

                
            //show the next steps 
                $next_steps = <<<STEPS
            
    NEXT STEPS:
        
        //make an "api" app if one doesn't already exist
            ./symfony generate:app api

        //add the following lines (replace the existing) to the "api" app's factories.yml
            response:
                class: \\\\sfAltumoPlugin\\\\Api\\\\ApiResponse

            request:
                class: \\\\sfAltumoPlugin\\\\Api\\\\ApiRequest

        //you may want to copy parts of the layout from the blank project
            https://github.com/homer6/blank_altumo/blob/master/htdocs/project/apps/frontend/templates/layout.php
                
        //run the application install now
            ./symfony altumo:install
            
        //add all of the changed files to git (everything else should already be ignored)

            
STEPS;
        
                echo $next_steps . "\n";
    }
    
}
