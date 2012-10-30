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
 * @author Juan Jaramillo <juan.jaramillo@altumo.com>
 */
class sfAltumoBuildJavascriptDependenciesTaskDEPRECATED extends sfAltumoBaseTask {

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


        $this->name = 'build-javascript-dependencies';
        $this->aliases = array( $this->namespace. ':jsdeps' );

        $this->briefDescription = 'Generates a Javascript dependencies file for the entire application';

    $this->detailedDescription = <<<EOF
Temporarily deprecated.
EOF;
    }





  /**
   * @see sfTask
   */
    protected function execute( $arguments = array(), $options = array() ) {

        // This closure-based system has been deprecated and it's planned
        // to be replaced with something else.
        
            /*            
            $deps_writer = sfConfig::get( 'altumo_javascript_lib_dir' ) 
              . '/vendor/google/closure-library/closure/bin/build/depswriter.py';


            $command = $deps_writer
              . ' --root_with_prefix="' . sfConfig::get( 'sf_web_dir' ) . '/sfAltumoPlugin/js/lib/vendor/altumo' . ' /../../../../../../../../../altumo/js/src"'
              . ' --root_with_prefix="' . sfConfig::get( 'sf_web_dir' ) . '/js' . ' /../../../../../../../../../js"'
              . ' --output_file="'      . sfConfig::get( 'sf_web_dir' ) . '/js/app-deps.js"';
            */

    }
}
