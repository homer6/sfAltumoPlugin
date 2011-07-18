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
* Known Issues / Notes:
* 
*   -   Assumes primary keys are named "id"
*   -   Results are unexpected if getCompiledDatabaseElement is called more than once
* 
* 
* 
* @author Juan Jaramillo <juan.jaramillo@altumo.com>
*/
class PropelSchemaCompiler{
    
    protected $table_elements = array();
    protected $is_compiled = false;

    
    /**
    * Setter for the $is_compiled attribute
    * of this PropelSchemaCompiler
    * 
    * @param bool $is_compiled
    */
    protected function setCompiled( ){
        $this->is_compiled = true;
    }
        
        
    /**
    * Getter for the $is_compiled attribute
    * of this PropelSchemaCompiler
    * 
    * @return bool
    */
    protected function isCompiled( ){
        return (bool)$this->is_compiled;
    }
    
    
    
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
        
        $table_elements = $xml_document->getTableElements();
        
        $this->addTableElements( $table_elements );
        
    }

    
    /**
    * Add a <table> element (\Altumo\Xml\XmlElement) to the current set of 
    * tables.
    * 
    * The array is indexed by table name.
    * 
    * @param Array $table_elements    // of \Altumo\Xml\XmlElement
    *                                 //  table elements to add
    * @return void
    * 
    * @throws \Exception              // If argument is not an array
    *                                 // If a duplicate table name is found
    *                                 // If one of the <table> nodes doesn't
    *                                     have a "name" attribute.
    */
    protected function addTableElements( $table_elements ){

        if( empty( $table_elements ) ){
            return;
        }
        
        if( !is_array( $table_elements ) ){
            throw new \Exception( 'addTableElements expects an array' );
        }
        
        foreach( $table_elements as $table_element ){
            
            $table_name = $table_element->xpath( '@name', true );
            
            $this->table_elements[ $table_name ] = $table_element;
            
        }
        
    }
    
    
    /**
    * Get array of current <table> elements (\Altumo\Xml\XmlElement).
    * 
    * @return Array         // of \Altumo\Xml\XmlElement
    *                       //  indexes being table names
    */
    protected function &getTableElements(){
    
        return $this->table_elements;
        
    }
    
    
    /**
    * Parses the schema data and builds a map of all tables that inherit from
    * other tables via concrete inheritance.
    * 
    * The resulting array is indexed by parent table names and the values are
    * tables that are extending them.
    * 
    * @return Array
    */
    protected function getTableConcreteInheritanceMap(){
        
        $table_elements = &$this->getTableElements();
        
        // This array holds parent tables (tables being extended) as indexes
        // and the tables extending them as values.
            $table_inheritance_map = array();
            

        // Fill the table inheritance map.
            foreach( $table_elements as $table_name => $table_element ){

                if(0) $table_element = new \Altumo\Xml\XmlElement();

                // Get all (parent) tables that are being extended by other tables.
                    $concrete_inheritance_parent_tables = $table_element->queryWithXpath( 
                        'behavior[@name="concrete_inheritance"]/parameter[@name="extends"]/@value', 
                        \Altumo\Xml\XmlElement::RETURN_TYPE_STRING,
                        false
                    );

                // Save in table inheritance map
                    foreach( $concrete_inheritance_parent_tables as $parent_table ){
                        $table_inheritance_map[$parent_table][] = $table_name;
                    }
            }
        
        return $table_inheritance_map;
    }
    
    
    
    
    /**
    * Finds tables with missing concrete_inheritance foreign keys
    * (on the table being extended) and adds them.
    * 
    * @return void
    * 
    * @throws \Exception            // if a column by the same name as the foreign key
    *                               //  being created already exists.
    *                               //  (only if the column is not already a foreign key)                              
    *                               // if a referenced parent table is not
    *                               //  defined in the schema.
    */
    protected function addConcreteInheritanceForeignKeys(){

        $table_elements = &$this->getTableElements();
        
        $table_inheritance_map = $this->getTableConcreteInheritanceMap();

        
        foreach( $table_inheritance_map as $parent_table_name => $child_tables ){
            
            foreach( $child_tables as $child_table_name ){
                
                if( !isset( $table_elements[$parent_table_name] ) ){
                    throw new \Exception( "Attempted to inherit from an undefined table \"{$parent_table_name}\"" );
                }
                
                $parent_table_element = &$table_elements[$parent_table_name];
                
                if(0) $parent_table_element = new \Altumo\Xml\XmlElement();
                
                $foreign_key_name = $child_table_name . '_id';

                
                // Ensure no column with the same name as the FK exists on the parent table and is not a foreign key already.
                    $existing_column = $parent_table_element->queryWithXpath( 
                        'column[@name="' . $foreign_key_name . '"]',
                        \Altumo\Xml\XmlElement::RETURN_TYPE_XML_ELEMENT,
                        false
                    );
                    
                    $column_already_exists = false;
                    
                    if( !empty( $existing_column ) ){

                        // A column exists. Ensure it's a foreign key to the parent table.
                            $existing_fk = $parent_table_element->queryWithXpath( 
                                'foreign-key[@foreignTable="' . $child_table_name . '"]/reference[@local="' . $foreign_key_name . '"]',
                                \Altumo\Xml\XmlElement::RETURN_TYPE_XML_ELEMENT,
                                false
                            );
                            
                            $column_already_exists = true;
                        
                        // If the foreign-key does not exist, throw an exception
                            if( empty( $existing_fk ) ){
                                
                                throw new \Exception( "A column \"{$foreign_key_name}\" already exists in table \"{$parent_table_name}\". 
                                                        However this column is not a foreign key to {$child_table_name}. 
                                                        Either remove/rename this colum or make it a foreign key for Concrete Inheritance." 
                                );
                            
                        // Skip this entry if a correct foreign key already exists.
                            } else {
                                continue;
                            }
                    }
                    
                
                // Add foreign key
                
                    if( !$column_already_exists ){
                        $column_element = $parent_table_element->addChild( 'column' );
                            $column_element->addAttribute( 'name', $foreign_key_name );
                            $column_element->addAttribute( 'required', 'false' );
                            $column_element->addAttribute( 'type', 'integer' );
                    }

                    $foreign_key_element = $parent_table_element->addChild( 'foreign-key' );
                        $foreign_key_element->addAttribute( 'foreignTable', $child_table_name );
                        $foreign_key_element->addAttribute( 'onDelete', 'cascade' );
                        
                        $foreign_key_reference_element = $foreign_key_element->addChild( 'reference' );
                            $foreign_key_reference_element->addAttribute( 'local', $foreign_key_name );
                            $foreign_key_reference_element->addAttribute( 'foreign', 'id' );
                
            }
        }
    }
    
    
    
    /**
    * Executes all of the compilation procedures
    * 
    * Does not execute if this schema has already been compiled.
    * 
    * @return void
    */
    protected function compileSchema(){
        
        if( $this->isCompiled() ){
            return;
        }
        
        $this->addConcreteInheritanceForeignKeys();
        
        $this->setCompiled();
        
    }
    
    
    /**
    * Returns a <database> element containing all the tables after processing them.
    * 
    * @return \Altumo\Xml\XmlElement
    */
    public function getCompiledDatabaseElement(){
    
        $this->compileSchema();
        
        $table_elements = &$this->getTableElements();
        
        
        // TODO: Refactor \Altumo\Xml\XmlElement so that it allows for creating
        // a new element and adding children from existing \Altumo\Xml\XmlElement
        
        $xml_schema_output = '<database name="propel" defaultIdMethod="native" noXsd="true" package="lib.model">';
        
        foreach( $table_elements as $table_element ){
           
            $xml_schema_output .= "\n" . $table_element->getXmlAsString();
            
        }
        
        $xml_schema_output .= '</database>';
        
        $database_element = new \Altumo\Xml\XmlElement( $xml_schema_output );
        
        return $database_element;
        
    }
    
}