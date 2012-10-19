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
 * Executes an automation Robot
 * See \sfAltumoPlugin\Automation\Robot
 * 
 * @author Juan Jaramillo <juan.jaramillo@altumo.com>
 */
class sfAltumoAutomationExecuteRobotTask extends sfAltumoBaseTask {

    /**
    * @see sfTask
    */
    protected function configure() {
        
        parent::configure();
        
        $this->addArguments(array(
            new sfCommandArgument( 'robot_name', sfCommandArgument::REQUIRED, 'name of the robot to execute.' )
        ));
        
        $this->addOptions(array(
            //new sfCommandOption( 'database-directory', null, sfCommandOption::PARAMETER_REQUIRED, 'The database directory.', null )
            new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', null),
            new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
            new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel')
        ));

        $this->name = 'automation-run-robot';

        $this->briefDescription = 'Executes a specific automation robot';
    }

    
   /**
   * @see sfTask
   */
    protected function execute( $arguments = array(), $options = array() ) {

        // Initialize Updated configuration
            $data_dir = sfConfig::get( 'sf_data_dir' );

        // Initialize database
            $databaseManager = new sfDatabaseManager($this->configuration);

        // Get robot's name from parameters
            $robot_name = \Altumo\Validation\Strings::assertNonEmptyString(
                $arguments['robot_name'],
                'robot_name expects a non-empty string'
            );

        // Robots are expected to be in the \Automation\Robot namespace
            $robot_class = '\\Automation\\Robot\\' . $robot_name;
            
            if( !class_exists($robot_class) ){
                throw new \Exception( "{$robot_class} does not exist." );
            }
            
            $robot_run_callable = array( $robot_class, "run" );
            
            if( !is_callable($robot_run_callable) ){
                throw new \Exception( "$robot_class does not have a run method" );
            }

            try{
                
                call_user_func( $robot_run_callable );
                    
            } catch( \Exception $e ){
                
                throw new \Exception( "The robot has ended with an exception:\n" . $e->getMessage() );
                
            }
       
    }
    
}
