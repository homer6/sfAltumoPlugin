<?php

/*
 * This file is part of the sfAltumoPlugin library.
 *
 * (c) Steve Sperandeo <steve.sperandeo@altumo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace sfAltumoPlugin\Action;



/**
* This class adds miscellaneous generic functions to sfActions. It is meant to be
* extended by a module's actions.
*
* @author Juan Jaramillo <juan.jaramillo@altumo.com>
*/
class BaseActions extends \sfActions {

    /**
    * Sends the $response array to the browser as json.
    * 
    * @param boolean $success
    *   // whether this response resulted from a successful operation
    * @param string $message 
    *   // A string to be returned with the response
    * @param array $response
    *   // the array to be JSON encoded and returned
    * @param boolean $add_content_type  
    *   // sets the content-type header to application/json
    * 
    * @throws \Exception if $response is not an array.
    * 
    * @return string
    */
    protected function sendJsonResponse( $success, $message, $response, $add_content_type = true ){
        
        if( $add_content_type ){
            $this->getResponse()->setContentType( 'application/json' );
            $this->setLayout( false );
        }
        
        if( !is_array($response) ){
            throw new \Exception( 'Response should be an array.' );
        }
        
        $response['success'] = $success;
        $response['message'] = $message;

        $this->getResponse()->setContent( json_encode($response) );
        
        return \sfView::NONE;
        
    }

}