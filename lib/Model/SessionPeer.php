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
    
    
    /**
     * Deletes session rows older than $lifetime
     * 
     * @param int $lifetime
     * 
     * @throws \Exception if $lifetime doesn't validate
     * 
     * @return bool True on success
     */
    public static function deleteGarbageCollectible( $lifetime ) {
    	
    	\Altumo\Validation\Numerics::assertPositiveInteger(
    		$lifetime,
    		'$lifetime expects a positive integer'
    	);
    	
    	SessionQuery::create()
    		->filterByGarbageCollectible( $lifetime )
    		->delete()
    	;
    	
    	return true;
    }
    
    
    /**
     * Returns number of session rows older than $lifetime (and therefore
     * ready for deletion by SessionPeer::deleteGarbageCollectible()
     * 
     * @param int $lifetime
     * 
     * @throws \Exception if $lifetime doesn't validate
     * 
     * @return int
     */
    public static function countGarbageCollectible( $lifetime ) {
    	
    	\Altumo\Validation\Numerics::assertPositiveInteger(
    		$lifetime,
    		'$lifetime expects a positive integer'
    	);
    	
    	return SessionQuery::create()
    		->filterByGarbageCollectible( $lifetime )
    		->count()
    	;
    	
    }
    

}

