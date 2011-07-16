<?php
/*
 * This file is part of the sfAltumoPlugin library.
 *
 * (c) Steve Sperandeo <steve.sperandeo@altumo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace sfAltumoPlugin\Routing;



/**
* This class contains some helper functions that make it possible to export
* routes in multiple formats and applying multiple rules / filters.
* 
* @author Juan Jaramillo <juan.jaramillo@altumo.com>
*/
class RouteExporter{
    
    
    /**
    * Gets an array filled with routes retrieved from sfPropelRoute and returns
    * it as a key-value pair array.
    * 
    * Each array entry is indexed by the route unique key (from routing.yml)
    * with the value being the route path.
    * 
    * A regex pattern ($regex_pattern) can be applied to filter out specific
    * routes. (The pattern is evaluated against the route key)
    * 
    * @param string $regex_pattern         // preg_match-style regex pattern
    *                                      // e.g. 
    *                                      // ^api\_.+$ will select all
    *                                      // routes with a key starting with
    *                                      // "api_"
    * 
    * @param array $required_options       // only routes that have these 
    *                                      // "options" set in routing.yml will
    *                                      // be included.
    *                                      // array index is option name and
    *                                      // value is the value it must match.
    *                                      // e.g. 
    *                                      // array( 'export_to_javascript' => true )
    * 
    * 
    * @return array
    */
    
    public static function getRoutesAsKeyValuePairArray( $regex_pattern = null, $required_options = null ){
        
        $all_routes = \sfContext::getInstance()->getRouting()->getRoutes();

        $routes = array();

        foreach( $all_routes as $route_key => $route ){
            if( 0 ) $route = new \sfPropelRoute();

            if ( is_null( $regex_pattern ) || preg_match( $regex_pattern, $route_key ) ) {
                
                // Check to see if the required_options provided are met by this
                // route.
                    if( is_array( $required_options ) ){
                        
                        $route_options = $route->getOptions();
                        
                        foreach( $required_options as $required_option => $required_value ){
                            
                            if( !isset( $route_options[$required_option] ) || $route_options[$required_option] != $required_value ){
                                continue( 2 );
                            }
                        }
                    }
                
                $routes[$route_key] = $route->getPattern();   
            }
        }
        
        return $routes;

    }
    

    /**
    * Gets a JSON array containing routes. The array is indexed by route keys
    * and the values are routes.
    * 
    * The output is a JSON version of:
    * 
    * @see getRoutesAsKeyValuePairArray
    * 
    * 
    * @param mixed $regex_pattern           // @see getRoutesAsKeyValuePairArray
    * @param mixed $required_options        // @see getRoutesAsKeyValuePairArray
    */
    public static function getRoutesAsKeyValuePairJson( $regex_pattern = null, $required_options = null ){
        
        $routes_array = self::getRoutesAsKeyValuePairArray( $regex_pattern, $required_options );
        
        return json_encode( $routes_array );
        
    }

}