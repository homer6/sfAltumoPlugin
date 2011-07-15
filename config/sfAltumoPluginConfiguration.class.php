<?php
/*
 * This file is part of the sfAltumoPlugin package
 *
 * (c) Steve Sperandeo <steve.sperandeo@altumo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfAltumoPlugin configuration.
 * 
 * @package    sfAltumoPlugin
 * @subpackage config
 * @author Juan Jaramillo <steve.sperandeo@altumo.com>
 */
class sfAltumoPluginConfiguration extends sfPluginConfiguration {
    
    /**
    * @see sfPluginConfiguration
    */
    public function initialize() {

        // Include the Altumo loader.
            require_once( dirname(__FILE__) . '/../lib/vendor/altumo/source/php/loader.php' );
        
        // Add altumo paths to sfConfig
            sfConfig::set( 'altumo_plugin_dir', realpath( dirname(__FILE__) . '/../' ) );
            sfConfig::set( 'altumo_javascript_lib_dir', sfConfig::get( 'altumo_plugin_dir' ) . '/lib/vendor/altumo/lib/javascript' );
            sfConfig::set( 'altumo_javascript_src_dir', sfConfig::get( 'altumo_plugin_dir' ) . '/lib/vendor/altumo/source/javascript' );
            
        // Add altumo Api Settings            
            sfConfig::set( 'altumo_api_session_cookie_name', 'api_session' );
        
        /**
        * Upon execution, add the Altumo global web assets to the response
        * on every request.
        * 
        * include_javascripts() and include_stylesheets() can then be called
        * from the layout to generate the html include code.
        */
        $this->dispatcher->connect(
            'context.load_factories', 
            function(){
                
                $context = sfContext::getInstance();
                $response = $context->getResponse();
                $request = $context->getRequest();
                
                $protocol = $request->isSecure() ? 'https' : 'http';
                
                
                
                $javascripts = array();
                
                // Include jQuery
                    $javascripts[] = 'https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js';   
        
                // Include Crockford's JSON library
                    $javascripts[] = '/altumo/js/lib/vendor/douglascrockford/json2.js';
                
                // Include Closure
                    $javascripts[] = '/altumo/js/lib/vendor/google/closure-library/closure/goog/base.js';
                
                // If this is a development environment, add the deps file generated
                // by closure to tell the library where to include javascripts from.
                    if( !in_array( $context->getConfiguration()->getEnvironment(), array( 'prod', 'production', 'testing', 'staging' ) ) ){
                        $javascripts[] = '/js/app-deps.js';
                    }
                    
                // Include Altumo core
                    $javascripts[] = '/altumo/js/src/core/base.js';
                
                
                // Add javascripts to the response
                    foreach( $javascripts as $javascript ){
                        $response->addJavascript( $javascript );
                    }
            }
        );
        
    }

}