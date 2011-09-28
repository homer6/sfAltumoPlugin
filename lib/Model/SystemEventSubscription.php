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
    * Tries to send the notification to the remote system. If a response could
    * not be confirmed, the message remains queued and will be resent with 
    * the system event cron until received.
    * 
    * 
    * @param SystemEventInstance $system_event_instance
    * @return SystemEventInstanceMessage
    */
    public function sendSystemEventNotification( $system_event_instance ){
        
        $system_event_instance_message = new \SystemEventInstanceMessage();
        $system_event_instance_message->setSystemEventInstance($system_event_instance);
        $system_event_instance_message->setSystemEventSubscription($this);
        $system_event_instance_message->save();
        
        //try to sent the notification, mark as sent if successful.
        try{
            
            $system_event_instance_message->send();
            
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
    public function setRemoteUrl( $remote_url ){
        
        try{
            $url = new \Altumo\String\Url($remote_url);                        
        }catch( \Exception $e ){
            throw new \Exception( 'Malformed remote URL.' );
        }
        
        $valid = true;
        $scheme = $url->getScheme();
        
        if( $scheme == 'ftp' ){
            throw new \Exception( 'FTP event callbacks are not supported.' );
            $valid = false;
        }
        
        if( $scheme == 'http' ){
            throw new \Exception( 'HTTP event callbacks are not supported. Please ensure that it is HTTPS for the current URL.' );
            $valid = false;
        }
        
        if( $valid ){
            return parent::setRemoteUrl($remote_url);
        }else{
            return $this;
        }
        
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
    
    
} 
