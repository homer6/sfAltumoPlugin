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
    
    
    /**
    * Triggers a system event. 
    * 
    * This will create a SystemEventInstance instance and notify any remote 
    * systems if they have active SystemEventSubscription objects. 
    * 
    * Each subscriber will be sent a unique SystemEventInstanceMessage.
    * 
    * eg.
    * 
    *     $message = new stdClass();
    *     $message->user_id = 54;
    *     $message->city = 'Vancouver';
    *     \SystemEventPeer::triggerEvent( 'new_user_signed_up', $message );
    * 
    * 
    * 
    * @param string $event_unique_key
    * @param stdClass $message
    * @param integer $user_id
    * 
    * @throws \Exception if system event is not known
    * @throws \Exception if $message is not a stdClass (if not null)
    * @throws \Exception if $user_id is provided (not null) but not found
    * 
    * @return SystemEventInstance
    */
    static public function triggerEvent( $event_unique_key, $message = null, $user_id = null ){
        
        //validate the arguments
            $system_event = \SystemEventPeer::retrieveByUniqueKey( $event_unique_key );
            
            if( !$system_event ){
                throw new \Exception( 'Unknown System Event: ' . $event_unique_key );
            }
            
            if( !is_null($message) ){
                if( !($message instanceof \stdClass) ){
                    throw new \Exception( 'Message must be a stdClass.' );
                }
            }else{
                $message = new \stdClass();
            }

            
            if( !is_null($user_id) ){
                $user = \UserPeer::retrieveByPK( $user_id );
                if( !$user ){
                    throw new \Exception( 'Unknown User.' );
                }
            }else{
                $user = \sfContext::getInstance()->getUser()->getUser();
                $user_id = $user->getId();
            }
            
            
        //record the event
            $system_event_instance = new \SystemEventInstance();
            $system_event_instance->setMessage( json_encode($message) );
            if( isset($user) ){
                $system_event_instance->setUser( $user );
            }
            $system_event_instance->setSystemEvent( $system_event );
            $system_event_instance->save();
        
        //get the subscribers for this event
            $system_event_subscriptions = \SystemEventSubscriptionPeer::getSubscriptionsForEvent( $system_event->getId(), $user_id );            
        
        //notify each of the subscribers
            foreach( $system_event_subscriptions as $system_event_subscription ){
                $system_event_subscription->sendSystemEventNotification( $system_event_instance );
            }
        
    }

    
    
}
