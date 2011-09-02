<?php



/**
 * Skeleton subclass for performing query and update operations on the 'system_event' table.
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

class SystemEventPeer extends \BaseSystemEventPeer {

    
    /**
    * Gets a single SystemEvent by unique key.
    * 
    * @return SystemEvent
    */
    static public function retrieveByUniqueKey( $unique_key ){
        
        return \SystemEventQuery::create()
                    ->filterByUniqueKey( $unique_key )
                    ->findOne();
        
    }
    
    
}
