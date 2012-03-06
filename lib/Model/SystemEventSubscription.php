<?php



/**
 * Skeleton subclass for representing a row from the 'system_event_subscription' table.
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

class SystemEventSubscription extends \BaseSystemEventSubscription {

    
    /**
    * Saves this notification to the database so it can be sent to the remote 
    * system later. If a response could not be confirmed, the message remains 
    * queued and will be resent with the system event cron until received.
    * 
    * @param SystemEventInstance $system_event_instance
    * @return SystemEventInstanceMessage
    */
    public function saveSystemEventNotification( $system_event_instance ){
        
        $system_event_instance_message = new \SystemEventInstanceMessage();
        $system_event_instance_message->setSystemEventInstance($system_event_instance);
        $system_event_instance_message->setSystemEventSubscription($this);
        $system_event_instance_message->save();

        //try to sent the notification, mark as sent if successful.
        try{
            
            //this is handled by the cron now
            
        }catch( \Exception $e ){
            
            //do nothing; cron will try to resend any unset
            
        }
        
        return $system_event_instance_message;
    }
        
    
    /**
    * Set the value of [remote_url] column.
    * 
    * @param string $url
    * @throws \Exception                    //on malformed URL
    * @throws \Exception                    //if URL scheme isn't https
    * @return SystemEventSubscription       //The current object (for fluent 
    *                                         API support)
    */
    public function setRemoteUrl( $remote_url ) {
		
    	return parent::setRemoteUrl(
    		is_null( $remote_url )
    			? $remote_url
    			: \Altumo\Validation\Strings::assertStringAndLength( $remote_url, null, 255 )
    	);
    	    	
    }
    
    
    /**
     * @param string $email
     * 
     * @return string
     * 
     * @throws \Exception if value fails to validate
     */
    protected function assertEmailValid($email) {
    
    	return \Altumo\Validation\Emails::assertEmailAddress($email);
    }
    
    
    /**
     * @param string $remote_url
     * 
     * @return string
     * 
     * @throws \Exception if value fails to validate
     */
    protected function assertRemoteUrlValid($remote_url) {
    	
    	/*
    	 * Check syntax
    	 */
    	
    	try{
    		
    		$url = new \Altumo\String\Url($remote_url);
    		
    	}catch( \Exception $e ){
    		
    		throw new \Exception( 'Malformed remote URL.' );
    		
    	}
    	
    	
    	/*
    	 * check protocol, don't allow ftp or http
    	 */
    	
    	$scheme = $url->getScheme();
    	 
    	if( $scheme == 'ftp' ){
    		throw new \Exception( 'FTP event callbacks are not supported.' );
    	}
    	 
    	if( $scheme == 'http' ){
    		throw new \Exception( 'HTTP event callbacks are not supported. Please ensure that it is HTTPS for the current URL.' );
    	}
    	
    	
    	return $remote_url;
    }
    
    
    /**
    * Sets this system event by unique key.
    * 
    * 
    * @throws \Exception //if unknown system event
    */
    public function setSystemEventUniqueKey( $system_event_unique_key ){
        
        $system_event = SystemEventPeer::retrieveByUniqueKey($system_event_unique_key);
        if( !$system_event ){
            throw new \Exception( 'Unknown system event: ' . $system_event_unique_key );
        }else{
            $this->setSystemEvent($system_event);
        }
        
    }
    
    
    /**
    * Gets the unique_key for the attached SystemEvent
    * 
    * @return string
    */
    public function getSystemEventUniqueKey(){
        
        $system_event = $this->getSystemEvent();
        if( !$system_event ){
            return null;
        }else{
            return $system_event->getUniqueKey();
        }
        
    }
        
    
    /**
    * Setter for the authorization_token field on this SystemEventSubscription.
    * 
    * @param string $authorization_token
    * @return SystemEventSubscription
    */
    public function setAuthorizationToken( $authorization_token ){
    
        return parent::setAuthorizationToken( \Altumo\Validation\Strings::assertStringAndLength($authorization_token, 10, 255) );
        
    }
    
    
    /**
    * Returns true if this subscription is for sending an email, false if not
    *
    * @return bool
    */
    public function isEmailSubscription() {
    
    	return ( $this->getType() == 'email' );
    }
    
    
    /**
     * Returns true if this subscription is for making a HTTP request,
     * false if not
     *
     * @return bool
     */
    public function isRequestSubscription() {
    
    	return ( $this->getType() == 'request' );
    }
    
    
    /**
     * (non-PHPdoc)
     * @see BaseSystemEventSubscription::save()
     */
    public function save( PropelPDO $con = null )
    {
    	if ($this->isEmailSubscription() ) {
    		// if subscription is for email,
    		
    		// validate remote url as email
    		$this->assertEmailValid( $this->getRemoteUrl() );
    		
    	} elseif ( $this->isRequestSubscription() ) {
    		// if subscription is for a request,
    		
    		// validate remote url as url
    		$this->assertRemoteUrlValid( $this->getRemoteUrl() );
    		
    	}
    	
    	parent::save($con);
    }

    
    
} 

