<?php

/**
 * Skeleton subclass for representing a row from the 'user' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.lib.model
 */

namespace sfAltumoPlugin\Model;

class User extends \BaseUser {
    
    /**
    * Gets the user's full name
    * 
    * @param string $format
    *   // sprintf style format with two strings. (first name, last name)
    * 
    * @return string
    *   // Full name in the format specified
    */
    public function getFullName( $format = "%s %s" ){
        
        $first_name = $this->getContact()->getFirstName();
        $last_name = $this->getContact()->getLastName();
        
        return sprintf( $format, $first_name, $last_name );
    }
    
    
    /**
    * Gets the user's first name and first character of their last name.
    * eg.
    *   John R.
    * 
    * @return string
    */
    public function getFirstNameLastInitial(){
        
        $first_name = $this->getContact()->getFirstName();
        $last_name = $this->getContact()->getLastName();
        
        if( empty($last_name) ){
            return $first_name;
        }else{
            return $first_name . ' ' . substr( $last_name, 0, 1 ) . '.';
        }

    }
    
    
    /**
    * Whether this User is active.
    * 
    * @see sfGuardUser::getIsActive
    * 
    * @return bool
    */
    public function getIsActive(){
        
        // Implementation currently based on sfGuardUser's "is_active" flag
            $sf_guard_user = $this->getsfGuardUser();
        
            return $sf_guard_user->getIsActive();
        
    }
    
    
    /**
    * If this context is within a web request, this attemps to
    * retrieve the User's current IP address.
    * 
    * It considers scenarios where the server might be running behind a reverse
    * proxy or load balancer.
    *  - In such cases, server_behind_proxy must be set to true in app.yml
    *
    * 
    * @return int
    *   // ip address (in numeric format)
    */
    public function getCurrentIpAddress(){

        $request = \sfContext::getInstance()->getRequest();
        
        @$host = ip2long( $request->getRemoteAddress() );
        
        // to prevent ip spoofing, we only consider the X-Forwarded-For header
        // when we know for sure the server is beind a proxy that manages it.
            if( \sfConfig::get( 'app_server_behind_proxy', false ) ){
            
                $forwarded_for = $request->getForwardedFor();
                
                if( is_array($forwarded_for) && !empty($forwarded_for) ){
                    
                    $forwarded_for = array_pop( $forwarded_for );
                    
                    if( strlen($forwarded_for) ){
                        @$host = ip2long( $forwarded_for );
                    }
                    
                } 

            }
 
        if( isset($host) && strlen($host) ){
            return  $host;
        }

        return null;

    }

} 
