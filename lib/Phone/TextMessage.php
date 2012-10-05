<?php

/*
 * This file is part of the Altumo library.
 *
 * (c) Steve Sperandeo <steve.sperandeo@altumo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace sfAltumoPlugin\Phone;


/**
* This class simplifies the process of sending text messages (sms) to a phone.
* It uses Twilio (twilio.com) services for delivery.
* 
* Sample code:
* 
*    \sfAltumoPlugin\Phone\Message::create()
*        ->setFrom( '6041234567' )
* 
*       // Multiple calls adds to the list of recipients
*        ->setTo( '7786666666' )
*        ->setTo( '7789995555' )
* 
*        ->setText( 'Hello there' )
* 
*    // $failed_recipients will be populated with any failed recipients
*    ->send( $failed_recipients )
* 
* IMPORTANT: Make sure app_phone_enabled is set to true
* 
* 
* @author Juan Jaramillo <juan.jaramillo@altumo.com>
*/
class TextMessage{

    protected $text = null;
    protected $from = null;
    protected $to_recipients = array();
    protected $enabled = true;
    protected $twilio_client = null;
    protected $testing_mode_reroute_messages_to = null;

    /**
    * Constructor for this TextMessage
    * 
    * 
    * @return \sfAltumoPlugin\Phone\TextMessage
    */
    public function __construct( $twilio_account_sid = null, $twilio_account_token = null  ){

        $this->initialize( $twilio_account_sid, $twilio_account_token );

    }


    /**
    * Initializes the TextMessage object. Pre-sets all required variables
    * 
    * // Parameters for this functions can be specified by:
    *   - app_phone_twilio_account_sid
    *   - app_phone_twilio_account_token
    *   - app_phone_default_from_number
    *
    * 
    * @param string $twilio_account_sid
    *   //
    * 
    * @param string $twilio_account_token
    *   //
    * 
    * @return null
    */
    protected function initialize( $twilio_account_sid = null, $twilio_account_token = null ){

        $twilio_settings = \sfConfig::get( 'app_phone_twilio', array() );
        
        if( array_key_exists('account_sid',$twilio_settings) ){
            
            $twilio_account_sid = $twilio_settings['account_sid'];
            
        }

        if( array_key_exists('account_token', $twilio_settings) ){
            
            $twilio_account_token = $twilio_settings['account_token'];
            
        }
        
        if( ($default_from_number = \sfConfig::get( 'app_phone_default_from_number', null )) !== null ){
            
            $this->setFrom( $default_from_number );
            
        }      

        \Altumo\Validation\Strings::assertNonEmptyString(
            $twilio_account_sid,
            '$twilio_account_sid is required'
        );
        
        \Altumo\Validation\Strings::assertNonEmptyString(
            $twilio_account_token,
            '$twilio_account_token is required'
        );
        
        // create Twilio Client
            $twilio_client = new \Services_Twilio( $twilio_account_sid, $twilio_account_token );
            $this->setTwilioClient( $twilio_client );

        
        $this->setEnabled( \sfConfig::get('app_phone_enabled', false) );
        
        return null;
    }
    
    
    /**
    * Setter for the $twilio_client parameter of this Message
    * 
    *
    * @param \Services_Twilio $swift_transport
    * 
    * @return void
    */
    protected function setTwilioClient( $twilio_client ){
    
        $this->twilio_client = $twilio_client;
    
    }    
    
    
    /**
    * Getter for the $twilio_client parameter of this Message
    * 
    * @return \Services_Twilio
    */
    protected function getTwilioClient(){
    
        return $this->twilio_client;
    
    }
    
    
    /**
    * Creates a new instance of TextMessage
    * 
    * 
    * @return \sfAltumoPlugin\Phone\TextMessage
    */
    public static function create(){

        return new self();
        
    }
    
    
    /**
    * Sets the subject of this TextMessage
    * 
    * 
    * @param string $subject
    * 
    * @return \sfAltumoPlugin\Phone\TextMessage
    */
    public function setText( $text ){

        $this->text = \Altumo\Validation\Strings::assertString( $text );
        
        return $this;
        
    }
    
    
    /**
    * Get the subject of this TextMessage
    * 
    * 
    * @return string
    */
    protected function getText(){
    
        return $this->text;
        
    }    
    
    
    /**
    * Sets the subject of this TextMessage
    * 
    * 
    * @param bool $enabled
    * 
    * @return \sfAltumoPlugin\Phone\TextMessage
    */
    protected function setEnabled( $enabled ){

        $this->enabled = \Altumo\Validation\Booleans::assertLooseBoolean( $enabled );
        
        return $this;
        
    }
    
    
    /**
    * Get the subject of this TextMessage
    * 
    * 
    * @return string
    */
    protected function getEnabled(){
    
        return $this->enabled;
        
    }
        
    
    /**
    * Set the from address of this TextMessage
    * 
    * 
    * @param string $from
    *   // Phone number of the sender
    * 
    * @throws \Exception    
    *   // if $from is not a valid phone number
    * 
    * @return \sfAltumoPlugin\Phone\TextMessage
    */
    public function setFrom( $from ){
        
        $from = \Altumo\Validation\Numerics::assertUnsignedInteger( 
            $from,
            '"' . $from . '" is not a valid phone number for setFrom()'
        );

        $this->from = $from;

        return $this;

    }
    
    
    /**
    * Getter for the from field on this Message.
    * 
    * 
    * @return string
    */
    protected function getFrom(){
    
        return $this->from;
        
    }


    /**
    * Adds a "To" phone number recipient
    * 
    * 
    * @param string $phone_number         
    *   // phone number
    * 
    * @return \sfAltumoPlugin\Phone\TextMessage
    */
    public function setTo( $phone_number ){
    
        $phone_number = \Altumo\Validation\Numerics::assertUnsignedInteger( 
            $phone_number,
            '"' . $phone_number . '" is not a valid phone number for setTo()'
        );
        
        $this->to_recipients[] = $phone_number;
        
        return $this;
        
    }
    
    
    /**
    * Getter for the to_recipients field on this Message.
    * 
    * 
    * @return array
    */
    protected function getToRecipients(){
    
        return $this->to_recipients;
        
    }
    
   
    
    
    /**
    * Enables testing mode, which means this Message will NOT be sent to the
    * recipients specified by "To". This Message will be sent to
    * $reroute_messages_to instead.
    * 
    * @param string $reroute_messages_to
    *   // phone numnber to reroute message to.
    * 
    * @return \sfAltumoPlugin\Phone\TextMessage
    */
    public function setTestingModeRerouteToNumber( $reroute_messages_to ){

        $this->testing_mode_reroute_messages_to = \Altumo\Validation\Numerics::assertUnsignedInteger( 
            $reroute_messages_to,
            '$reroute_messages_to expects a phone number.'
        );

        return $this;

    }


    /**
    * Get the number to which this message should be rerouted to if in testing
    * mode. 
    * 
    * @return string
    *   // phone number
    */
    protected function getTestingModeRerouteToNumber(){
 
        return $this->testing_mode_reroute_messages_to;

    }


    /**
    * Whether this message has testing mode enabled 
    * (i.e. a reroute number is present.)
    * 
    * @return bool
    */
    protected function hasTestingModeRerouteToNumber(){
 
        return $this->getTestingModeRerouteToNumber() !== null;

    }

 
    /**
    * Returns a list of recipients.
    * 
    * e.g.
    * "Peter Griffin <pea.tear@griffin.com>, Jack Smith <jack@smith.com>"
    * 
    * @return string
    */
    protected function getRecipientsDescription(){
 
        $all_recipients = $this->getToRecipients();

        return implode( ', ', array_keys($all_recipients) );

    }


    /**
    * Send this TextMessage
    * 
    * @param mixed $failed_recipients   
    *   //reference to variable to set failed recipients.
    * 
    * 
    * @return void
    */
    public function send( &$failed_recipients = null ){

        if( !$this->getEnabled() ){
            return array();
        }

        if( !is_array($failed_recipients) ){
            $failed_recipients = array();
        }
 
        foreach( $this->getToRecipients() as $recipient_number ){
            
            try{
                $this->getTwilioClient()->account->sms_messages->create(
                    $this->getFrom(),
                    $recipient_number,
                    $this->getText()
                );
            } catch( Exception $e ){
                $failed_recipients[] = $recipient_number;
            }

        }
        
        return $failed_recipients;

    }

}
