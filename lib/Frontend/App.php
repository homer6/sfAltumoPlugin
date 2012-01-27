<?php
/*
 * This file is part of the sfAltumoPlugin library.
 *
 * (c) Steve Sperandeo <steve.sperandeo@altumo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace sfAltumoPlugin\Frontend;



/**
* This class automates part of the process of loading and declaring javascript
* resources for the front end application.
* 
* Example code (typically would be in your layout)
*       
*       $frontend = \sfAltumoPlugin\Frontend\App::create(
*            'myApp'
*        );
*        
*        echo $frontend->initialize();
* 
*        // This will:
*           - Load all required javascriot libs ( jquery, underscore, backbone, closure-base )
*           - Declare all base namespaces ( myApp, myApp.model, myApp.view )
*           - Load the application javascript(s)
*               - In production, testing and staging: app.js ( compiled application, from altumo:build )
*               - Otherwise, app-deps.js will be loaded ( generated bu altumo:build )
* 
* 
* 
*   NOTES: The js libraries loaded by this App are meant to be required by
*          the frontend application's MVC layer. No application
*          specific libraries should be added to this class nor any library that
*          is not needed by the backbone-based workflow. 
*
*   TODOS:
*       - Add ability for caller to specify which libraries and/or versions are loaded
*       - Add ability for caller to add more namespaces to be declared (?)
* 
* @author Juan Jaramillo <juan.jaramillo@altumo.com>
*/
class App{

    protected $namespace = null;
    protected $namespace_heap = array();
    protected $config = null;


    /**
    * Get a new instance of App
    * 
    * @param string $namespace
    *   // Frontend application namespace. Can contain sub-namespaces
    *   // e.g. myApp or myApp.adminPanel
    * 
    * @param array $config
    *   // A set of key-value pairs that will be made available to the application
    *   // globally via the .config namespace.
    * 
    * @return \sfAltumoPlugin\Frontend\App
    */
    public static function create( $namespace, $config = null ){
        
        if( !is_null( $config ) && !is_array($config) ){
            throw new \Exception( '$config is expected to be an array.' );
        }
        
        $app = new \sfAltumoPlugin\Frontend\App(
            $namespace
        );
        
        // add config items
            foreach( $config as $key => $value ){
                $app->addConfigItem( $key, $value );
            }
        
        return $app;
        
    }


    /**
    * Constructor for this App.
    * 
    * @param string $namespace
    *   // Frontend application namespace. Can contain sub-namespaces
    *   // e.g. myApp or myApp.adminPanel
    * 
    * @return \sfAltumoPlugin\Frontend\App
    *   // $this
    */
    public function __construct( $namespace ){    
    
        $this->setNamespace( $namespace );
     
    }
    
    
    /**
    * Adds a config item (key-value pair). Config items get passed to the 
    * frontend app via the .config namespace.
    * 
    * @param string $key
    * @param mixed $value
    * 
    * @return \sfAltumoPlugin\Frontend\App
    *   // $this
    */
    public function addConfigItem( $key, $value ){
        
        $key = \Altumo\Validation\Strings::assertNonEmptyString( $key );
        
        $this->getConfig()->$key = $value;
        
        return $this;

    }
    

    /**
    * Returns the config array. Config items get passed to the 
    * frontend app via the .config namespace.
    * 
    * @return array
    */
    protected function getConfig(){
        
        if( is_null($this->config) ){
            $this->config = new \stdClass();
        }
        
        return $this->config;
        
    }


    /**
    * Adds an entry to the namespace heap. A namespace heap entry can be
    * a single valid javascript namespace or a subnamespace.
    * 
    * If $namespace already exists in the heap, it'll not be added again.
    * 
    * @param string $namespace
    *   // e.g. myApp or myApp.admin
    * 
    * @return App
    *   // this App.
    */
    protected function addToNamespaceHeap( $namespace ){
        
        $this->namespace_heap[ $namespace ] = null;
        
        return $this;
        
    }    
    
    
    /**
    * Retrieve the current namespace heap array.
    * 
    * @return array
    *   // An array of unique strings representing namespaces in the heap
    */
    protected function getNamespaceHeap(){
    
        return array_keys( $this->namespace_heap );
        
    }
        
    
    /**
    * Clears the contents of the namespace heap.
    * 
    * @return App
    *   // this App.
    */
    protected function resetNamespaceHeap(){
    
        $this->namespace_heap = array();
        
        return $this;
        
    }
    
    
    /**
    * Sets the application's base namespace as well as any subnamespace that will
    * be used by the frontend.
    * 
    * Example for "myApp"
    * 
    *  - myApp
    *  - myApp.model
    *  - myApp.view
    * 
    * @param string $namespace
    *   // e.g. myApp
    * 
    * @throws \Exception
    *   // if $namespace is not a non-empty string.
    * 
    * @return App
    *   // this App.
    */
    protected function setNamespace( $namespace ){

        $this->resetNamespaceHeap();
        
        $this->namespace = \Altumo\Validation\Strings::assertNonEmptyString(
            $namespace,
            '$namespace must be a non-empty string' 
        );
        
        $sub_namespaces = array(
            'model',
            'view',
            'context'
        );
        
        $this->addToNamespaceHeap( $this->namespace );
        
        foreach( $sub_namespaces as $sub_namespace ){
            
            $this->addToNamespaceHeap( $this->namespace . '.' . $sub_namespace );
            
        }
        
        return $this;
        
    }
    
    
    /**
    * Getter for the namespace field on this App.
    * 
    * @return string
    */
    public function getNamespace(){
    
        return $this->namespace;
        
    }
    
    
    /**
    * Adds the JS libraries that are required by the Frontend App to the
    * response via sfContext.
    * 
    * @return App
    *   // this App.
    */
    protected function loadLibraries(){
        
        $javascripts = array();
        
        // jQuery
            $javascripts['jquery']          = '//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js';   

        // Crockford's JSON library (used by backbone)
            $javascripts['json2']           = '/altumo/js/lib/vendor/douglascrockford/json2.js';
        
        // Google Closure Base (for dependency management)
            $javascripts['closure-base']    = '/altumo/js/lib/vendor/google/closure-library/closure/goog/base.js';
                            
        // Underscore
            $javascripts['underscore']      = '/sfAltumoPlugin/js/lib/vendor/underscore/underscore-1.3.0-min.js';
                                                
        // Backbone
            $javascripts['backbone']        = '/sfAltumoPlugin/js/lib/vendor/backbone/backbone-0.5.3-min.js';
                    
        foreach( $javascripts as $javascript ){
            
            \sfContext::getInstance()->getResponse()->addJavaScript( $javascript, 'first' );
            
        }


        return $this;

    }    
    
    
    /**
    * Adds the JS libraries that are required by the Frontend App to the
    * response via sfContext.
    * 
    * @return App
    *   // this App.
    */
    protected function loadFrontendApp(){
        
        // If this is a development environment, add the deps file generated
        // by closure to tell the library where to include javascripts from.
            if( !in_array( 
                    \sfContext::getInstance()->getConfiguration()->getEnvironment(), 
                    array('prod', 'production', 'testing', 'staging') 
            )){
                
                $frontend_app = '/js/app-deps.js';

            } else {
                
                $frontend_app = '/js/app.js';
                
            }
        
        \sfContext::getInstance()->getResponse()->addJavaScript( $frontend_app, 'last' );
        
        return $this;

    }
    
    
    /**
    * Returns the JS required in order to declare the namespace(s) to be used
    * by the application.
    * 
    * @return string
    *   // javascript code.
    */
    protected function declareNamespaces(){
        
        $unique_namespaces = array();
        $output = '';
        
        foreach( $this->getNamespaceHeap() as $namespace ){
            
            $application_namespace = explode( '.', $namespace );
            
            for( $index = 0; $index < count( $application_namespace ); $index++ ){
                
               $namespace_name = implode( '.', array_slice($application_namespace, 0, $index + 1) );
               
               $unique_namespaces[$namespace_name] = null;

            }
            
        }
        
        $unique_namespaces = array_keys( $unique_namespaces );

        foreach( $unique_namespaces as $unique_namespace ){

            if( !preg_match('/\\./', $unique_namespace) ){

                $output .= 'var ';
            
            }
            
            $output .=  $unique_namespace . ' = ' . $unique_namespace . ' || {};' . "\n";

        }

        return $output;

    }

    
    /**
    * Returns the JS required in order to declare the config values being passed
    * to the frontend.
    * 
    * @return string
    *   // javascript code.
    */
    protected function declareConfig(){

        $output = $this->getNamespace() . '.config = ' .
            json_encode( $this->getConfig() );
        
        return $output;

    }
    

    /**
    * Initializes the JS Frontend to the application. 
    * 
    *   - loads JS libraries
    *   - declares namespaces
    *   - loads the frontend application
    * 
    * @return string
    *   // javascript code
    */
    public function initialize(){
        
        $this
            ->loadLibraries()
            ->loadFrontendApp();

        return
            $this->declareNamespaces() . "\n" .
            $this->declareConfig();
        
    }

}