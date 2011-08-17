<?php

/**
 * Skeleton subclass for representing a row from the 'contact_information' table.
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
        
        $first_name = $this->getContactInformation()->getFirstName();
        $last_name = $this->getContactInformation()->getLastName();
        
        return sprintf( $format, $first_name, $last_name );
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

} // ContactInformation
