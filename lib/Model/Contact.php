<?php



/**
 * Skeleton subclass for representing a row from the 'contact' table.
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

class Contact extends \BaseContact{
    
    
    /**
    * Gets this contact's full name.
    * 
    */
    public function __toString(){
        
        return $this->getFullName();
        
    }
    
    
    /**
    * Get Mailing Address including city and state in one line.
    * 
    * @return string
    */
    public function getMailingAddressFullOneLine(){
        
        $state = $this->getState();
        
        $address = $this->getMailingAddress() . ', ' . $this->getCity();
        
        if( !is_null($state) ) {
            $address .= ', ' . $state->getName();
        }
        
        return $address;
        
    }        
    
    
    /**
    * Get Mailing Address including city and state in multiple lines using
    * html formatting.
    * 
    * @return string
    */
    public function getMailingAddressFullHtml(){
        
        $state = $this->getState();
        $city = $this->getCity();
        $zip = $this->getZipCode();
        
        $address = $this->getMailingAddress();
        
        if( strlen($city) ){
            $address .= '<br />' . $city;
        }        
        
        if( !is_null($state) ){
            $address .= (strlen($city)?', ':'') . $state->getName();
            $address .= '<br />' . $state->getCountry()->getName();
        }
        
        if( strlen($zip) ){
            $address .= (strlen($address)?' - ':'') . $zip;
        }

        return $address;
        
    }    
    

    /**
    * Sets this contact's state by state ISO code.
    * 
    * @param string $iso_code
    * @throws \Exception                    //if ISO code does not exist
    * @throws \Exception                    //if ISO code is not a non-empty 
    *                                         string
    */
    public function setStateIsoCode( $iso_code ){
        
        $iso_code = \Altumo\Validation\Strings::assertNonEmptyString($iso_code);
        $iso_code = strtoupper($iso_code);
        
        $state = \StatePeer::retrieveByCode($iso_code);
        if( !$state ){
            throw new \Exception( 'Unknown ISO code: ' . $iso_code );
        }
        $this->setState($state);
        
    }
    
    
    /**
    * Get state full name (e.g. British Columbia). Returns null if state is not
    * set.
    * 
    * @return string
    */
    public function getStateName(){
        
        if( $state = $this->getState() ){
            return $state->getName();
        }
        
        return null;
        
    }
    
        
    /**
    * Return the states' ISO code (e.g. CA-BC), else null if state is not set.
    * 
    * @return string
    */
    public function getStateIsoCode(){
        
        if( $state = $this->getState() ){
            return $state->getIsoCode();
        }
        
        return null;
        
    }
    
    
    /**
    * Return the states' ISO code (e.g. BC), else null if state is not set.
    * 
    * @return string
    */
    public function getStateIsoShortCode(){
        
        if( $state = $this->getState() ){
            return $state->getIsoShortCode();
        }
        
        return null;
        
    }    
    
    
    /**
    * Return the country's name (e.g. Canada), else null if state is not set.
    * 
    * @return string
    */
    public function getCountryName(){
        
        if( $state = $this->getState() ){
            return $state->getCountry()->getName();
        }
        
        return null;
        
    }    
    
    
    /**
    * Get Country
    * 
    * @return Country
    */
    public function getCountry(){
        
        if( $state = $this->getState() ){
            return $state->getCountry();
        }
        
        return null;
                
    }
    
    
    /**
    * Get Country short iso code.
    * 
    * @return string
    */
    public function getCountryIsoShortCode(){
        
        $country = $this->getCountry();
        
        if( !is_null( $country ) ){
            return $country->getIsoShortCode();
        }
        
        return null;
        
    }

    
    /**
    * Returns the person's full name in the format specified.
    * 
    * E.g. Reginald Smith
    * %1$s = First ( Reginald )
    * %2$s = Last ( Smith )
    * %3$s = First initial ( R )
    * %4$s = Last Initial ( S )
    * 
    * @param string $format
    * @return string
    */
    public function getFullName( $format = '%1$s %2$s' ){
        
        $first_name = $this->getFirstName();
        $last_name = $this->getLastName();
        
        return sprintf( $format, $first_name, $last_name, $first_name[0], $last_name[0] );
        
    }
        
    
    /**
    * Set Full Name. This will attempt to parse the full name into first 
    * and last name.
    * 
    * // TODO: Modify this to use \Altumo\Utils\PersonName
    * 
    * @param string $full_name
    */
    public function setFullName( $full_name ){
        
        if( empty( $full_name ) ){
            $this->setFirstName( null );
            $this->setLastName( null );
        }
        
        $parsed_full_name = self::parsePersonFullName( $full_name );
        
        if( strlen( $parsed_full_name['first_name'] ) > 0 ){
            
            $this->setFirstName( $parsed_full_name['first_name'] . ( empty( $parsed_full_name['middle_name'] ) ? '' : ' ' ) . $parsed_full_name['middle_name'] );
            
        }
        
        if( strlen( $parsed_full_name['last_name'] ) > 0 ){
            
            $this->setLastName( $parsed_full_name['last_name'] );
            
        }
        
    }
    
    
    /**
    * Parses the Person's name and attempts to extract First, Middle and/or 
    * Last name.
    * 
    * // TODO: Make this use \Altumo\Utils\PersonName
    * 
    * 
    * @param string $full_name 
    *   // the full name to parse
    * 
    * @param string $get_part 
    *   // (first_name|middle_name|last_name|null) if null, an array of parts 
    *       will be returned.
    * 
    * @throws \Exception                    
    *   // if $get_part is invalid
    * 
    * 
    * @return string|array
    */
    protected static function parsePersonFullName( $full_name, $get_part = null ){

        // Validate Input
            if( !is_null($get_part) ){
                $valid_parts = array( 'first_name', 'middle_name', 'last_name' );
                if( !in_array($get_part, $valid_parts) ){
                    throw new \Exception( 'parsePersonFullName expects get_part to be one of: ' . implode( ', ', $valid_parts)  );
                }
            }

        // Split full name on spaces
            $name_parts = explode( ' ', trim( $full_name ) );


        // Parse name parts
            switch( count( $name_parts ) ){

                case 0:
                    return null;
                    break;

                case 1:
                    $parsed_name = array(
                        'first_name' => $name_parts[0],
                        'middle_name' => '',
                        'last_name' => ''
                    );
                    break;

                case 2:
                    $parsed_name = array(
                        'first_name' => $name_parts[0],
                        'middle_name' => '',
                        'last_name' => $name_parts[1]
                    );
                    break;

                case 3:
                    $parsed_name = array(
                        'first_name' => $name_parts[0],
                        'middle_name' => $name_parts[1],
                        'last_name' => $name_parts[2]
                    );
                    break;

                default:
                    $parsed_name = array(
                        'first_name' => $name_parts[0],
                        'middle_name' => $name_parts[1],
                        'last_name' => implode( ' ', array_slice( $name_parts, 2 ) )
                    );
            }
        
        if( !is_null( $get_part ) ){
            return $parsed_name[$get_part];
        } else {
            return $parsed_name;
        }
        
    }
    

} 
