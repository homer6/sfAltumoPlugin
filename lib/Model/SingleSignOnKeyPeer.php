<?php



/**
 * Skeleton subclass for performing query and update operations on the 'single_sign_on_key' table.
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

class SingleSignOnKeyPeer extends \BaseSingleSignOnKeyPeer {

    
    /**
    * Get by Secret
    * 
    * @param mixed $secret
    * @return Reseller
    */
    public static function retrieveBySecret( $secret, $include_unused_only = false ){
        
        return \SingleSignOnKeyQuery::create()
            ->_if( $include_unused_only )
                ->filterByUsed( false )
            ->_endif()
            ->findOneBySecret( $secret );
        
    }
    
    
    /**
    * Removes all SingleSignOnKeys that have expired or have been used.
    * 
    */
    static public function removeAllInvalidSingleSignOnKeys(){
        
        \SingleSignOnKeyQuery::create()
                            ->filterByValid( false )
                            ->delete();

    }
    
    
}
