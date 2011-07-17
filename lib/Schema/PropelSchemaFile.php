<?php

/*
 * This file is part of the Altumo library.
 *
 * (c) Steve Sperandeo <steve.sperandeo@altumo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace sfAltumoPlugin\Schema;


/**
* An instance of this class represents a single Propel XML schema file. It is 
* used for performing certain modifications to the schema before Propel
* can use it to build the schema.
* 
* Known Issues:
* 
*   -   Does not support Propel's <external-schema>
*       http://www.propelorm.org/wiki/Documentation/1.6/Schema#external-schemaelement
* 
* @see PropelSchemaCompiler.php
* 
* @author Juan Jaramillo <juan.jaramillo@altumo.com>
*/
class PropelSchemaFile extends \Altumo\Xml\XmlFile {
 
    
    /**
    * Constructor for this sfAltumoPlugin\Schema\PropelSchemaFile.
    * 
    * @param string $filename       // path to schema file
    * 
    * @param boolean $readonly      // whether this \Altumo\Xml\XmlFile is going 
    *                                  to be used as a readonly object 
    *                                  (doesn't write to xml file)
    * 
    * @throws \Exception if file or directory is not writable
    * 
    * @return \Altumo\Xml\XmlFile
    */
    public function __construct( $filename, $readonly = true ){    
    
        parent::__construct( $filename, $readonly );
     
    }
    
    
    /**
    * Returns all <table> elemenets for this schema file.
    * The elements are returned as an array of \Altumo\Xml\XmlElement
    * 
    * @return Array     // of \Altumo\Xml\XmlElement
    */
    public function getTableElements(){
        
        $this->assertFileOpen();
        
        $xml_root = $this->getXmlRoot();
        
        $database_element = $xml_root->queryWithXpath( '/database/table', \Altumo\Xml\XmlElement::RETURN_TYPE_XML_ELEMENT );
       
        return  $database_element;
        
    }

}