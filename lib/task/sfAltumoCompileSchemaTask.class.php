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
 * "Compiles" multiple Propel xml schema files to allow for extended 
 * functionallity.
 * 
 * @see \sfAltumoPlugin\Schema\PropelSchemaCompiler
 * 
 * 
 * @package    sfAltumoPlugin
 * @subpackage task
 * @author Juan Jaramillo <juan.jaramillo@altumo.com>
 */
class sfAltumoCompileSchemaTask extends sfAltumoBaseTask {

    /**
    * @see sfTask
    */
    protected function configure() {

        parent::configure();
        
        $this->addArguments(array(
            //new sfCommandArgument( 'username', sfCommandArgument::OPTIONAL, 'The database username', 'root' ),
        ));

        $this->addOptions(array(
            new sfCommandOption( 'output_file', null, sfCommandOption::PARAMETER_OPTIONAL, 'The path of the target Javascript file', null ),
        ));


        $this->name = 'compile-schema';
        $this->aliases = array( $this->namespace. ':cs' );

        $this->briefDescription = 'Precompiles schema.xml to allow for cross-schema concrete table inheritance.';

    $this->detailedDescription = <<<EOF
    
 ** Please ensure the app's schema is in schema.base.xml and not schema.xml **
 
 sfAltumoPlugin provides some based models that can be extended by the application
 by means of concrete table inheritance; however, propel requres for a foreign key
 to be added to the object being extended which would require modifying the plugin's
 schema.
 
 In order to get around that, the PropelSchemaCompiler class can automatically append
 these foreign keys and output new schema files for propel to process.
 
 Known Issues / Notes:
 
   -   Assumes primary keys are named "id"
   -   Results are unexpected if getCompiledDatabaseElement is called more than once
EOF;
    }





  /**
   * @see sfTask
   */
    protected function execute( $arguments = array(), $options = array() ) {

        $schema_compiler = new \sfAltumoPlugin\Schema\PropelSchemaCompiler( 
            // app's schema
                __DIR__ . '/../../../../config/schema.base.xml',   
                
            // sfAltumoPlugin's schema
                __DIR__ . '/../../config/schema.base.xml'
        );
        
        $compiled_schema = $schema_compiler->getCompiledDatabaseElement();
        
        \Altumo\Utils\Debug::dump( $compiled_schema->getXmlAsString(true) );
    }
}
