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

class ContactInformation extends \BaseContactInformation {

    /**
    * If state ( @see getState ) is set, return the state's iso code
    * @see State::getIsoCode()
    * 
    * @return mixed
    *   // ISO code of State (string) or null if not set.
    */
    public function getStateIsoCode(){
        
        if( $this->getState() ){
            return $this->getState()->getIsoCode();
        }
        
        return null;
        
    }
    
    
    /**
    * If state ( @see getState ) is set, return the state's iso short code
    * @see State::getIsoShortCode()
    * 
    * @return mixed
    *   // ISO code of State (string) or null if not set.
    */
    public function getStateIsoShortCode(){
        
        if( $this->getState() ){
            return $this->getState()->getIsoShortCode();
        }
        
        return null;
        
    }
    
    
    
} // ContactInformation
