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
 * Shows a list of tables being inherited via concrete inheritance.
 * 
 * @see \sfAltumoPlugin\Schema\PropelSchemaCompiler
 * 
 * @package    sfAltumoPlugin
 * @subpackage task
 * @author Juan Jaramillo <juan.jaramillo@altumo.com>
 */
class sfAltumoShowSchemaConcreteInheritanceMapTask extends sfAltumoBaseTask {

    /**
    * @see sfTask
    */
    protected function configure() {

        parent::configure();
        
        $this->addArguments(array(
            //new sfCommandArgument( 'username', sfCommandArgument::OPTIONAL, 'The database username', 'root' ),
        ));

        $this->addOptions(array(
            //new sfCommandOption( 'output_file', null, sfCommandOption::PARAMETER_OPTIONAL, 'The path of the target Javascript file', null ),
        ));


        $this->name = 'show-inheritance-map';
        //$this->aliases = array( $this->namespace. ':cs' );

        $this->briefDescription = 'Shows a list of tables being inherited via concrete inheritance. (Read Only)';

    $this->detailedDescription = <<<EOF
    
Prints out a list of tables being extended via concrete inheritance. This is based
on schema.base.xml (both sfAltumoPlugin's and the app's).

This operation is read-only and it is for information purposes only.
EOF;
    }





  /**
   * @see sfTask
   */
    protected function execute( $arguments = array(), $options = array() ) {

        $schema_compiler = new \sfAltumoPlugin\Schema\PropelSchemaCompiler( 
            sfAltumoCompileSchemaTask::getSchemaFilePaths()
        );
        
        $inheritance_map = $schema_compiler->getTableConcreteInheritanceMap();
        
        foreach( $inheritance_map as $parent_table => $children ){
            
            $this->log( '' );
            
            $this->logBlock( $parent_table, 'INFO' );
            
            foreach( $children as $child_table ){
                
                $this->log( "   " . $child_table );
                
            }
            
            $this->log( '' );
            
        }
    }
}
