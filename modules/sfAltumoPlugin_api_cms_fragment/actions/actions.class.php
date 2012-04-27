<?php

/**
 * cms_fragment actions.
 *
 * @package    blank
 * @subpackage cms_fragment
 * @author     Juan Jaramillo <juan@centurionmedia.ca>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfAltumoPlugin_api_cms_fragmentActions extends ApiActions {


  /**
    * This method represents all four API methods (GET, POST, PUT and DELETE) 
    * for CmsFragment
    *
    * @param \sfAltumoPlugin\Api\ApiRequest $request
    */
    public function executeIndex( \sfAltumoPlugin\Api\ApiRequest $request ){

        try{
        
            $response = $this->getResponse();

                
			// assert and retrieve api user
			    $user = $this->assertAndRetrieveAuthenticatedUser($request);

			// create basic query
			    $query = CmsFragmentQuery::create();
			
			// filter by ids. if set
			    if ($this->hasRequestIds($request)) {
				    $query->filterById($this->assertAndGetRequestIds($request));
			    }

            
            /**
            * Modify the fields of a single record before it's added to the response.
            * 
            * 
            * @var \CmsFragment $cms_fragment
            *   // the CmsFragment record in question
            * 
            * @var array $result
            *   // the result array
            */
            $modify_result = function( &$cms_fragment, &$result ) {

                if(0) $cms_fragment = new CmsFragment();

                $result['id'] = $cms_fragment->getId();
                $result['tag'] = $cms_fragment->getTag();
                $result['chrome_partial'] = $cms_fragment->getChromePartial();
                $result['content'] = $cms_fragment->getContent();
                $result['content_attributes'] = $cms_fragment->getContentAttributesArray();
                $result['version'] = $cms_fragment->getVersion();

            };

            
            /**
             * 'Before-save' lambda function that:
             * 
             * @param $model Model object
             * @param array $request_object
             * @param $response
             * @param int $remote_id
             * @param bool $update
             * 
             * @return void
             * 
             * @throws Exception if host_system_code not set
			 * @throws Exception if host_system_code is invalid
			 * @throws Exception if there is a problem looking up host system
             */
            $before_save = function (&$model, &$request_object, &$response, $remote_id, $update) use (&$user) {

            	
            }; // before_save

            
            
            // define name for the array of objects to be returned
            $plural = 'cms_fragments';
            
            // define field maps for product line
            $cms_fragment_field_maps = array(
            	new \sfAltumoPlugin\Api\ApiFieldMap( 'tag', \sfAltumoPlugin\Api\ApiFieldMap::FLAG_REQUIRED ),
            	new \sfAltumoPlugin\Api\ApiFieldMap( 'chrome_partial', \sfAltumoPlugin\Api\ApiFieldMap::FLAG_REQUIRED ),
                new \sfAltumoPlugin\Api\ApiFieldMap( 'content', \sfAltumoPlugin\Api\ApiFieldMap::FLAG_REQUIRED ),
            	new \sfAltumoPlugin\Api\ApiFieldMap( 'content_attributes', \sfAltumoPlugin\Api\ApiFieldMap::FLAG_READONLY ),
            );	
            
                        
            switch( $request->getMethod() ){

                case sfWebRequest::GET: // select
                    
                    $response->setStatusCode( '200' );
                    
                    $api_get_query = new \sfAltumoPlugin\Api\ApiGetQuery( $request, $response, $query, $plural, $modify_result );

                    $api_get_query->runQuery();
                    
                    
                break;
                
                case sfWebRequest::POST: // insert

                    $response->setStatusCode( '200' );
                    
					// instantiate write operation
                    $api_write_operation = new \sfAltumoPlugin\Api\ApiWriteOperation( $request, $response, $plural );

                    // set mode to automatic
                    $api_write_operation->setMode(\sfAltumoPlugin\Api\ApiWriteOperation::MODE_AUTOMATIC);
                    
                    // set field maps
                    $api_write_operation->setFieldMaps($cms_fragment_field_maps);
                    
                    // this is an insert, set update=false
					$api_write_operation->setUpdate(false);
					
					// this is a POST=insert so don't bother applying $query					
                    
					// set function for modifying result for output
                    $api_write_operation->setModifyResult($modify_result);
					
                    // set before save function (does lookup of host system from host system code)
					$api_write_operation->setBeforeSave($before_save);

					$api_write_operation->run();
                    
                break;
                   
                    
                case sfWebRequest::PUT: // update
                    
                    $response->setStatusCode( '200' );

                    $api_write_operation = new \sfAltumoPlugin\Api\ApiWriteOperation($request, $response, $plural);
                    
                    // set automatic mode
                    $api_write_operation->setMode(\sfAltumoPlugin\Api\ApiWriteOperation::MODE_AUTOMATIC);
                    
                    // set field maps
                    $api_write_operation->setFieldMaps($cms_fragment_field_maps);
                    
                    // this is an update, set update=true
                    $api_write_operation->setUpdate(true);
                    
                    // apply all filters set in query
                    $api_write_operation->setQuery($query);
                    
                    // set function for modifying result for output
                    $api_write_operation->setModifyResult($modify_result);
                    
					// set before save function (does lookup of host system from host system code)
					$api_write_operation->setBeforeSave($before_save);

                    $api_write_operation->run();

                break;
                

                case sfWebRequest::DELETE:

                    //not supported
                    $response->setStatusCode( '405' );

                break;
                    
                
                default:

                    //not supported
                    $response->setStatusCode( '405' );

            }
            
        }catch( Exception $e ){
            
            $response->addException( $e );
            
        }
        
        return $response->respond();        
        
    } // executeIndex
    
    
}
