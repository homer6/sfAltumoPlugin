<?php



/**
 * Skeleton subclass for representing a row from the 'system_event_instance_message' table.
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

class SystemEventInstanceMessage extends \BaseSystemEventInstanceMessage {

    
    
    /**
    * Makes the HTTP request for this SystemEventInstanceMessage.
    * Saves this SystemEventInstanceMessage as sent, if successful.
    * 
    * Successful requests must be 200 level and return the following
    * json message body:
    * {
    *   "status": "received"
    * }
    * 
    * @throws \Exception on error
    */
    public function send(){
        
        try{
            //send the http post request
                $request = new \Altumo\Http\OutgoingHttpRequest( $this->getSystemEventSubscription()->getRemoteUrl() );
                $request->setVerifySslPeer( true );
                $request->setRequestMethod( \Altumo\Http\OutgoingHttpRequest::HTTP_METHOD_POST );
                $request->setMessageBody( $this->getSystemEventInstance()->getMessage() );
                $request->setHeaders(array( 
                    'Accept' => 'application/json'
                ));
                $http_response_message = $request->sendAndGetResponseMessage();
                    

            //if the http response is not 200 level, error
                if( $http_response_message->getStatusCode() < 200 || $http_response_message->getStatusCode() >= 300 ){
                    throw new \Exception( 'Non 200 level response from subscriber.' );
                }
                
            //get the reponse json
                $message_body = $http_response_message->getMessageBody();
                $json_message_body = json_decode($message_body);
                if( !$json_message_body ){
                    throw new \Exception( 'JSON response expected. Response is not valid JSON.' );
                }
                
                if( property_exists( $json_message_body, 'status' ) ){
                    
                    $status = $json_message_body->status;
                    if( !is_string($status) ){
                        throw new \Exception( '"status" field must be a string.' );
                    }else{
                        if( strtolower($status) !== 'received' ){
                            throw new \Exception( '"status" field is expected to be "received".' );
                        }else{
                            //success... message received... update the object                 
                            $this->setReceived(true);
                            $this->setReceivedAt( \Altumo\Utils\Date::getInstance()->get() );
                            $this->setStatusMessage( $message_body );
                            $this->save();
                        }
                    }
                    
                }else{
                    throw new \Exception( '"status" field not found. JSON response expects a "status" field.' );
                }
                
        }catch( \Exception $e ){
            
            $this->setStatusMessage( $e->getMessage() );
            $this->save();
            throw $e;
            
        }
        
    }
        
    
} // SystemEventInstanceMessage
