<?php

/**
 * Skeleton subclass for performing query and update operations on the 'system_event_instance_message' table.
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

class SystemEventInstanceMessagePeer extends \BaseSystemEventInstanceMessagePeer {


    /**
     * Sends all of the SystemEventMessages that were not received.
     * 
     * 
     */
    static public function sendUnsentSystemEventInstanceMessages(){

        $messages = \SystemEventInstanceMessageQuery::create()
                            ->filterByReceived( false )
                            ->find();

        foreach( $messages as $message ){

        	/* @var $message SystemEventInstanceMessage */

            try{

                $message->send();

            } catch( \Exception $e ) {}

        }

    }

}
