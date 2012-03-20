<?php

/**
* documentation actions.
*
* @package    reseller_platform
* @subpackage documentation
* @author     Your name here
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class sfAltumoPlugin_api_documentationActions extends sfActions {
    
    
    /**
    * Simple (and temporary) authentication.
    * 
    */
    public function preExecute(){
        
        $expected_username = sfConfig::get( 'app_api_documentation_username', 'api' );
        $expected_password = sfConfig::get( 'app_api_documentation_password', 'api' );
        
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Unable to authenticate';
            exit;
            
        } else {
            
            if( $_SERVER['PHP_AUTH_USER'] != $expected_username || $_SERVER['PHP_AUTH_PW'] != $expected_password ){
                echo 'Unable to authenticate';
                exit;
            }
            
        }
        
    }
    
    
    /**
    * Executes index action
    *
    * @param sfRequest $request A request object
    */
    public function executeIndex(sfWebRequest $request){
        $this->forward('default', 'module');
    }


    /**
    * Shows the API Documentation page based on a json documentation file corresponding to api_version.
    * 
    * @param sfWebRequest $request
    * @return mixed
    */
    public function executeViewDocumentation( sfWebRequest $request ){   

        $api_version = $request->getParameter( 'api_version', '1.0' );

        sfContext::getInstance()->getConfiguration()->loadHelpers( array( 'Url' ) );

        // Pass the location of the JSON documentation to the template        
            $this->documentation_json_route = url_for( '@api_documentation_data_version?api_version=' . $api_version );

        return 'Success';
    }


    /**
    * Returns the documentation JSON data with the javascript contenttype.
    * 
    * @param sfWebRequest $request
    */
    public function executeGetDocumentationData( sfWebRequest $request ){
        
        $api_version = $request->getParameter( 'api_version', '1.0' );
        
        $this->setLayout( false );
        $this->getResponse()->setContentType('application/javascript');
        
        $this->getResponse()->setHttpHeader( 'Expires', 'Mon, 20 Dec 1998 01:00:00 GMT' );
        $this->getResponse()->setHttpHeader( 'Last-Modified', gmdate("D, d M Y H:i:s") . " GMT" );
        $this->getResponse()->setHttpHeader( 'Cache-Control', 'no-cache, must-revalidate' );
        $this->getResponse()->setHttpHeader( 'Pragma', 'no-cache' );
        
        $this->renderText( $this->getApiDocumentationJsonData($api_version) );

        return sfView::NONE;
    }
    
    
    /**
    * Reads the api documentation JSON file for the given api version and returns it (as a string).
    * 
    * @param mixed $api_version
    * @return string
    */
    protected function getApiDocumentationJsonData( $api_version ){

        //determine the documenation path
            $json_data_path = sfConfig::get( 'sf_app_dir' ) . "/data/api_docs/{$api_version}";
        
        //read the layout contents
            $layout_file_path = $json_data_path . "/layout.json";
            if( !is_readable( $layout_file_path ) ){
                throw new Exception( "Cannot read <{$layout_file_path}>" );
            }        
            $template_contents = file_get_contents( $layout_file_path );
        
        //read all of the method files and concatenate them (with a , separating them)
            $method_files = sfFinder::type('file')->name('*.json')->in( $json_data_path . '/methods' );
            $methods = array();
            foreach( $method_files as $method_file ){            
                $methods[] = file_get_contents( $method_file );            
            }
            $all_methods = implode(', ', $methods);
            
        //read all of the event files and concatenate them (with a , separating them)
            $event_files = sfFinder::type('file')->name('*.json')->in( $json_data_path . '/events' );
            $events = array();
            foreach( $event_files as $event_file ){            
                $events[] = file_get_contents( $event_file );            
            }
            $all_events = implode(', ', $events);
            
        
        //compile all of the parts and return the full json document as a string           
            $suffix = <<<SUFFIX

    "objects" : {
        $all_methods
    },
    
    "events": {
        $all_events
    }
}

SUFFIX;

            return $template_contents . $suffix;

    }
}
