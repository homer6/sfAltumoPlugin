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
            new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
            new sfCommandOption('robot_instance_id', 'id', sfCommandOption::PARAMETER_REQUIRED, 'the sf_altumo_plugin_automation_robot instance id that originated this call', null)
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

        // Get an instance of the model that initiated this robot
            $robot_instance_id = \Altumo\Validation\Numerics::assertPositiveInteger(
                $options['robot_instance_id'],
                'robot_instance_id expects positive int'
            );
            
            $automation_robot = \AutomationRobotPeer::assertAndRetrieveByIdAndName( $robot_instance_id, $robot_name );

            
        // Robots are expected to be in the \Automation\Robot namespace
            $robot_class = '\\Automation\\Robot\\' . $robot_name;
            
            if( !class_exists($robot_class) ){
                throw new \Exception( "{$robot_class} does not exist." );
            }
            
            $robot_factory_callable = array( $robot_class, "create" );
            
            if( !is_callable($robot_factory_callable) ){
                throw new \Exception( "$robot_class does not have a create method" );
            }

            try{
                
                $robot = call_user_func( $robot_factory_callable );
                if(0) $robot = new \Automation\Robot\sendNotificationOnProductSoldOut();

                \Altumo\Validation\Objects::assertObjectInstanceOfClass(
                    $robot,
                    '\sfAltumoPlugin\Automation\Robot\Base',
                    'Robot\'s create method didn\'t return an instancce of \sfAltumoPlugin\Automation\Robot\Base'
                );

                $robot->setAutomationRobot($automation_robot);
                $robot->run();
                
                
            } catch( \Exception $e ){
                
                throw new \Exception( "The robot has ended with an exception:\n" . $e->getMessage() );
                
            }
       
    }
    
}
