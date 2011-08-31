<?php



/**
 * Skeleton subclass for performing query and update operations on the 'user' table.
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

class UserPeer extends \BaseUserPeer {

    /** 
    * @param mixed $username
    * 
    * @return User
    */
    public static function retrieveByUsername( $username ){
        
        return UserQuery::create()
            ->usesfGuardUserQuery()
                ->filterByUsername( $username )
            ->endUse()
        ->findOne();

    }
    
}
