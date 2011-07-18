<?php

/*
 * This file is part of the sfAltumoPlugin library.
 *
 * (c) Steve Sperandeo <steve.sperandeo@altumo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace sfAltumoPlugin\Deployment;
 

/**
* Top level object to update a website environment to a different build.
* 
* @author Steve Sperandeo <steve.sperandeo@altumo.com>
*/
class ApplicationUpdater{
  
    protected $project_root = null;


    /**
    * Constructor for this ApplicationUpdater.
    * 
    * @return \sfAltumoPlugin\Deployment\ApplicationUpdater
    */
    public function __construct( $project_root ){    
    
        if( !file_exists($project_root) ){
            throw new \Exception( 'Directory: ' . $project_root . ' does not exist or is not readable.' );
        }
        
        $subdirs = \Altumo\Utils\Finder::type('dir')->maxdepth(0)->relative()->in( $project_root );
        
        if( !in_array( 'htdocs', $subdirs ) ){
            throw new \Exception( 'Project root must have an htdocs subdirectory.' );
        }
        
        $this->setProjectRoot( $project_root );
     
    }        
    
    
    /**
    * Setter for the project_root field on this ApplicationUpdater.
    * 
    * @param string $project_root
    */
    protected function setProjectRoot( $project_root ){
    
        $this->project_root = $project_root;
        
    }
    
    
    /**
    * Getter for the project_root field on this ApplicationUpdater.
    * 
    * @return string
    */
    protected function getProjectRoot(){
    
        return $this->project_root;
        
    }
    
    
    /**
    * This method updates the application by:
    * 
    *   - Pulling the latest copy from the default git remote
    *   - Clearing the cache
    *   - Doing a database build
    * 
    */
    public function update(){
        
        throw new \Exception( 'Build database task not implemented.' );
        
        $commands = array(
            'git pull',
            'git submodule sync',
            'git submodule update --init --recursive',
            $this->getProjectRoot() . '/htdocs/project/symfony cc',
            $this->getProjectRoot() . '/htdocs/project/cli/build-database.php build'
        );
        
        foreach( $commands as $command ){
            echo $command . "\n";
            `$command`;
        }
        
    }

    
}
