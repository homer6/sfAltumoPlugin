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
* This class is an object that loads an empty (bare) database based on the
* sql files that Propel generates.
* 
* The purpose of a bare database is to provide a reference to make it easier
* to generate upgrade scripts when schema changes are involved. For example,
* when a new field is added to a table in schema.xml (or schema.yml), building 
* the bare database will give you a database that includes that field change.
* You can then use it to automatically build an upgrade script using a diff tool
* like Toad for MySQL, or to verify that your manually-written upgrade script
* really made your current database's schema look like what Propel would have
* generated.
* 
* @see BareDatabaseLoader::loadBareDatabase
* 
* @see sfAltumoLoadBareDatabaseTask
* 
* @author Juan Jaramillo <juan.jaramillo@altumo.com>
*/
class BareDatabaseLoader{
    
    protected $database_updater_configuration_file = null;
    protected $sql_data_dir = null;
    
    /**
    * Creates a new BareDatabaseLoader object
    * 
    * @param \sfAltumoPlugin\Deployment\DatabaseUpdaterConfigurationFile $database_builder_configuration_file
    * 
    * @return \sfAltumoPlugin\Deployment\DatabaseUpdater
    */
    public function __construct( 
        \sfAltumoPlugin\Deployment\DatabaseUpdaterConfigurationFile $database_updater_configuration_file
    ){
        
        $this->setDatabaseUpdaterConfigurationFile( $database_updater_configuration_file );
        
        $this->initialize();
        
    }
    

    /**
    * Sets up the database connection and other startup functionality.
    * This is called from the constructor.
    * 
    * @return void
    */
    protected function initialize(){
        
        $this->setSqlDataDir( \sfConfig::get( 'sf_data_dir' ) . '/sql' );
        
    }    
    
    
    /**
    * Setter for the database_updater_configuration_file field on this 
    * BareDatabaseLoader.
    * 
    * @param \sfAltumoPlugin\Deployment\DatabaseUpdaterConfigurationFile  $database_updater_configuration_file
    */
    protected function setDatabaseUpdaterConfigurationFile( $database_updater_configuration_file ){
    
        $this->database_updater_configuration_file = $database_updater_configuration_file;
        
    }
    
    
    /**
    * Getter for the database_updater_configuration_file field on this
    * BareDatabaseLoader.
    * 
    * @return \sfAltumoPlugin\Deployment\DatabaseUpdaterConfigurationFile 
    */
    protected function &getDatabaseUpdaterConfigurationFile(){
    
        return $this->database_updater_configuration_file;
        
    }
    

    /**
    * Setter for the sql_data_dir field on this BareDatabaseLoader.
    * 
    * @param string $sql_data_dir
    */
    protected function setSqlDataDir( $sql_data_dir ){
    
        $this->sql_data_dir = $sql_data_dir;
        
    }
    
    
    /**
    * Getter for the sql_data_dir field on this BareDatabaseLoader.
    * 
    * @return string
    */
    protected function getSqlDataDir(){
    
        return $this->sql_data_dir;

    }
    
    
    /**
    * Loads Propel's sql files onto a "bare" database. The default name for the
    * bare database is the project's database plus "_bare"
    * 
    * If the target database already exists, it will be replaced.
    * 
    * @param mixed $bare_database_name
    *   // specify a different name for the target bare database.
    * 
    * @throws Exception
    *   // if the $bare_database_name matches the project's database name
    * 
    * @return array
    *   // a list of all the commands executed
    */
    public function loadBareDatabase( $bare_database_name = null ){
        
        if( is_null( $bare_database_name ) ){
            $bare_database_name = $this->getDatabaseUpdaterConfigurationFile()->getDatabaseName() . "_bare";
        }
        
        if( $bare_database_name == $this->getDatabaseUpdaterConfigurationFile()->getDatabaseName() ){
            throw new \Exception( "The bare database name given cannot match the project's database name \"{$bare_database_name}\"" );
        }
        
        
        $sql_files = $this->getPropelGeneratedSqlFilePaths();
        
        $base_command = "mysql -u" . $this->getDatabaseUpdaterConfigurationFile()->getDatabaseUsername() .
                            " -p" . $this->getDatabaseUpdaterConfigurationFile()->getDatabasePassword() .
                            " -h" . $this->getDatabaseUpdaterConfigurationFile()->getDatabaseHostname() .
                            " ";
                            
        $commands = array(
            $base_command . "--execute=\"DROP DATABASE IF EXISTS \`{$bare_database_name}\`;\"",
            $base_command . "--execute=\"CREATE DATABASE \`{$bare_database_name}\` DEFAULT CHARACTER SET utf8 COLLATE \`utf8_unicode_ci\`;\"",
        );
        
        
        foreach( $sql_files as $sql_file_path ){
            $commands[] = "$base_command {$bare_database_name} < {$sql_file_path}";
        }
        
        
        foreach( $commands as $command ){
            `{$command}`;
        }
        
        return $commands;
        
    }
    
    
    
    /**
    * Returns an array of the SQL files that Propel generates based on
    * the schema.
    * 
    * @return array
    *   // of string (full paths to propel SQL files)
    * 
    */
    public function getPropelGeneratedSqlFilePaths(){
        
        $sql_data_path = $this->getSqlDataDir();
        
        $sql_data_path_contents = scandir( $sql_data_path );

        $sql_files = array();
        
        foreach( $sql_data_path_contents as $filename ){
            if (preg_match('/^.+?\\.sql$/m', $filename)) {
                $sql_files[] = $sql_data_path . '/' . $filename;
            }
        }
        
        return $sql_files;
        
    }
  
}
