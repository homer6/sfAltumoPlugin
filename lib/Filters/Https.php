<?php

/*
 * This file is part of the Altumo library.
 *
 * (c) Steve Sperandeo <steve.sperandeo@altumo.com>
 * (c) Juan Jaramillo <juan.jaramillo@altumo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace sfAltumoPlugin\Filters;


/**
* sfHttpsFilter redirects to HTTPS if this request was to HTTP.
* 
* To enable, add the following to factories.yml (usually at the top)
* 
* secure:
*   class: \sfAltumoPlugin\Filters\Https
* 
* @author Steve Sperandeo <steve.sperandeo@altumo.com>
*/
class Https extends \sfFilter{
    
    /**
    * Executes this filter.
    *
    * @param sfFilterChain $filterChain The filter chain.
    */
    public function execute( $filterChain ){
        
        if( !\Altumo\Http\IncomingHttpRequest::isSecure() ){
            
            if( \sfConfig::get('app_require_ssl') === true ){
               header( 'Location: https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']  );
               exit();
            }

        }

        $filterChain->execute();

    }
    
}
