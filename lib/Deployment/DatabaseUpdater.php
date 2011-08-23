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
* This class is an object that updates the database based on the current state
* of the database (via the log file) compared to the state of the application
* models (via the database sequence file). It is used to ensure that an 
* environment can be updated, along with the model classes, to ensure that 
* both the database and the class models are always in sync.
* 
* @author Steve Sperandeo <steve.sperandeo@altumo.com>
* @author Juan Jaramillo <juan.jaramillo@altumo.com>
*/
class DatabaseUpdater{
    
    const DELTA_TYPE_DROP = 'drop';
    const DELTA_TYPE_UPGRADE_SCRIPT = 'upgrade_script';
    const DELTA_TYPE_DATA_UPDATE = 'data_update';
    const DELTA_TYPE_SNAPSHOT = 'snapshot';
    
    
    protected $database_updater_configuration_file = null;
    protected $database_build_sequence_file = null;
    protected $database_update_log_file = null;
    
    
    /**
    * Creates a new DatabaseUpdater object
    * 
    * @param \sfAltumoPlugin\Deployment\DatabaseUpdaterConfigurationFile $database_builder_configuration_file
    * @param \sfAltumoPlugin\Build\DatabaseBuildSequenceFile $database_build_sequence_file
    * @param \sfAltumoPlugin\Deployment\DatabaseUpdateLogFile $database_build_log_file
    * 
    * @return \sfAltumoPlugin\Deployment\DatabaseUpdater
    */
    public function __construct( 
        \sfAltumoPlugin\Deployment\DatabaseUpdaterConfigurationFile $database_updater_configuration_file,
        \sfAltumoPlugin\Build\DatabaseBuildSequenceFile $database_build_sequence_file,
        \sfAltumoPlugin\Deployment\DatabaseUpdateLogFile $database_update_log_file
    ){
        
        $this->setDatabaseUpdaterConfigurationFile( $database_updater_configuration_file );
        $this->setDatabaseBuildSequenceFile( $database_build_sequence_file );
        $this->setDatabaseUpdateLogFile( $database_update_log_file );
        $this->initialize();
                
    }
    
    
    /**
    * Sets up the database connection and other startup functionality.
    * This is called from the constructor.
    * 
    * @throws PdoException //if cannot connect to database
    */
    protected function initialize(){
        
        //this is used to check if the database connection credentials are correct
        $pdo = new \PDO(
            'mysql:host=' . $this->getDatabaseUpdaterConfigurationFile()->getDatabaseHostname() . ';dbname=' . $this->getDatabaseUpdaterConfigurationFile()->getDatabaseName(),
            $this->getDatabaseUpdaterConfigurationFile()->getDatabaseUsername(),
            $this->getDatabaseUpdaterConfigurationFile()->getDatabasePassword(),
            array( \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8" )
        );
        
    }
    
    
    /**
    * Setter for the database_updater_configuration_file field on this 
    * DatabaseUpdater.
    * 
    * @param \sfAltumoPlugin\Deployment\DatabaseUpdaterConfigurationFile  $database_updater_configuration_file
    */
    protected function setDatabaseUpdaterConfigurationFile( $database_updater_configuration_file ){
    
        $this->database_updater_configuration_file = $database_updater_configuration_file;
        
    }
    
    
    /**
    * Getter for the database_updater_configuration_file field on this
    * DatabaseUpdater.
    * 
    * @return \sfAltumoPlugin\Deployment\DatabaseUpdaterConfigurationFile 
    */
    protected function getDatabaseUpdaterConfigurationFile(){
    
        return $this->database_updater_configuration_file;
        
    }
        
    
    /**
    * Setter for the database_build_sequence_file field on this DatabaseUpdater.
    * 
    * @param \sfAltumoPlugin\Build\DatabaseBuildSequenceFile  $database_build_sequence_file
    */
    protected function setDatabaseBuildSequenceFile( $database_build_sequence_file ){
    
        $this->database_build_sequence_file = $database_build_sequence_file;
        
    }
    
    
    /**
    * Getter for the database_build_sequence_file field on this DatabaseUpdater.
    * 
    * @return \sfAltumoPlugin\Build\DatabaseBuildSequenceFile 
    */
    protected function getDatabaseBuildSequenceFile(){
    
        return $this->database_build_sequence_file;
        
    }
        
    
    /**
    * Setter for the database_update_log_file field on this DatabaseUpdater.
    * 
    * @param \sfAltumoPlugin\Deployment\DatabaseUpdateLogFile $database_update_log_file
    */
    protected function setDatabaseUpdateLogFile( $database_update_log_file ){
    
        $this->database_update_log_file = $database_update_log_file;
        
    }
    
    
    /**
    * Getter for the database_update_log_file field on this DatabaseUpdater.
    * 
    * @return \sfAltumoPlugin\Deployment\DatabaseUpdateLogFile
    */
    protected function getDatabaseUpdateLogFile(){
    
        return $this->database_update_log_file;
        
    }
    
    
    /**
    * Drops all of the tables in this database.
    * 
    * @param array $parameters //CLI Parameters
    * @return integer //number of scripts that were applied
    */
    public function drop( $parameters ){
        
        $script_count = 0;
        
        //get the latest applied hash
            $last_applied_script = $this->getDatabaseUpdateLogFile()->getLastLogEntry();
            if( is_null($last_applied_script) ){
                $last_applied_type = null;
                $last_applied_hash = null;                
            }else{
                $last_applied_type = strtolower($last_applied_script->getName());
                $last_applied_hash = $last_applied_script->xpath('attribute::hash');
            }
            
        //exit if last build was a drop
            if( is_null( $last_applied_hash ) || $last_applied_type == self::DELTA_TYPE_DROP ){
                //no work to do, last change was a drop
                return;
            }
            
        //get the last drop and apply it
            $previous_drops = $this->getDatabaseBuildSequenceFile()->getDropHashesBefore( $last_applied_hash );
            if( empty($previous_drops) ){
                throw new \Exception('No previous drops found.');
            }else{
                $this->applyScript( end($previous_drops), self::DELTA_TYPE_DROP );
                ++$script_count;
            }
            
        return $script_count;
            
    }
    
    
    /**
    * Applies any available database update scripts to the current database.
    * Does not apply any that have already been applied to this database.
    * 
    * @param array $parameters //CLI Parameters
    * @return integer //number of scripts that were applied
    */
    public function update( $parameters ){
        
        $script_count = 0;
        
        //get the latest applied hash in the application update log
            $last_applied_script = $this->getDatabaseUpdateLogFile()->getLastLogEntry();
            if( is_null($last_applied_script) ){
                $last_applied_type = null;
                $last_applied_hash = null;
            }else{
                $last_applied_type = strtolower($last_applied_script->getName());
                $last_applied_hash = $last_applied_script->xpath('attribute::hash');
            }
        
        //if empty or if the last command was a drop, assume empty and apply the latest snapshot and all subsequent upgrades
        //else, apply all the unapplied upgrades
            if( is_null( $last_applied_hash ) || $last_applied_type == self::DELTA_TYPE_DROP ){
                
                $snapshot_hash = $this->getDatabaseBuildSequenceFile()->getLastestSnapshotHash();
                if( !$snapshot_hash ){
                    try{
                        $first_upgrade_hash = $this->getDatabaseBuildSequenceFile()->getFirstUpgrade();
                        $this->applyScript( $first_upgrade_hash, self::DELTA_TYPE_UPGRADE_SCRIPT ); 
                        ++$script_count;
                        $hash = $first_upgrade_hash;
                    }catch( \Exception $e ){
                        throw new \Exception('Your build sequence is empty. No work to be done.');
                    }
                }else{
                    $this->applyScript( $snapshot_hash, self::DELTA_TYPE_SNAPSHOT ); 
                    ++$script_count;
                    $hash = $snapshot_hash;
                }
                
            }else{
                
                $hash = $last_applied_hash;
                
            }
            
            // Apply SQL upgrade scripts
                $upgrade_hashes = $this->getDatabaseBuildSequenceFile()->getPhpOrSqlUpgradeHashesSince( $hash );
                
                foreach( $upgrade_hashes as $upgrade_hash ){
                    
                    // If this hash has an SQL upgrade script
                        if( $this->getDatabaseBuildSequenceFile()->isUpgradeHash($upgrade_hash) ){
                            $this->applyScript( $upgrade_hash, self::DELTA_TYPE_UPGRADE_SCRIPT );
                            ++$script_count;
                        }
                    
                    // If this hash has a php upgrade script
                        if( $this->getDatabaseBuildSequenceFile()->isDataUpdateHash($upgrade_hash) ){
                            $this->applyDataUpdate( $upgrade_hash );
                            ++$script_count;
                        }

                }

        return $script_count;
        
    }
    
    
    /**
    * Applies a drop, snapshot or upgrade script to the current database.
    * 
    * @param string $hash                   //the commit hash of the delta
    * @param string $delta_type             //the type of delta (snapshot, 
    *                                         upgrade, drop)
    * @param boolean $altumo_delta          //whether this delta comes from the
    *                                         sfAltumoPlugin build sequence
    * 
    * @throws \Exception if build_type is unknown
    * @throws \Exception if script file does not exist
    */    
    protected function applyScript( $hash, $delta_type = self::DELTA_TYPE_UPGRADE_SCRIPT, $altumo_delta = false ){
        
        //validate delta type
            if( !in_array($delta_type, array( self::DELTA_TYPE_UPGRADE_SCRIPT, self::DELTA_TYPE_DROP, self::DELTA_TYPE_SNAPSHOT ) ) ){
                throw new \Exception('Unknown build type.');
            }
        
        //determine the sql script filename and ensure the file exists
            $database_filename =  $this->getDatabaseUpdaterConfigurationFile()->getDatabaseDirectory() . '/' . $delta_type . 's/' . $delta_type . '_' . $hash . '.sql';
            $sf_altumo_delta = false;
            if( !file_exists($database_filename) ){
                //try to find it in the sfAltumoPlugin folder too
                $sf_altumo_database_filename =  $this->getDatabaseUpdaterConfigurationFile()->getDatabaseDirectory() . '/../plugins/sfAltumoPlugin/data/' . $delta_type . 's/' . $delta_type . '_' . $hash . '.sql';
                if( !file_exists($sf_altumo_database_filename) ){
                    throw new \Exception('Script File "' . $database_filename . '" does not exist.');
                }else{
                    $database_filename = $sf_altumo_database_filename;
                    $sf_altumo_delta = true;
                }
            }
        
        //build and run the shell command (using the mysql client)
            $command = "mysql -u" . $this->getDatabaseUpdaterConfigurationFile()->getDatabaseUsername() .
                        " -p" . $this->getDatabaseUpdaterConfigurationFile()->getDatabasePassword() .
                        " -h" . $this->getDatabaseUpdaterConfigurationFile()->getDatabaseHostname() .
                        " " . $this->getDatabaseUpdaterConfigurationFile()->getDatabaseName() .
                        " < " . $database_filename;
            `$command`;
        
        //log the action
            switch( $delta_type ){
                case self::DELTA_TYPE_UPGRADE_SCRIPT:
                    $this->getDatabaseUpdateLogFile()->addUpgrade( $hash, $sf_altumo_delta );
                    break;
                    
                case self::DELTA_TYPE_DROP:
                    $this->getDatabaseUpdateLogFile()->addDrop( $hash, $sf_altumo_delta );
                    break;
                    
                case self::DELTA_TYPE_SNAPSHOT:
                    $this->getDatabaseUpdateLogFile()->addSnapshot( $hash, $sf_altumo_delta );
                    break;
                    
                default:
                    throw new \Exception('Unknown delta type.');
                
            }
                
        
    }
        
    
    /**
    * Applies a data update 
    * 
    * A data update can perform operations at the application level. They have
    * access to the same functionallity the application does. Data updates can 
    * be used to modify data at the ORM level, or perform other operations
    * conveniently from code.
    * 
    * @param string $hash                   //the commit hash of the delta
    * 
    * @throws \Exception
    *   // if the hash for the commit where the data update file was added cannot be found.
    */    
    protected function applyDataUpdate( $hash ){

        // Remember the current position of the working tree.
            $current_position = \Altumo\Git\Status::getCurrentBranch();
            
        
        // Get the hash where the file was auto-moved to its folder by the build system
            $autocommit_hash = \Altumo\Git\History::getCommitsAfterMatching( 
                "^Autocommit\:\smoving.*" . $hash,
                $hash
            );
        
            if( count($autocommit_hash) != 1 ){
                throw new \Exception( 'Unable to find an Autocommit for hash \"' . $hash . '\"' );
            }
            
            $autocommit_hash = reset( array_keys($autocommit_hash) );

            
        // remember current pwd
            $old_pwd = getcwd();
            
        // Get working tree root path
            $root_path = realpath( \sfConfig::get( 'sf_root_dir' ) . '/../../' );

        // Go to the commit where the data_update script was auto-committed
            \Altumo\Git\WorkingTree::checkout( $autocommit_hash );
            
        // Update submodules
            chdir( $root_path );
            \Altumo\Git\WorkingTree::updateSubmodulesRecursively();
 
        
        //determine the php script filename and ensure the file exists
            $php_filename =  $this->getDatabaseUpdaterConfigurationFile()->getDatabaseDirectory() . '/data_updates/' . 'data_update_' . $hash . '.php';
           
            if( !file_exists($php_filename) ){
                throw new \Exception( 'Script File "' . $php_filename . '" does not exist.' );
            }
        
        // Call the altumo:apply-data-update in a separate process

            $project_path = realpath( \sfConfig::get( 'sf_root_dir' ) );
            
            chdir( $project_path );
            
                $command = "./symfony altumo:apply-data-update {$hash}";
                
                // execute command
                    \Altumo\Utils\Shell::runWithPipedOutput( $command );
                
                // return the tree to where it was before.   
                    \Altumo\Git\WorkingTree::checkout( $current_position );
                    
                // Update submodules
                    chdir( $root_path );
                    \Altumo\Git\WorkingTree::updateSubmodulesRecursively();
            
             chdir( $old_pwd );   
        
    }
    
    
}
