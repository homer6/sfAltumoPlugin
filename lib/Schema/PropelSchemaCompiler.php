<?php
/*
 * This file is part of the sfAltumoPlugin library.
 *
 * (c) Steve Sperandeo <steve.sperandeo@altumo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace sfAltumoPlugin\Schema;



/**
* This class can take multiple Propel XML schema files, perform some processing
* (see below) on them, and output the files intended for Propel to build the
* database.
* 
* sfAltumoPlugin provides some based models that can be extended by the application
* by means of concrete table inheritance; however, propel requres for a foreign key
* to be added to the object being extended which would require modifying the plugin's
* schema.
* 
* In order to get around that, the PropelSchemaCompiler class can automatically append
* these foreign keys and output new schema files for propel to process.
* 
* @author Juan Jaramillo <juan.jaramillo@altumo.com>
*/
class PropelSchemaCompiler{
    
    protected $merged_schema_xml = null;
    

    /**
    * Initialize a new PropelSchemaCompiler
    * 
    * @params string schema_xml_path[,...]      // One or more schema.xml paths
    */
    public function __construct( ) {

        $arguments = func_get_args();
        
        if( empty( $arguments ) ){
            throw new \Exception( 'At least one Propel XML schema file path must be provided.' );
        } 
        
        // Merge all schema files into a single one
            foreach( $arguments as $xml_schema_path ){
                
                $this->loadPropelXmlSchemaFile( $xml_schema_path );
                
            }
 
    }
    
    /**
    * Adds the contents of a Propel XML schema file to the buffer of data
    * being processed.
    * 
    * @param string $xml_schema_path        // Path to a Propel XML schema file
    * 
    * @return void
    * 
    * @throws \Exception                    // If file does not exist or is invalid
    */
    protected function loadPropelXmlSchemaFile( $xml_schema_path ){
        
        $xml_document = new \sfAltumoPlugin\Schema\PropelSchemaFile( $xml_schema_path );
        
        \Altumo\Utils\Debug::dump( $xml_document->getDatabaseElementData() );
        
    }

    

}