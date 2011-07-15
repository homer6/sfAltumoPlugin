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
class sfAltumoUpdateEnvironmentTask extends sfAltumoBaseTask {

    /**
    * @see sfTask
    */
    protected function configure() {
        
        parent::configure();
        
        $this->addArguments(array(
            //new sfCommandArgument( 'command', sfCommandArgument::REQUIRED, 'The subcommand.' ),
        ));

        $this->addOptions(array(
            //new sfCommandOption( 'output_file', null, sfCommandOption::PARAMETER_OPTIONAL, 'The path of the target Javascript file', null ),
        ));


        $this->name = 'update-environment';
        $this->aliases = array( $this->namespace. ':update' );

        $this->briefDescription = 'Updates the application evironment.';

    $this->detailedDescription = <<<EOF
Updating existing separate environments (production, staging, dev) requires many
steps.

This script pulls from the default remote, updates the database (or applies 
deltas) and clears the project cache.
EOF;
    }

    
   /**
   * @see sfTask
   */
    protected function execute( $arguments = array(), $options = array() ) {

        try{
            
            $project_root = sfConfig::get( 'sf_root_dir' );
            $application_builder = new \sfAltumoPlugin\Deployment\ApplicationUpdater( $project_root );                    
            $application_builder->update();

        }catch( Exception $e ){
            
            $this->log( $e->getMessage() );
            
        }
        
    }
    
}
