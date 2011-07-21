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
* 
* @author Steve Sperandeo <steve.sperandeo@altumo.com>
*/
class GitHookHandler{
    
    
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
    static public function handle( $hook_name ){
        
        try{
            \Altumo\Validation\Strings::assertNonEmptyString($hook_name);    
        }catch( \Exception $e ){
            throw new \sfCommandException( 'Hook name was not a non-empty string.' );
        }
        
        switch( $hook_name ){
            
            case 'post-commit':
                self::onPostCommit();
                break;
            
            default:
                throw new \sfCommandException( sprintf('Hook "%s" does not have a handler.', $hook_name) );
            
        }
        
    }
    
    
    /**
    * Handler that is invoked by the "post-commit" git hook.
    * 
    * This method creates a new "database build":
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
    static public function onPostCommit(){
        
        $project_root = realpath( \sfConfig::get( 'sf_root_dir' ) . '/../../' );
        $database_dir = \sfConfig::get( 'sf_data_dir' );

        //get the last commit hash        
            $last_commit_hash = \Altumo\Git\History::getLastCommitHash();
            
        //check to see if there are any new scripts in the "new" folder  
            $sql_files = self::getFilesToMove( $last_commit_hash, $project_root, $database_dir );
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
            $database_file = $database_dir . '/build-sequence.xml';
            $xml_build_sequence = new \sfAltumoPlugin\Build\DatabaseBuildSequenceFile( $database_file, false );
            $xml_build_sequence->addChange( $last_commit_hash, $has_upgrade, $has_drop, $has_snapshot );
            $xml_build_sequence->closeFile();
            $shell_command = "git add $database_file";
            `$shell_command`;
                    
        //commit the files
            $shell_command = 'git commit -m "Autocommit: moving sql files to appropriate locations for commit ' . $last_commit_hash . '"';
            `$shell_command`;
        
    }
    
        
    /**
    * Gets an array of sql files to move to the appropriate directories.
    * Files must be in the database/new folder AND be in the current commit to qualify for being moved.
    * 
    * @param string $commit_hash
    * @param string $project_root  //full pathname of the project root (without the trailing slash)
    * @param string $database_dir  //full pathname of the database directory (without the trailing slash)
    * @return array
    */
    static protected function getFilesToMove( $commit_hash, $project_root, $database_dir ){
          
        $sql_files_in_filesystem = \Altumo\Utils\Finder::type('file')->name('*.sql')->in( $database_dir . '/new' );
        
        $sql_files_in_commit = self::getNewDatabaseFilesByCommit( $commit_hash, $project_root );
        
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
    * @param string $project_root  //full pathname of the project root (without the trailing slash)
    * 
    * @return array
    */
    static protected function getNewDatabaseFilesByCommit( $commit_hash, $project_root ){
        
        $git_command = 'git show --name-status ' . $commit_hash;
        $git_output = `$git_command`;
           
        $files = array();
        preg_match_all( '%^(([DMA])\\s+(htdocs/project/data/new/(.*)\\.sql))?$%im', $git_output, $results, PREG_SET_ORDER );
        foreach( $results as $result ){
            if( array_key_exists(3,$result) ){
                $files[] = $project_root . '/' . $result[3];
            }
        }
        
        return $files;

    }
   

}