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
* This class' methods are invoked directly by git's hooks. Use this to execute
* code when git's hooks are called.
* 
* Note: Git hooks must be installed first. 
* Use "./symfony altumo:git-hook-handler install" to install git hooks.
* 
* @author Steve Sperandeo <steve.sperandeo@altumo.com>
*/
class Message{


    protected $swift_message = null;
    protected $subject = null;
    protected $from_address = null;
    protected $reply_to_address = null;
    protected $to_addresses = null;
    protected $cc_addresses = null;
    protected $bcc_addresses = null;
    protected $html_partial = null;
    protected $text_partial = null;
    protected $attachments = null;


    public function __construct(){
        
        $this->initialize();
        
    }
    
    
    protected function initialize(){
        
        $this->setSwiftMessage( \Swift_Message::newInstance() );
        
    }
    
    
    protected function setSwiftMessage( $swift_message ){
    
        $this->swift_message = $swift_message;
    
    }
    
    
    /**
    * Creates a new instance of an email Message
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
    
        $this->subject = $subject;
        
        return $this;
        
    }
    
    
    /**
    * Get the subject of this email Message
    * 
    * @return string
    */
    protected function getSubject(){
    
        return $this->subject;
        
    }
        
    
    /**
    * Set the from address of this email Message
    * 
    * @param string $from_address
    * 
    * @return \sfAltumoPlugin\Email\Message
    */
    public function setFromAddress( $from_address ){
    
        $this->from = $from_address;
        
        return $this;
        
    }
    
    
    /**
    * Getter for the from field on this Message.
    * 
    * @return string
    */
    protected function getFrom(){
    
        return $this->from;
        
    }
        
    
    /**
    * Set the reply to address of this email Message
    * 
    * @param string $reply_to_address
    * 
    * @return \sfAltumoPlugin\Email\Message
    */
    public function setReplyToAddress( $reply_to_address ){
    
        $this->reply_to_address = $reply_to_address;
        
    }
    
    
    /**
    * Getter for the reply_to_address field on this Message.
    * 
    * @return string
    */
    protected function getReplyToAddress(){
    
        return $this->reply_to_address;
        
    }
        
    
    /**
    * Setter for the to_addresses field on this Message.
    * 
    * @param array $to_addresses
    */
    protected function setToAddresses( $to_addresses ){
    
        $this->to_addresses = $to_addresses;
        
    }    
    
    
    /**
    * Setter for the to_addresses field on this Message.
    * 
    * @param array $to_addresses
    * 
    * @return \sfAltumoPlugin\Email\Message
    */
    public function addToAddress( $to_address ){
    
        $this->to_addresses[] = $to_address;
        
        return $this;
        
    }
    
    
    /**
    * Getter for the to_addresses field on this Message.
    * 
    * @return array
    */
    protected function getToAddresses(){
    
        return $this->to_addresses;
        
    }
        
    
    /**
    * Setter for the cc_addresses field on this Message.
    * 
    * @param array $cc_addresses
    */
    protected function setCcAddresses( $cc_addresses ){
    
        $this->cc_addresses = $cc_addresses;
        
    }       
     
    
    /**
    * Setter for the cc_addresses field on this Message.
    * 
    * @param array $cc_addresses
    * 
    * @return \sfAltumoPlugin\Email\Message
    */
    public function addCcAddress( $cc_address ){
    
        $this->cc_addresses[] = $cc_address;
        
        return $this;
        
    }
    
    
    /**
    * Getter for the cc_addresses field on this Message.
    * 
    * @return array
    */
    protected function getCcAddresses(){
    
        return $this->cc_addresses;
        
    }
        
    
    /**
    * Setter for the bcc_addresses field on this Message.
    * 
    * @param array $bcc_addresses
    */
    protected function setBccAddresses( $bcc_addresses ){
    
        $this->bcc_addresses = $bcc_addresses;
        
    }       
     
    
    /**
    * Setter for the bcc_addresses field on this Message.
    * 
    * @param array $bcc_addresses
    */
    protected function addBccAddress( $bcc_address ){
    
        $this->bcc_addresses[] = $bcc_address;
        
    }
    
    
    /**
    * Getter for the bcc_addresses field on this Message.
    * 
    * @return array
    */
    protected function getBccAddresses(){
    
        return $this->bcc_addresses;
        
    }
        
    
    /**
    * Setter for the html_partial field on this Message.
    * 
    * @param string $html_partial
    */
    protected function setHtmlPartial( $html_partial ){
    
        $this->html_partial = $html_partial;
        
    }
    
    
    /**
    * Getter for the html_partial field on this Message.
    * 
    * @return string
    */
    protected function getHtmlPartial(){
    
        return $this->html_partial;
        
    }   
     
    
    /**
    * Getter for the html_partial field on this Message.
    * 
    * @return string
    */
    public function setContent( $partial_name ){
        
        $this->setHtmlPartial( $partial_name . '_html' );
        $this->setTextPartial( $partial_name . '_text' );
        
    }
        
    
    /**
    * Setter for the text_partial field on this Message.
    * 
    * @param string $text_partial
    */
    protected function setTextPartial( $text_partial ){
    
        $this->text_partial = $text_partial;
        
    }
    
    
    /**
    * Getter for the text_partial field on this Message.
    * 
    * @return string
    */
    protected function getTextPartial(){
    
        return $this->text_partial;
        
    }
        
    
    /**
    * Setter for the attachments field on this Message.
    * 
    * @param array $attachments
    */
    protected function addAttachments( $attachments ){
    
        $this->attachments = $attachments;
        
    }
    
    
    /**
    * Getter for the attachments field on this Message.
    * 
    * @return array
    */
    protected function getAttachments(){
    
        return $this->attachments;
        
    }


}
