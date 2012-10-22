<?php

/*
 * This file is part of the sfAltumoPlugin library.
 *
 * (c) Steve Sperandeo <steve.sperandeo@altumo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace sfAltumoPlugin\Automation\Robot;

/**
* Base class from which all automation robots extend from.
* 
* Application automation robots must be in the \Automation\Robot namespace
* and usually located in lib/Automation/Robot
* 
* There's the possibility of expanding the system to allow for plugin robots that
* would live within the plugin.
* 
* @author Juan Jaramillo <juan.jaramillo@altumo.com>
*/
class Base implements RobotInterface {
    
    protected $automation_robot = null;
    
    
    /**
    * Constructor for this Robot
    * 
    * @return \sfAltumoPlugin\Automation\Robot\Base
    */
    public function __construct(){

    }

    
    /**
    * Robot factory. Get a new instance of this Robot.
    * 
    * @return \sfAltumoPlugin\Automation\Robot\Base
    */
    public static function create( ){
        
        $class = get_called_class();
        
        return new $class();
        
        return new static();

    }
    

    /**
    * Sets the parameters array
    * 
    * @param \AutomationRobot $automation_robot
    *   // The model instance that triggered this robot to run
    * 
    * @return \sfAltumoPlugin\Automation\Robot\Base
    */
    public function setAutomationRobot( $automation_robot ){
        
        \Altumo\Validation\Objects::assertObjectInstanceOfClass(
            $automation_robot,
            '\\AutomationRobot',
            '$automation_robot expects \\AutomationRobot'
        );
        
        $this->automation_robot = $automation_robot;
        
    }    

    
    /**
    * Get the parameters array. To get a single parameter use getParameter()
    * 
    * @return array
    */
    protected function getAutomationRobot(){

        return $this->automation_robot;
        
    }
    
    
    /**
    * This is where the work actually takes place.
    * 
    * @return void
    */
    public function run(){

    }

} 