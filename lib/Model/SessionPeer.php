<?php



/**
 * Skeleton subclass for performing query and update operations on the 'session' table.
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

class SessionPeer extends \BaseSessionPeer {

    
    /**
    * Retrieves a single Session by the provided session key
    *
    * @param string $session_key
    * @return Session
    */
    public static function retrieveBySessionKey( $session_key ){

        return SessionQuery::create()
            ->filterBySessionKey( $session_key )
        ->findOne();

    }
    

}
