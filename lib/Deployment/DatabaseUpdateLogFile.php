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
* An instance of this class represents the xml log file that is used to perform 
* database updates. This log records all of the update operations that have been 
* applied to this environment.
* 
* @author Steve Sperandeo <steve.sperandeo@altumo.com>
*/
class DatabaseUpdateLogFile extends \Altumo\Xml\XmlFile{
 
    
    /**
    * Constructor for this \Altumo\Xml\XmlFile.
    * 
    * @param string $filename               //full path of the filename
    * @param boolean $readonly              //whether this \Altumo\Xml\XmlFile 
    *                                         is going to be used as a readonly
    *                                         object (doesn't write to xml file)
    * @throws \Exception                   //if file or directory is not 
    *                                         writable
    * @return \Altumo\Xml\XmlFile
    */
    public function __construct( $filename, $readonly = true ){    
    
        parent::__construct( $filename, $readonly );
     
    }
    
    
    /**
    * Gets the default empty file as an xml string.
    * 
    * @return string
    */
    protected function getDefaultEmptyFile(){
        
        return '<UpdateLog/>';
        
    }
    
    
    /**
    * Adds a record of an upgrade.  This happens when an upgrade gets applied to a database.
    * 
    * 
    * @param string $hash
    * @param boolean $altumo_hash           //whether this is an sfAltumoPlugin
    *                                         delta
    * @throws \Exception                    //if this log file isn't open
    */    
    public function addUpgrade( $hash, $altumo_hash = null ){
        
        $this->addLogEntryByType( $hash, 'Upgrade', $altumo_hash );
        
    }    
        
    
    /**
    * Adds a record of a data update.  This happens when a data update gets applied to an application
    * 
    * 
    * @param string $hash
    * 
    * @throws \Exception                    //if this log file isn't open
    */    
    public function addDataUpdate( $hash ){
        
        $this->addLogEntryByType( $hash, 'DataUpdate', null );
        
    }    
    
    
    /**
    * Adds a record of a drop.  This happens when a drop gets applied to a 
    * database.
    *
    * @param string $hash
    * @param boolean $altumo_hash           //whether this is an sfAltumoPlugin
    *                                         delta
    * @throws \Exception                    //if this log file isn't open
    */    
    public function addDrop( $hash, $altumo_hash = null ){
        
        $this->addLogEntryByType( $hash, 'Drop', $altumo_hash );
                
    }
    
    
    /**
    * Adds a record of a snapshot.  This happens when a snapshot gets applied 
    * to a database.
    * 
    * 
    * @param string $hash
    * @param boolean $altumo_hash           //whether this is an sfAltumoPlugin
    *                                         delta
    * @throws \Exception                    //if this log file isn't open
    */    
    public function addSnapshot( $hash, $altumo_hash = null ){
        
        $this->addLogEntryByType( $hash, 'Snapshot', $altumo_hash );        
        
    }
    
    
    /**
    * Adds a log type to this Update Log.
    * 
    * @param string $hash
    * @param string $log_type
    * @param boolean $altumo_hash           //whether this is an sfAltumoPlugin
    *                                         delta
    * @throws \Exception                    //if this log file isn't open
    */
    protected function addLogEntryByType( $hash, $log_type, $altumo_hash = null ){
        
        $this->assertFileOpen();
        $this->assertFileWritable();
        
        $xml_root = $this->getXmlRoot();
            $change = $xml_root->addChild( $log_type );
            
                $change->addAttribute( 'hash', $hash );
                $change->addAttribute( 'datetime', date('c') );
                if( !is_null($altumo_hash) ){
                    if( $altumo_hash ){
                        $change->addAttribute( 'altumo', 'true' );
                    }else{
                        $change->addAttribute( 'altumo', 'false' );
                    }
                }
        
    }
        
    
    /**
    * Gets the last log entry
    * Returns null if no entry found.
    * 
    * @return \Altumo\Xml\XmlElement
    */
    public function getLastLogEntry(){
        
        $this->assertFileOpen();
        $last_entry_query_result = $this->getXmlRoot()->queryWithXpath( 'child::*[last()]', \Altumo\Xml\XmlElement::RETURN_TYPE_XML_ELEMENT, false );
        if( empty($last_entry_query_result) ){
            return null;
        }else{
            return reset($last_entry_query_result);
        }
        
    }
    
    
    /**
    * Gets the hash of the last log entry
    * Returns null if no entry found.
    * 
    * @return string
    */
    public function getLastLogEntryHash(){
        
        $this->assertFileOpen();
        return $this->getXmlRoot()->xpath( 'child::*[last()]/attribute::hash', false );
        
    }

}
