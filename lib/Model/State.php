<?php



/**
 * Skeleton subclass for representing a row from the 'state' table.
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

class State extends \BaseState {

    
    /**
    * Gets this State's name as a string.
    * 
    * @return string
    */
    public function __toString(){
        
        return $this->getName();
        
    }

    
}
