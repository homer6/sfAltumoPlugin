<?php



/**
 * Skeleton subclass for representing a row from the 'contact' table.
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

class Currency extends \BaseCurrency{
    
    
    /**
    * Gets this contact's full name.
    * 
    */
    public function __toString(){
        
        return $this->getIsoCode();
        
    }

} 
