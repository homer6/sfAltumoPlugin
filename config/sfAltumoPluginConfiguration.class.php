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
 * @author Juan Jaramillo <juan.jaramillo@altumo.com>
 */
class sfAltumoPluginConfiguration extends sfPluginConfiguration {
    
    /**
    * @see sfPluginConfiguration
    */
    public function initialize() {
       
        //set default timezone
            date_default_timezone_set( 'America/Los_Angeles' );

        //symfony 2 autoloader (for classes with namespaces only)
            
            $altumo_php_source_path = __DIR__ . '/../lib/vendor/altumo/source/php';

            require_once $altumo_php_source_path . '/Utils/UniversalClassLoader.php';
            
            $loader = new Symfony\Component\ClassLoader\UniversalClassLoader();
            $loader->registerNamespaces(array(
                'sfAltumoPlugin' => __DIR__ . '/../lib',
                'Altumo' => $altumo_php_source_path
            ));
            
            $loader->register();
            
            
        // Add altumo paths to sfConfig
            \sfConfig::set( 'altumo_plugin_dir', realpath( dirname(__FILE__) . '/../' ) );
            \sfConfig::set( 'altumo_javascript_lib_dir', sfConfig::get( 'altumo_plugin_dir' ) . '/lib/vendor/altumo/lib/javascript' );
            \sfConfig::set( 'altumo_javascript_src_dir', sfConfig::get( 'altumo_plugin_dir' ) . '/lib/vendor/altumo/source/javascript' );
    
       
        /**
        * If the AWS module is enabled, set credentials for sdk
        * 
        * To enable, add a section to settings.yml, like so:
        *   sfAltumoPlugin:
        *      aws:
        *        enable: true
        *        key: "MY_AWS_KE_HERE"
        *        secret: "MY_AWS_SECRET_HERE" 
        */
            $aws_configuration = sfConfig::get( 'sf_sfAltumoPlugin_aws', array('enable'=>false) );
        
            if( $aws_configuration['enable'] ){
                
                \CFCredentials::set(array(

                    'default' => array(

                        // Amazon Web Services Key. Found in the AWS Security Credentials. You can also pass
                        // this value as the first parameter to a service constructor.
                        'key' => $aws_configuration['key'],

                        // Amazon Web Services Secret Key. Found in the AWS Security Credentials. You can also
                        // pass this value as the second parameter to a service constructor.
                        'secret' => $aws_configuration['secret'],

                        // This option allows you to configure a preferred storage type to use for caching by
                        // default. This can be changed later using the set_cache_config() method.
                        //
                        // Valid values are: `apc`, `xcache`, or a file system path such as `./cache` or
                        // `/tmp/cache/`.
                        'default_cache_config' => '',

                        // Determines which Cerificate Authority file to use.
                        //
                        // A value of boolean `false` will use the Certificate Authority file available on the
                        // system. A value of boolean `true` will use the Certificate Authority provided by the
                        // SDK. Passing a file system path to a Certificate Authority file (chmodded to `0755`)
                        // will use that.
                        //
                        // Leave this set to `false` if you're not sure.
                        'certificate_authority' => false
                    ),

                    // Specify a default credential set to use if there are more than one.
                    '@default' => 'default'
                ));

            }
            
        /**
        * Execute any commands that the plugin needs when the framework loads, but
        * before an action is executed.
        * 
        * Note: this is here because it was used before to load JS and CSS, but
        * that was relocated to Frontend\App
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
