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
        
   
    /**
    * Determines whether the provided $email_address is available to be used. 
    * This is a case-insensitive match.
    * 
    * @param string $email_address
    * @throws \Exception                    //if email address format is invalid
    * @return boolean
    */
    public static function testAvailableEmailAddress( $email_address, $exception_message = null ){
        
        $email_address = \Altumo\Validation\Emails::assertEmailAddress( $email_address, $exception_message );
        $email_address = strtolower( $email_address );
        
        $count = UserQuery::create()
                    ->usesfGuardUserQuery()
                        ->filterByUsername( $email_address )
                    ->endUse()
                ->count();
        
        if( $count === 0 ){
            return true;
        }else{
            return false;
        }
        
    }
    
    
}
