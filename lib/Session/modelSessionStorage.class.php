<?php

/*
 * This file is part of the Altumo library.
 *
 * (c) Steve Sperandeo <steve.sperandeo@altumo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
* Provides an sfPDOSessionStorage extension for tightly integrating
* the session with the model.
*
*
* @see sfPDOSessionStorage.php
* 
* @author Juan Jaramillo <juan.jaramillo@altumo.com>
*/
class modelSessionStorage extends sfPDOSessionStorage {
    
    
    /**
    * Override the initializa function to set better session defaults.
    * 
    * @param array $options
    * @return bool
    */
    public function initialize( $options = null ) {

        $options = array_merge(array(
            'session_cookie_lifetime' => 86400, // 1 day
            'session_cookie_secure'   => true
        ), $options);

        return parent::initialize( $options );      
    }

    
    /**
    * Reads a session.
    *
    * @param  string $id  A session ID
    *
    * @return string      The session data if the session was read or created, otherwise an exception is thrown
    *
    * @throws <b>DatabaseException</b> If the session cannot be read
    */
    private $session_key = null;

    private function setSessionKey( $session_key ) {
        $this->session_key = $session_key;
    }
    
    
    /**
    * Get the unique session key.
    * 
    * @return string
    */
    public function getSessionKey(){
        return $this->session_key;
    }
    
        

    /**
    *   @see parent::sessionRead
    */
    public function sessionRead($id){
        
        $result = parent::sessionRead($id);
        
        $this->setSessionKey( $id );
        
        // Find session persistent object
        $session = SessionQuery::create()->filterBySessionKey( $id )->findOne();

        // Associate an IP address with the session & user
            if( !is_null( $session ) && ( $session instanceof Session ) ){
            
                $context = sfContext::getInstance();
                
                if( $session->getClientIpAddress() == null ){  
                    $session->setClientIpAddress( $context->getRequest()->getRemoteAddress() );
                }
                
                // Associate User with session
                    $user = $context->getUser();
                    
                    if( $session->getUserId() == null && !is_null( $user ) && $user->isAuthenticated() ){
                        $session->setUser( $user->getProfile() );
                        
                    }
                    
                $session->save();
            }
        
        return $result;

    }


    /**
    * Gets the Session object associated to the session.
    * 
    * @param mixed $session_key
    * @return Session
    */
    public function getSession(){
        $session = SessionPeer::retrieveBySessionKey( $this->getSessionKey() );
        
        return $session;
    }
    
    
    /**
     * Deletes old sessions
     * 
     * (non-PHPdoc)
     * @see sfPDOSessionStorage::sessionGC()
     */
    public function sessionGC( $lifetime ) {
    	
    	\Altumo\Validation\Numerics::assertPositiveInteger(
    		$lifetime,
    		'$lifetime expects a positive integer'
    	);
    	
    	SessionPeer::deleteGarbageCollectible( $lifetime );
    	
    	return true;
    }   
    
}
