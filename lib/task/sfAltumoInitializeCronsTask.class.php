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
 * Applies a single data_update to the database. This task is executed automatically
 * during the update-database process and should not be called manually.
 * 
 * This process has to be performed in a separate process because the working tree
 * is taken to different commits during the process and caching, namespaces and
 * other factors would interfere.
 * 
 * @author Juan Jaramillo <juan.jaramillo@altumo.com>
 */
class sfAltumoInitializeCronsTask extends sfAltumoBaseTask {

    /**
    * @see sfTask
    */
    protected function configure() {
        
        parent::configure();
        
        $this->addArguments(array(
            //new sfCommandArgument( 'hash', sfCommandArgument::REQUIRED, 'hash of the script to apply, or "new" to test uncommitted data_update.' )
        ));
        
        $this->addOptions(array(
            //new sfCommandOption( 'database-directory', null, sfCommandOption::PARAMETER_REQUIRED, 'The database directory.', null )
            new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', 'api'),
            new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
            new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel')
        ));

        $this->name = 'initialize-crons';
        
        $this->aliases = array( 'altumo:crons' );

        $this->briefDescription = 'Initializes scheduled tasks';

    $this->detailedDescription = <<<EOF
EOF;
    }

    
   /**
   * @see sfTask
   */
    protected function execute( $arguments = array(), $options = array() ) {

        // Initialize Updated configuration
            $data_dir = sfConfig::get( 'sf_data_dir' );

        // Initialize database
            $databaseManager = new sfDatabaseManager($this->configuration);           
            
        // Stop all running tasks (gracefully) first.
            \sfAltumoPlugin\Automation\ScheduledTask::create()
                ->findAll()
            ->stop();

        // Get a list of scheduled tasks to set up
            $scheduled_tasks = \sfConfig::get("app_automation_scheduled_tasks");
            
            foreach( $scheduled_tasks as $scheduled_task ){
                
                \sfAltumoPlugin\Automation\ScheduledTask::create()
                    ->addNew( $scheduled_task['command'], $scheduled_task['frequency'] )
                ->start();
                
            }
            
        // Show all running tasks
            $running_tasks = \sfAltumoPlugin\Automation\ScheduledTask::getAllRunningTasks();
        
            if( empty($running_tasks) ){
                $this->logBlock( 'No tasks are running.', 'INFO' );
            }

            foreach( $running_tasks as $running_task ){
                $this->logSection( '+task', $running_task['command'] );
            }
       
    }
    
}
