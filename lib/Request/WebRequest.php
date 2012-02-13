<?php
/*
 * This file is part of the sfAltumoPlugin library.
 *
 * (c) Steve Sperandeo <steve.sperandeo@altumo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace sfAltumoPlugin\Request;



/**
* This class extends sfWebRequest to fix minor quirks. Currently it fixes
* the default routing behaviour so that it doesn't care about trailing slashes 
* on urls.
* 
* @author Juan Jaramillo <juan.jaramillo@altumo.com>
*/
class WebRequest extends \sfWebRequest {


    /**
    * Override inorder to ignore trailing slashes in requests.
    *   @see \sfWebRequest::getPathInfo()
    */
    public function getPathInfo() {
        
        $pathInfo = parent::getPathInfo();

        // remove trailing slash.
            $pathInfo = preg_replace( '/\/$/', '', $pathInfo );

        return $pathInfo;
        
    }


}