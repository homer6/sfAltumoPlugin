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
 * Generates a Javascript dependencies file for the entire application
 * using Google's DepsWriter.
 * 
 * See http://code.google.com/closure/library/docs/depswriter.html
 * 
 * @package    altumo
 * @subpackage task
 * @author Juan Jaramillo <juan.jaramillo@altumo.com>
 */
class sfAltumoGenerateJavascriptDependenciesFileTask extends sfAltumoBaseTask {

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


        $this->name = 'generate-javascript-dependencies-file';
        $this->aliases = array( $this->namespace. ':jsdeps' );

        $this->briefDescription = 'Generates a Javascript dependencies file for the entire application';

    $this->detailedDescription = <<<EOF
During development, it is very inconvenient to compile Javascripts every time a change is made to one of them.

In order for the require() (provided by Google Closure) to work, it needs to know what path to include
scripts from and what dependencies each provides.

This task uses Closure's DepsWriter to generate a "deps file" which maps paths to dependencies.

** This task must be executed every time a new javascript file is added to the assets folder **
EOF;
    }





  /**
   * @see sfTask
   */
    protected function execute( $arguments = array(), $options = array() ) {

        // Use Google Closure's DepsWriter to generate app-deps.js

            $deps_writer = sfConfig::get( 'altumo_javascript_lib_dir' ) 
              . '/vendor/google/closure-library/closure/bin/build/depswriter.py';


            $command = $deps_writer
              . ' --root_with_prefix="'  . sfConfig::get( 'sf_web_dir' ) . '/altumo/js/src' . ' /../../../../../../../../../altumo/js/src"'
              . ' --root_with_prefix="'  . sfConfig::get( 'sf_web_dir' ) . '/js' . ' /../../../../../../../../../js"'
              . ' --output_file="'       . sfConfig::get( 'sf_web_dir' ) . '/js/app-deps.js"';


            $this->log( "\nExecuting: " . $command );

            `$command`;
            
            $this->log( "\nFinished\n" );
    }
}
