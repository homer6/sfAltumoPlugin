<?php
/*
 * This file is part of the sfAltumoPlugin package
 *
 * (c) Steve Sperandeo <steve.sperandeo@altumo.com>
 * (c) Juan Jaramillo <steve.sperandeo@altumo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
class RoutingDumper {
    
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
     * @param string $regex_pattern     // preg_match-style regex pattern
     * @return array                    // of routes (numeric indexes)
     */
    public static function getRoutesAsKeyValuePairArray( $regex_pattern = null, $required_options = null ){

        $all_routes = sfContext::getInstance()->getRouting()->getRoutes();

        foreach( $all_routes as $route_key => $route ){
            if( 0 ) $route = new sfPropelRoute();

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
                
                $routes[] = $route->getPattern();   
            }
        }
        
        return $routes;

    }
     
}