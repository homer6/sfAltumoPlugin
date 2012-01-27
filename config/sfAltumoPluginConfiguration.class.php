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
            //require_once( dirname(__FILE__) . '/../lib/vendor/altumo/source/php/loader.php' );

        
        //set default timezone
            date_default_timezone_set( 'America/Los_Angeles' );

        //symfony 2 autoloader (for classes within namespaces)
            
            $altumo_php_source_path = __DIR__ . '/../lib/vendor/altumo/source/php';

            require_once $altumo_php_source_path . '/Utils/UniversalClassLoader.php';
            
            $loader = new Symfony\Component\ClassLoader\UniversalClassLoader();
            $loader->registerNamespaces(array(
                'sfAltumoPlugin' => __DIR__ . '/../lib',
                'Altumo' => $altumo_php_source_path
            ));
            
            $loader->register();
            
            
        // Add altumo paths to sfConfig
            sfConfig::set( 'altumo_plugin_dir', realpath( dirname(__FILE__) . '/../' ) );
            sfConfig::set( 'altumo_javascript_lib_dir', sfConfig::get( 'altumo_plugin_dir' ) . '/lib/vendor/altumo/lib/javascript' );
            sfConfig::set( 'altumo_javascript_src_dir', sfConfig::get( 'altumo_plugin_dir' ) . '/lib/vendor/altumo/source/javascript' );
            
        // Add altumo Api Settings            
            sfConfig::set( 'altumo_api_session_cookie_name', 'api_session' );
        

        /**
        * Execute any commands that the plugin needs when the framework loads, but
        * before an action is executed.
        * 
        * Note: this is here because it was used before to load JS and CSS, but
        * that was relocated to Frontend\Controller
        */

        /*
        $this->dispatcher->connect(
            'context.load_factories', 
            function(){
                
                // this code gets execute when the framework loads.
                
            }
        );
        */

    }

}
