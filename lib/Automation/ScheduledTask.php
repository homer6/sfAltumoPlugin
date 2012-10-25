<?php

/*
 * This file is part of the Altumo library.
 *
 * (c) Steve Sperandeo <steve.sperandeo@altumo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace sfAltumoPlugin\Automation;


/**
* 
* 
* @author Juan Jaramillo <juan.jaramillo@altumo.com>
*/
class ScheduledTask {
    
    const FREQUENT_CRON = "/../../bin/frequent-cron/frequent-cron";

    /**
    * Constructor for this ScheduledTask
    * 
    * 
    * @return \sfAltumoPlugin\Automation\ScheduledTask
    */
    public function __construct(){
        
        $this->initialize();
        
    }
    
    
    protected function initialize(){
        
        $this->assertFrequentCronExists();

    }
    
    
    protected function getFrequentCronPath(){
        
        return dirname(__FILE__) . self::FREQUENT_CRON;
        
    }
    
    
    protected function assertFrequentCronExists(){

        if( !file_exists($this->getFrequentCronPath()) ){
            throw new \Exception( "frequent-cron has not been compiled.\nLook at " . $this->getFrequentCronPath() );
        }
        
    }
    
    
    public function getRunningTasks(){
    
        $all_processes = \Altumo\Utils\SystemProcess::getRunningProcesses();
        
    }
    
    /**
    * put your comment there...
    * 
    */
    public static function create(){
        
        return new self();
        
    }

}
