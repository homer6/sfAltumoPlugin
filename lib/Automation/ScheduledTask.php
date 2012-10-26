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
* This class facilitates management of frequent-cron managed, repeating tasks.
* 
* This class makes exclusive use of the frequent-cron binary located in
* sfAltumoPlugin/bin/frequent-cron. 
* 
* The source (also in that directory) must be compiled first, and the binary
* should not be used directly or without going through this class. 
* 
* @todo Implement pid files to manage running tasks as opposed to taking 
*       full control of the frequent-cron binary
* 
* 
* Samples:
*   
*   // Stop all running tasks
*           \sfAltumoPlugin\Automation\ScheduledTask::create()
*                ->findAll()
*            ->stop();
*            
*    // Run new task
*            \sfAltumoPlugin\Automation\ScheduledTask::create()
*                ->addNew( 'echo abc123', 5000 )
*            ->start();
* 
*   // List all running tasks
*           $running_tasks = \sfAltumoPlugin\Automation\ScheduledTask::getAllRunningTasks();
* 
* 
* @author Juan Jaramillo <juan.jaramillo@altumo.com>
*/
class ScheduledTask {

    const FREQUENT_CRON = "/../../bin/frequent-cron/frequent-cron";

    protected $selected_processes = array();


    /**
    * Constructor for this ScheduledTask
    * 
    * 
    * @return \sfAltumoPlugin\Automation\ScheduledTask
    */
    public function __construct(){

        $this->initialize();

    }


    /**
    * Get array of processes that have been selected for action.
    * 
    * @return array
    */
    protected function getSelectedProcesses(){

        return $this->selected_processes;

    }

    
    /**
    * Clear list of selected processes.
    * 
    * @return void
    */
    protected function clearSelectedProcesses(){

        $this->selected_processes = array();

    }


    /**
    * Adds an entry to the selected processes array.
    * 
    * @param array $process
    *   // an array with [user_id], [process_id] and command as keys
    *   // see \Altumo\Utils\SystemProcess::getRunningProcesses
    * 
    * @return void
    */
    protected function addSelectedProcess( $process ){

        \Altumo\Validation\Arrays::assertArray( 
            $process,
            '$process expects array'
        );

        if( !isset($process['command']) ){

            throw new \Exception( '$process expects process_id, user_id and command as keys' );

        }
        
        // mark the task as running if it has a process_id
            $process['running'] = array_key_exists('process_id', $process ) && strlen($process['process_id']);
        
        // add to the stack if it doesn't already exist
            $this->selected_processes[sha1($process['command'])] = $process;

    }


    /**
    * Initializes this ScheduledTask
    * 
    * @return void
    */
    protected function initialize(){
        
        $this->assertFrequentCronExists();

    }
    
    
    /**
    * Get the path to the frequent-cron binay that lives within the plugin
    * 
    * @return string
    *   // full system path to frequent-cron
    */
    protected static function getFrequentCronPath(){
        
        return dirname(__FILE__) . self::FREQUENT_CRON;
        
    }
    
    
    /**
    * Ensure that the frequent-cron binary exists and is executable.
    * 
    * @throws \Exception
    *   // if frequent-cron does not exist
    *   // or if frequent-cron is not executable
    * 
    * @return void
    */
    protected function assertFrequentCronExists(){

        if( !file_exists(self::getFrequentCronPath()) ){
            throw new \Exception( "frequent-cron has not been compiled.\nLook at " . self::getFrequentCronPath() );
        }
        
        if( !is_executable(self::getFrequentCronPath()) ){
            throw new \Exception( "frequent-cron cannot be executed. Please fix permissions at " . self::getFrequentCronPath() );
        }

    }
    
    
    /**
    * Get an array of all scheduled task processes that are currently running.
    * 
    * @return array
    *   // of task processes. 
    *   // See \Altumo\Utils\SystemProcess::getRunningProcesses for details
    */
    public static function getAllRunningTasks(){
        
        // get all frequent cron tasks running as this user and from the plugin's path
            return \Altumo\Utils\SystemProcess::getRunningProcesses(
                trim(`whoami`),
                '%^' . preg_quote(self::getFrequentCronPath()) . '.*$%m'
            );
        
    }
    
    
    /**
    * Selects all ScheduledTasks that are currently running.
    * 
    * 
    * @return \sfAltumoPlugin\Automation\ScheduledTask
    */
    public function findAll(){

        // get all frequent cron tasks running as this user and from the plugin's path
            $task_processes = \Altumo\Utils\SystemProcess::getRunningProcesses(
                trim(`whoami`),
                '%^' . preg_quote(self::getFrequentCronPath()) . '.*$%m'
            );
            
        foreach($task_processes as $task_process ){
            $this->addSelectedProcess( $task_process );
        }
        
        return $this;

    }    
    
    
    /**
    * Select a current task for action by command.
    * 
    * @param string $command
    *   // the full command to find a task by
    * 
    * @return \sfAltumoPlugin\Automation\ScheduledTask
    */
    public function findOneByCommand( $command ){

        $command = \Altumo\Validation\Strings::assertNonEmptyString(
            $command,
            '$command expects a non-empty string'
        );
        
        // get all frequent cron tasks running as this user and from the plugin's path
            $task_process = \Altumo\Utils\SystemProcess::getRunningProcesses(
                trim(`whoami`),
                '%^' . preg_quote($command) . '$%m'
            );
            
        if( !empty($task_process) ){
            $this->addSelectedProcess( reset($task_process) );
        }
        
        return $this;
        
    }
    
    
    protected function composeFrequentCronCommand( $command, $frequency ){

        $command = \Altumo\Validation\Strings::assertNonEmptyString(
            $command,
            '$command expects non-empty string'
        );
        
        $frequency = \Altumo\Validation\Numerics::assertPositiveInteger(
            $frequency,
            '$frequency expects positive integer'
        );
        
        return sprintf(
            self::getFrequentCronPath() . " --command=%s --frequency=%s",
            escapeshellarg($command),
            escapeshellarg($frequency)
        );

    }


    /**
    * Adds a new task to the list, so that it can be started with start()
    * 
    * @param string $command
    *   // the command to be executed periodically
    * 
    * @param int frequency
    *   // frequency in milliseconds for command execution
    * 
    * @return \sfAltumoPlugin\Automation\ScheduledTask
    */
    public function addNew( $command, $frequency ){

        $this->addSelectedProcess(
            array(
                'command' => $this->composeFrequentCronCommand( $command, $frequency )
            )
        );
        
        return $this;
        
    }
    
    
    
    /**
    * Starts any new tasks added via addNew
    * 
    * @return void
    */
    public function start(){

        // Pre-select all running tasks, so that they're not started again
            $this->findAll();
        
        $started = 0;

        foreach( $this->getSelectedProcesses() as $process ){

            if( !$process['running'] ){

                shell_exec( $process['command'] );
                
                $started++;

            }

        }

        if( $started == 0 ){
            throw new \Exception( 'There were no ScheduledTasks to start' );
        }
        
        $this->clearSelectedProcesses();

    }

    
    /**
    * Kills all selected ScheduledTasks.
    * 
    * @param array|null $not_killed
    *   // a reference to an array that will be filled with any process_ids that
    *   // could not be killed for any reason.
    * 
    * @return void
    */
    public function stop( $not_killed = null ){
        
        if( !is_null($not_killed) ){
            \Altumo\Validation\Arrays::assertArray(
                $not_killed,
                '$not_killed expects null or array'
            );
        }
        
        // get all frequent cron tasks running as this user and from the plugin's path
            $task_processes = $this->getSelectedProcesses();
            
            foreach( $task_processes as $task_process ){
                
                // skip if process doesn't have a process_id
                    if( !array_key_exists('process_id', $task_process) || !strlen($task_process['process_id']) ){
                        continue;
                    }
                
                $result = \Altumo\Utils\SystemProcess::killProcess( $task_process['process_id'] );
                
                if( !is_null($not_killed) ){
                    $not_killed[] = $result;
                }
                
            }
            
        $this->clearSelectedProcesses();
            
    }
    
    
    /**
    * Create a new ScheduledTask
    * 
    * @return \sfAltumoPlugin\Automation\ScheduledTask
    */
    public static function create(){
        
        return new self();
        
    }

}
