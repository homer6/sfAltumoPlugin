<?php

/*
 * This file is part of the Altumo library.
 *
 * (c) Steve Sperandeo <steve.sperandeo@altumo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace sfAltumoPlugin\Email;


/**
* This class wraps around SwiftMailer to simplify the API, allow for 
* environment-specific email rules (e.g. don't send emails out on dev) and to 
* leave open the option to swap SwiftMailer with something else.
* 
* Sample code:
* 
*    \sfAltumoPlugin\Email\Message::create()
*        ->setFrom( 'from@senderemail.com', 'Reginald Baltimore' )
* 
*       // Multiple calls adds to the list of recipients (to, cc, bcc )
*        ->setTo( 'to@senderemail.com', 'George Smith' )
*        ->setTo( 'to2@senderemail.com', 'Harry Smith' )
* 
*        ->setSubject( 'Hello' )
* 
*       // Content is gathered from a partial 
*       // (email_hello_html & email_hello_text must exist )
*        ->setContent( 'email_hello', array( 'name' => 'The System' ) )
* 
*       // Or using static content
*        ->setContentString( '<b>Hello there</b>', 'text/html' )
*        ->setContentString( 'Hello there', 'text/plain' )
* 
*    // $failed_recipients will be populated with any failed recipients
*    ->send( $failed_recipients )
* 
* IMPORTANT: Make sure app_mailer_enabled is set to true
* 
* 
* @author Juan Jaramillo <juan.jaramillo@altumo.com>
*/
class Message{

    const TRANSPORT_SECURITY_SCHEME_SSL = 'ssl';
    const TRANSPORT_SECURITY_SCHEME_TLS = 'tls';

    protected $subject = null;
    protected $from = null;
    protected $reply_to = null;
    protected $to_recipients = array();
    protected $cc_recipients = array();
    protected $bcc_recipients = array();
    protected $html_partial = null;
    protected $text_partial = null;
    protected $partial_variables = array();
    protected $attachments = array();
    protected $content_parts = array();
    protected $swift_transport = null;
    protected $testing_mode_reroute_to_email = null;
    protected $enabled = true;


    /**
    * Constructor for this Message
    * 
    * 
    * @return \sfAltumoPlugin\Email\Message
    */
    public function __construct( $smtp_server = null, $smtp_port = null, $smtp_security_scheme = null, $smtp_user = null, $smtp_passowrd = null ){

        $this->initialize( $smtp_server, $smtp_port, $smtp_security_scheme, $smtp_user, $smtp_passowrd );

    }


    /**
    * Initializes the Message object. Pre-sets all required variables
    * 
    * // Parameters for this functions can be specified by:
    *   - app_mailer_smtp_server
    *   - app_mailer_smtp_port
    *   - app_mailer_smtp_security_scheme
    *   - app_mailer_smtp_user
    *   - app_mailer_smtp_password
    *   - app_mailer_reroute_to
    * 
    * They can be individually overridden by passing in parameters.
    * 
    * If all of them are null, the system's default mail transport is used.
    * 
    * 
    * @param string $smtp_server                    // host name or ip of the smtp server to use
    * @param int $smtp_port                         // port for the smtp server
    * @param string $smtp_security_scheme           // encryption scheme 
    *                                               // - self::TRANSPORT_SECURITY_SCHEME_SSL
    *                                               // - self::TRANSPORT_SECURITY_SCHEME_TLS
    * @param mixed $smtp_username                   // username for the smtp server
    * @param mixed $smtp_passowrd                   // password for the smtp server
    * @param mixed $testing_mode_reroute_to_email   // reroute this message to a
    *                                               // different email address
    *                                               // instead of sending it to
    *                                               // the recipients.
    *                                               // (for testing purposes)
    * 
    * @return \Swift_Transport
    */
    protected function initialize( $smtp_server = null, $smtp_port = null, $smtp_security_scheme = null, $smtp_username = null, $smtp_passowrd = null, $testing_mode_reroute_to_email = null ){

        if( is_null($smtp_server) ){
            
            $smtp_server = \sfConfig::get( 'app_mailer_smtp_server', null );
            
        } 
        
        if( is_null($smtp_port) ){
            
            $smtp_port = \sfConfig::get( 'app_mailer_smtp_port', null );
            
        } 
        
        if( is_null($smtp_security_scheme) ){
            
            $smtp_security_scheme = \sfConfig::get( 'app_mailer_smtp_security_scheme', null );
            
        }      
          
        if( is_null($smtp_username) ){
            
            $smtp_username = \sfConfig::get( 'app_mailer_smtp_user', null );
            
        }        
        
        if( is_null($smtp_passowrd) ){
            
            $smtp_passowrd = \sfConfig::get( 'app_mailer_smtp_password', null );
            
        }
             
        if( is_null($testing_mode_reroute_to_email) ){
            
            $testing_mode_reroute_to_email = \sfConfig::get( 'app_mailer_reroute_to', null );
            
        }
        
        
        if( !is_null($smtp_server) || !is_null($smtp_port) || !is_null($smtp_security_scheme) || !is_null($smtp_username) || !is_null($smtp_passowrd) ){
            
            if( !is_null($smtp_server) ){
                
                $smtp_server = \Altumo\Validation\Strings::assertNonEmptyString( $smtp_server );
                
            }
            
            if( !is_null($smtp_port) ){
                
                $smtp_port = \Altumo\Validation\Numerics::assertPositiveInteger( $smtp_port );
                
            }
            
            if( !is_null($smtp_security_scheme) ){
                
                if( !in_array( $smtp_security_scheme,
                    array(
                        self::TRANSPORT_SECURITY_SCHEME_SSL,
                        self::TRANSPORT_SECURITY_SCHEME_TLS
                    )
                )){
                    
                    throw new Exception( 'Invalid email transport security scheme.' );
                    
                }
                
            }
            
            if( !is_null($smtp_username) ){
                
                $smtp_username = \Altumo\Validation\Strings::assertString( $smtp_username );
                
            }
            
            if( !is_null($smtp_passowrd) ){
                
                $smtp_passowrd = \Altumo\Validation\Strings::assertString( $smtp_passowrd );
                
            }
            
            $this->setSwiftTransport(
                \Swift_SmtpTransport::newInstance(
                    $smtp_server, 
                    $smtp_port, 
                    $smtp_security_scheme
                )->setUsername( $smtp_username )
                 ->setPassword( $smtp_passowrd )
            );

        } else {
            
            $this->setSwiftTransport( \Swift_SmtpTransport::newInstance() );
            
        }
        
        // enable testing mode if required.
            if( !is_null($testing_mode_reroute_to_email) ){
                
                $this->setTestingModeRerouteToEmail( $testing_mode_reroute_to_email );
                
            }
        
        $this->setEnabled( \sfConfig::get('app_mailer_enabled', false) );
        
        return $this->getSwiftTransport();

    }
    
    
    /**
    * Get a new \Swift_Message instance.
    * 
    * @return \Swift_Message
    */
    protected function getSwiftMessage(){
    
        return \Swift_Message::newInstance();
    
    }
    
    
    /**
    * Setter for the $swift_message parameter of this Message
    * 
    * 
    * @param mixed $swift_transport
    * 
    * @return void
    */
    protected function setSwiftTransport( $swift_transport ){
    
        $this->swift_transport = $swift_transport;
    
    }    
    
    
    /**
    * Getter for the $swift_message parameter of this Message
    * 
    * @return \Swift_Transport
    */
    protected function getSwiftTransport(){
    
        return $this->swift_transport;
    
    }
    
    
    /**
    * Creates a new instance of an email Message
    * 
    * 
    * @return \sfAltumoPlugin\Email\Message
    */
    public static function create(){

        return new self();
        
    }
    
    
    /**
    * Sets the subject of this email Message
    * 
    * 
    * @param string $subject
    * 
    * @return \sfAltumoPlugin\Email\Message
    */
    public function setSubject( $subject ){

        $this->subject = \Altumo\Validation\Strings::assertString( $subject );
        
        return $this;
        
    }
    
    
    /**
    * Get the subject of this email Message
    * 
    * 
    * @return string
    */
    protected function getSubject(){
    
        return $this->subject;
        
    }    
    
    
    /**
    * Sets the subject of this email Message
    * 
    * 
    * @param bool $enabled
    * 
    * @return \sfAltumoPlugin\Email\Message
    */
    protected function setEnabled( $enabled ){

        $this->enabled = \Altumo\Validation\Booleans::assertLooseBoolean( $enabled );
        
        return $this;
        
    }
    
    
    /**
    * Get the subject of this email Message
    * 
    * 
    * @return string
    */
    protected function getEnabled(){
    
        return $this->enabled;
        
    }
        
    
    /**
    * Set the from address of this email Message
    * 
    * 
    * @param string $from   //email address of the recipient
    * @param string $name   //name of the recipient
    * 
    * @throws \Exception    // if $from is not a valid email address
    * 
    * @return \sfAltumoPlugin\Email\Message
    */
    public function setFrom( $from, $name = null ){
        
        $from = \Altumo\Validation\Emails::assertEmailAddress( 
            $from,
            '"' . $from . '" is not a valid email address for setFrom()'
        );
        
        if( !is_null($name) ){
            \Altumo\Validation\Strings::assertNonEmptyString( $name );
        }
    
        $this->from = array( $from => $name );
        
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
    * Set the reply-to address of this email Message
    * 
    * 
    * @param string $reply_to   //email address of the recipient
    * @param string $name   //name of the recipient
    * 
    * @throws \Exception    // if $from is not a valid email address
    * 
    * @return \sfAltumoPlugin\Email\Message
    */
    public function setReplyTo( $reply_to, $name = null ){

        $reply_to = \Altumo\Validation\Emails::assertEmailAddress( 
            $reply_to,
            '"' . $reply_to . '" is not a valid email address for setReplyTo()'
        );

        if( !is_null($name) ){
            \Altumo\Validation\Strings::assertNonEmptyString( $name );
        }

        $this->reply_to = array( $reply_to => $name );

        return $this;

    }
    
    
    /**
    * Getter for the reply_to field on this Message.
    * 
    * 
    * @return string
    */
    protected function getReplyTo(){
    
        return $this->reply_to;
        
    }  
    
    
    /**
    * Adds a "To" recipient to this message
    * 
    * 
    * @param string $email_address         //email address of recipient 
    * @param string $name               //name of recipient
    * 
    * @return \sfAltumoPlugin\Email\Message
    */
    public function setTo( $email_address, $name = null ){
    
        $email_address = \Altumo\Validation\Emails::assertEmailAddress( 
            $email_address,
            '"' . $email_address . '" is not a valid email address for setTo()'
        );
        
        if( !is_null($name) ){
            \Altumo\Validation\Strings::assertNonEmptyString( $name );
        }
        
        $this->to_recipients[$email_address] = $name;
        
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
    * Adds a "cc" recipient to this message
    * 
    * 
    * @param string $email_address      //email address of cc recipient 
    * @param string $name               //name of recipient
    * 
    * @return \sfAltumoPlugin\Email\Message
    */
    public function setCc( $email_address, $name = null ){
    
        $email_address = \Altumo\Validation\Emails::assertEmailAddress( 
            $email_address,
            '"' . $email_address . '" is not a valid email address for setCc()'
        );
        
        if( !is_null($name) ){
            \Altumo\Validation\Strings::assertNonEmptyString( $name );
        }
        
        $this->cc_recipients[$email_address] = $name;
        
        return $this;
        
    }
    
    
    /**
    * Getter for the cc_recipients field on this Message.
    * 
    * 
    * @return array
    */
    protected function getCcRecipients(){
    
        return $this->cc_recipients;
        
    } 
     
    
    /**
    * Adds a "bcc" recipient to this message
    * 
    * 
    * @param string $email_address      //email address of cc recipient 
    * @param string $name               //name of recipient
    * 
    * @return \sfAltumoPlugin\Email\Message
    */
    public function setBcc( $email_address, $name = null ){
    
        $email_address = \Altumo\Validation\Emails::assertEmailAddress( 
            $email_address,
            '"' . $email_address . '" is not a valid email address for setBcc()'
        );
        
        if( !is_null($name) ){
            \Altumo\Validation\Strings::assertNonEmptyString( $name );
        }
        
        $this->bcc_recipients[$email_address] = $name;
        
        return $this;
        
    }
    
    
    /**
    * Getter for the bcc_recipients field on this Message.
    * 
    * 
    * @return array
    */
    protected function getBccRecipients(){
    
        return $this->bcc_recipients;
        
    }
        
    
    /**
    * Setter for the html_partial field on this Message.
    * 
    * 
    * @param string $html_partial
    */
    protected function setHtmlPartial( $html_partial ){
    
        $this->html_partial = $html_partial;
        
    }
    
    
    /**
    * Getter for the html_partial field on this Message.
    * 
    * 
    * @return string
    */
    protected function getHtmlPartial(){
    
        return $this->html_partial;
        
    }
    
    
    /**
    * Setter for the text_partial field on this Message.
    * 
    * 
    * @param string $html_partial
    */
    protected function setTextPartial( $text_partial ){
    
        $this->text_partial = $text_partial;
        
    }
    
    
    /**
    * Getter for the text_partial field on this Message.
    * 
    * 
    * @return string
    */
    protected function getTextPartial(){
    
        return $this->text_partial;
        
    }   
     
    
    /**
    * Set the partial that contains the body of this Message.
    * 
    * The contents of an email Message body are retrieved from a partial.
    * $partial_name must be a prefix so that partials with the following names exist:
    * 
    * - $partial_name . '_html'
    * - $partial_name . '_text"
    * 
    * E.g.
    * 
    * - email_user_welcome_html  //contains the HTML version of the email body
    * - email_user_welcome_text  //contains the text-only version of the email body
    * 
    * 
    * @param string $partial_name
    * @param array $partial_variables   //variables to pass to content partials
    * 
    * @return \sfAltumoPlugin\Email\Message
    */
    public function setContent( $partial_name, $partial_variables = array() ){

        if( !is_array( $partial_variables ) ){
            throw new \Exception( 'partial_variables is expected to be an array' );
        }
        
        
        $this->setHtmlPartial( $partial_name . '_html' );
        $this->setTextPartial( $partial_name . '_text' );
        
        $this->partial_variables = $partial_variables;
        
        return $this;

    }

    
    /**
    * Set the content of this Message from a string, or add a content part
    * in a different format.
    * 
    * E.g. if also using setContent(), this could be used to add a third part
    * in 'text/json' if you wanted to do that. Otherwise, it can be used without
    * setContent() in order to send emails without using partials.
    * 
    * 
    * @param string $content
    * @param array $encoding   //content encoding. e.g. text/html, text/plain, etc.
    * 
    * @return \sfAltumoPlugin\Email\Message
    */
    public function setContentString( $content, $encoding = 'text/plain' ){

        $content = \Altumo\Validation\Strings::assertString( 
            $content, 
            'Invalid email content. String expected.' 
        );        
        
        $encoding = \Altumo\Validation\Strings::assertString( 
            $encoding, 
            'Invalid email content encoding. String expected.' 
        );
        
        
        $this->content_parts[] = array( $content, $encoding );
        
        return $this;

    }


    /**
    * Getter for the content_parts field of this Message
    * 
    * 
    * @return array
    */
    protected function &getContentParts(){
        
        return $this->content_parts;
        
    }


    /**
    * Getter for the partial_variables field of this Message
    * 
    * 
    * @return array
    */
    protected function &getPartialVariables(){
        
        return $this->partial_variables;
        
    }
 
    
    /**
    * Add an attachment to this Message
    * 
    * 
    * @param array $attachments     //path to the file to attach
    * 
    * @return \sfAltumoPlugin\Email\Message
    */
    public function setAttachment( $attachment_path ){
    
        $this->attachments[$email_address] = $name;
        
        return $this;
        
    }
    
    
    /**
    * Getter for the attachments field on this Message.
    * 
    * 
    * @return array
    */
    protected function getAttachments(){
    
        return $this->attachments;
        
    }
    
    
    /**
    * Pre-sets the Swift_Message object and returns it.
    * 
    * 
    * @throws \Exception    // if to and/or from are not set
    * 
    * @return \Swift_Message
    */
    protected function getPreparedSwiftMessage(){
    
        //if "From" has not been initialized, throw exception
            if( $this->getFrom() == null ){
                throw new \Exception( 'A "from" address is required in order to send email' );
            }

 
        //if "To" has not been initialized, throw exception
            if( count($this->getToRecipients()) == 0 ){
                throw new \Exception( 'At least one "to" address is required in order to send email');
            }
            
        \sfContext::getInstance()->getConfiguration()->loadHelpers( 'Partial' );

        // create SwiftMessage instance
            $swift_message = $this->getSwiftMessage()
                ->setFrom( $this->getFrom() )
                ->setReplyTo( $this->getReplyTo() )
                ->setSubject( $this->getSubject() );
        
        // if in testing mode, reroute message
            if( $this->hasTestingModeRerouteToEmail() ){
                
                $swift_message
                    ->setTo( $this->getTestingModeRerouteToEmail() )
                    ->setSubject( 
                        $this->getSubject() .
                        ' [' . 
                        $this->getRecipientsDescription() .
                        ']'
                    );
                
        // set recipients normally
            } else {
                
                $swift_message
                    ->setTo( $this->getToRecipients() )
                    ->setCc( $this->getCcRecipients() )
                    ->setBcc( $this->getBccRecipients() );
                
            }
            
        if( $this->getHtmlPartial() != null ){
            $swift_message
                ->setBody( \get_partial($this->getHtmlPartial(), $this->getPartialVariables()), 'text/html' )
                ->addPart( \get_partial($this->getTextPartial(), $this->getPartialVariables()), 'text/plain' );
        }

        foreach( $this->getContentParts() as $content_part ){
            $swift_message->addPart( $content_part[0], $content_part[1] );
        }

        foreach( $this->getAttachments() as $attachment ){
            $swift_message->attach( \Swift_Attachment::fromPath( $attachment ) );
        }
        
        return $swift_message;

    }
    
    
    /**
    * Gets a ready-to-use Swift_Mailer
    * 
    * if $host is set, an SMTP transport will be used, otherwise the standard
    * mail transport will be set.
    * 
    * 
    * @return \Swift_Mailer
    */
    protected function getPreparedSwiftMailer(){

        return \Swift_Mailer::newInstance( $this->getSwiftTransport() );

    }
    
    
    /**
    * Enables testing mode, which means this Message will NOT be sent to the
    * recipients specified by "To", "CC", "BCC". This Message will be sent to
    * $reroute_emails_to instead, with a modified subject showing the original 
    * recipients.
    * 
    * @param string $reroute_emails_to
    *   // email address to reroute message to.
    * 
    * @return \sfAltumoPlugin\Email\Message
    */
    public function setTestingModeRerouteToEmail( $reroute_emails_to ){

        $this->testing_mode_reroute_to_email = \Altumo\Validation\Emails::assertEmailAddress(
            $reroute_emails_to,
            '$reroute_emails_to expects an email address.'
        );

        return $this;

    }


    /**
    * Get the address to which this message should be rerouted to if in testing
    * mode. 
    * 
    * @return string
    *   // email address
    */
    protected function getTestingModeRerouteToEmail(){
 
        return $this->testing_mode_reroute_to_email;

    }


    /**
    * Whether this message has testing mode enabled 
    * (i.e. a reroute address is present.)
    * 
    * @return \sfAltumoPlugin\Email\Message
    */
    protected function hasTestingModeRerouteToEmail(){
 
        return $this->getTestingModeRerouteToEmail() !== null;

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
 
        $all_recipients = array_merge(
            $this->getToRecipients(),
            $this->getCcRecipients(),
            $this->getBccRecipients()
        );

        return implode( ', ', array_keys($all_recipients) );

    }


    /**
    * Send this Message
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
 
        
        return $this->getPreparedSwiftMailer()->send( 
            $this->getPreparedSwiftMessage(),
            $failed_recipients
        );

    }

}
