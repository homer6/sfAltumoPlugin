<?php

/*
 * This file is part of the Altumo library.
 *
 * (c) Steve Sperandeo <steve.sperandeo@altumo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace sfAltumoPlugin\Build;


/**
* This class' methods are invoked directly by git's hooks. Use this to execute
* code when git's hooks are called.
* 
* Note: Git hooks must be installed first. 
* Use "./symfony altumo:git-hook-handler install" to install git hooks.
* 
* @author Steve Sperandeo <steve.sperandeo@altumo.com>
*/
class GitHookHandler{
            
    protected $git_root_directory = null;
    protected $database_directory = null;
    protected $application_build_sequence = null;
    protected $altumo_build_sequence = null;
    
    
    /**
    * Constructor for this GitHookHandler.
    * This invokes the handler for the given hook name.
    * 
    * @param string $hook_name
    * 
    * @throws \sfCommandException           //on error
    * @return GitHookHandler
    */
    public function __construct( $hook_name ){    
        
        $old_pwd = getcwd();
        $this->setGitRootDirectory( getenv( 'GIT_ROOT_DIRECTORY' ) );
        $this->setDatabaseDirectory( $this->getGitRootDirectory() . '/data' );
        $this->setImportFromSfAltumo( getenv( 'IMPORT_FROM_SF_ALTUMO' ) );
        chdir( $this->getGitRootDirectory() );
        $this->handle( $hook_name );
        chdir( $old_pwd );
     
    }        
    
    
    /**
    * Main controller for all git hooks. Invokes the proper handler based 
    * on the hook name.
    * 
    * @param string $hook_name
    * 
    * @throws \sfCommandException           //if hook wasn't known or couldn't 
    *                                         be handled
    * 
    * @throws \sfCommandException           //if hook wasn't a non-empty string
    */
    public function handle( $hook_name ){
        
        try{
            \Altumo\Validation\Strings::assertNonEmptyString($hook_name);    
        }catch( \Exception $e ){
            throw new \sfCommandException( 'Hook name was not a non-empty string.' );
        }
        
        switch( $hook_name ){
            
            case 'post-commit':
                $this->onPostCommit();
                break;
            
            case 'post-merge':  //git pull
                $this->onPostMerge();
                break;
            
            default:
                throw new \sfCommandException( sprintf('Hook "%s" does not have a handler.', $hook_name) );
            
        }
        
    }
    
    
    /**
    * Handler that is invoked by the "post-commit" git hook.
    * 
    * Firstly, if $import_from_sf_altumo is true, this method imports new 
    * database deltas from the sfAltumoPlugin build sequence into this 
    * application build sequence.
    * 
    * Then, this method creates a new application "database build" if there is
    * a build to create:
    * 
    * This method moves any "upgrade_script.sql", "drop.sql" or "snapshot.sql"
    * file that is being committed to the "data/new" directory to the
    * corresponding "data/upgrade_scripts", etc. directory and adds the upgrade,
    * drop or snapshot to the build sequence. Other environments running the
    * same application can run "./symfony altumo:update-database update" to 
    * replay the sequence of database changes to their own databases (and 
    * updating their update-log.xml in the process).
    * 
    * @throws \sfCommandException           //on error
    */
    public function onPostCommit(){
        
        $this->createDatabaseDelta();
        
        //import new database deltas from the sfAltumoPlugin build sequence            
            if( $this->calledFromPlugin() ){
                $this->importAltumoDeltasIntoApplicationBuildSequence();                    
            }

    }
        
        
    /**
    * Handler that is invoked by the "post-merge" git hook. This is invoked when
    * running a "git pull" command.
    * 
    * @throws \sfCommandException           //on error
    */
    public function onPostMerge(){
               
        //import new deltas from the sfAltumoPlugin build sequence
            $this->importAltumoDeltasIntoApplicationBuildSequence();
            
    }
    
    
    /**
    * Checks the "data/new" folder for new SQL files. If it finds some (and 
    * they're being committed), it moves them to the appropriate folder and 
    * makes a git commit automatically.
    * 
    */
    protected function createDatabaseDelta(){
        
        $database_dir = $this->getDatabaseDirectory();
        //open the application build sequence for writing
            $xml_application_build_sequence = $this->getApplicationBuildSequence();      
        
        //creates a new application "database build" if there is a delta
        
            //get the last commit hash        
                $last_commit_hash = \Altumo\Git\History::getLastCommitHash();
                
            //check to see if there are any new scripts in the "new" folder  
                $sql_files = $this->getFilesToMove( $last_commit_hash );
                if( empty($sql_files) ){
                    //no sql files to move
                    return;
                }
                
            //move the files to the appropriate place and auto-commit
                $move_commands = array();
                
                $has_snapshot = false;
                $has_drop = false;
                $has_upgrade = false;
                
                foreach( $sql_files as $sql_file ){
                    
                    //detach the extension */
                        if( preg_match('%^(.*/)(.*?)(\\.sql)?$%im', $sql_file, $regs) ){
                            $file_path = $regs[1];
                            $file_stub = $regs[2];
                            $file_extension = $regs[3];
                        }else{
                            throw new \sfCommandException( sprintf('Cannot find file with extension for "%s".', $sql_file) );
                        }
                        
                    //assemble the new filename                
                        switch( $file_stub ){
                            
                            case 'drop':
                                $new_filename = $database_dir . '/drops/' . $file_stub . '_' . $last_commit_hash . $file_extension;
                                $has_drop = true;
                                break;
                            
                            case 'upgrade_script':
                                $new_filename = $database_dir . '/upgrade_scripts/' . $file_stub . '_' . $last_commit_hash . $file_extension;
                                $has_upgrade = true;
                                break;
                            
                            case 'snapshot':
                                $new_filename = $database_dir . '/snapshots/' . $file_stub . '_' . $last_commit_hash . $file_extension;
                                $has_snapshot = true;
                                break;
                                
                            default:
                                throw new \sfCommandException( sprintf('Error: unknown filetype (%s).', $file_stub) );
                            
                        }
                    
                    //move the file and add it to the git repository
                        $move_commands[] = 'git mv ' . $sql_file . ' ' . $new_filename;
                        
                }
                
                //this is in a separate loop so there are no moves executed if one 
                //of the files fails to validate
                    foreach( $move_commands as $move_command ){
                        `$move_command`;
                    }
                
            //update the build sequence log
                $xml_application_build_sequence->addChange( $last_commit_hash, $has_upgrade, $has_drop, $has_snapshot );
                $xml_application_build_sequence->closeFile();
                $shell_command = "git add $database_file";
                `$shell_command`;
                        
            //commit the files
                $shell_command = 'git commit -m "Autocommit: moving sql files to appropriate locations for commit ' . $last_commit_hash . '"';
                `$shell_command`;
                
    }
        
    
    /**
    * Adds the new deltas from the sfAltumoPlugin build sequence to the 
    * application build sequence.
    * 
    * The application build sequence must be open for writing.
    * 
    * @throws \Exception if $xml_application_build_sequence is not open
    * @throws \Exception if $xml_application_build_sequence is not writable
    */
    protected function importAltumoDeltasIntoApplicationBuildSequence(){
                
        $xml_application_build_sequence = $this->getApplicationBuildSequence();
        $xml_sf_altumo_build_sequence = $this->getAltumoBuildSequence();
                
        //get all of the altumo hashes from the application build sequence
            $all_altumo_deltas = $xml_application_build_sequence->getAltumoHashesSince();
                        
        //if the latest delta IS in the application build sequence, nothing to import
            $latest_sf_altumo_hash = $xml_sf_altumo_build_sequence->getLastestHash();
            if( empty($all_altumo_deltas) ){
                $latest_sf_altumo_hash_in_application = '';
            }else{
                $latest_sf_altumo_hash_in_application = end($all_altumo_deltas);
            }                    
            
            if( $latest_sf_altumo_hash === $latest_sf_altumo_hash_in_application ){
                //nothing to import, up to date    
            }else{
                
                //if there are missing sfAltumoPlugin deltas to add to this application build sequence
                    //get all of the deltas in the sfAltumoPlugin build sequence since the lastest one in the application build sequence
                        $pending_deltas = $xml_sf_altumo_build_sequence->getUpgradeHashesSince( $latest_sf_altumo_hash_in_application );
                    
                    //add all of them, in order
                        foreach( $pending_deltas as $delta ){
                            $xml_application_build_sequence->addChange( $delta, true, null, null, true );
                        }
                        
            }
        
    }
    
    
    /**
    * Returns the Application Build Sequence file, open for writing.
    * 
    * @return \sfAltumoPlugin\Build\DatabaseBuildSequenceFile
    */
    protected function getApplicationBuildSequence(){
        
        if( is_null($this->application_build_sequence) ){
            
            //get the environment parameters 
                $git_root_directory = $this->getGitRootDirectory();
                $database_dir = $this->getDatabaseDirectory();
                
            //open the build sequence files
                if( $this->calledFromPlugin() ){
                    $application_filename = $git_root_directory . '/../../data/build-sequence.xml';                
                }else{
                    $application_filename = $database_dir . '/build-sequence.xml';
                }
                $this->application_build_sequence = new \sfAltumoPlugin\Build\DatabaseBuildSequenceFile( $application_filename, false );
                
        }
        
        return $this->application_build_sequence;
        
    }
    
    
    /**
    * Returns the sfAltumoPlugin Build Sequence file, open for reading.
    * 
    * @return \sfAltumoPlugin\Build\DatabaseBuildSequenceFile
    */
    protected function getAltumoBuildSequence(){
        
        if( is_null($this->altumo_build_sequence) ){
        
        //get the environment parameters 
            $database_dir = $this->getDatabaseDirectory();
            
        //open the build sequence files
            if( $this->calledFromPlugin() ){
                $sf_altumo_filename = $database_dir . '/build-sequence.xml';
            }else{
                $sf_altumo_filename = $database_dir . '/../plugins/sfAltumoPlugin/data/build-sequence.xml';           
            }

            $this->altumo_build_sequence = new \sfAltumoPlugin\Build\DatabaseBuildSequenceFile( $sf_altumo_filename );
            
        }
        
        return $this->altumo_build_sequence;
        
    }
    
    
    /**
    * Setter for the git_root_directory field on this GitHookHandler.
    * 
    * @param string $git_root_directory
    * @throws \sfCommandException           //if directory does not exist
    */
    public function setGitRootDirectory( $git_root_directory ){
        
        if( !file_exists($git_root_directory) ){
            throw new \sfCommandException( sprintf('Directory does not exist: "%s".', $git_root_directory) );
        }
        $git_root_directory = realpath( $git_root_directory );
        
        $this->git_root_directory = $git_root_directory;
        
    }
    
    
    /**
    * Getter for the git_root_directory field on this GitHookHandler.
    * 
    * @return string
    */
    public function getGitRootDirectory(){
    
        return $this->git_root_directory;
        
    }
   
    
    /**
    * Setter for the database_directory field on this GitHookHandler.
    * 
    * @param string $database_directory
    * @throws \sfCommandException           //if directory does not exist
    */
    public function setDatabaseDirectory( $database_directory ){

        if( !file_exists($database_directory) ){
            throw new \sfCommandException( sprintf('Database directory does not exist: "%s".', $database_directory) );
        }
        
        $this->database_directory = realpath($database_directory);
        
    }
    
    
    /**
    * Getter for the database_directory field on this GitHookHandler.
    * 
    * @return string
    */
    public function getDatabaseDirectory(){
    
        return $this->database_directory;
        
    }
    
        
    /**
    * Gets an array of sql files to move to the appropriate directories.
    * Files must be in the data/new folder AND be in the current commit to qualify for being moved.
    * 
    * @param string $commit_hash
    * @return array
    */
    protected function getFilesToMove( $commit_hash ){
          
        $database_dir = $this->getDatabaseDirectory();
        $sql_files_in_filesystem = \Altumo\Utils\Finder::type('file')->name('*.sql')->in( $database_dir . '/new' );
        
        $sql_files_in_commit = $this->getNewDatabaseFilesByCommit( $commit_hash );
        
        $move_sql_files = array();
        foreach( $sql_files_in_filesystem as $sql_file_in_filesystem ){
            if( in_array($sql_file_in_filesystem, $sql_files_in_commit) ){
                $move_sql_files[] = $sql_file_in_filesystem;
            }
        }
        
        return $move_sql_files;
        
    }
        
    
    /**
    * Gets an array of files that were in the supplied commit
    * 
    * @param string $commit_hash
    * 
    * @return array
    */
    protected function getNewDatabaseFilesByCommit( $commit_hash ){
        
        $git_root_directory = $this->getGitRootDirectory();
        $git_command = 'git show --name-status ' . $commit_hash;
        $git_output = `$git_command`;
           
        $files = array();
        preg_match_all( '%^(([MA])\\s+(data/new/(.*)\\.sql))?$%im', $git_output, $results, PREG_SET_ORDER );
        foreach( $results as $result ){
            if( array_key_exists(3,$result) ){
                $files[] = $git_root_directory . '/' . $result[3];
            }
        }
        
        return $files;

    }
    
    
    /**
    * Determines if this hook handler was called from within a plugin (eg. 
    * sfAltumoPlugin).
    * 
    * @return boolean
    */
    protected function calledFromPlugin(){

        return !file_exists( $this->getGitRootDirectory() . '/htdocs' );
        
    }
   

}
