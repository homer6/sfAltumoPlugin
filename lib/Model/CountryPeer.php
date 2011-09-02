<?php



/**
 * Skeleton subclass for performing query and update operations on the 'country' table.
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

class CountryPeer extends \BaseCountryPeer {

    
    /**
    * Get All Countries
    *
    * @return PropelCollection
    */
    public static function getCountries(){

        return \CountryQuery::create()
        ->find();

    }
    
    
    /**
    * Retrieve a country by ISO code (long or short)
    * 
    * @param mixed $country_code
    * @return Country
    */
    public static function retrieveByCountryCode( $country_iso_code ){
        
        // If it's a long-code search
            if( strlen( $country_iso_code ) == 3 ){
                
                return \CountryQuery::create()
                    ->filterByIsoCode( $country_iso_code )
                ->findOne();
                
        // Short code
            } elseif ( strlen( $country_iso_code ) == 2 ){
                
                return \CountryQuery::create()
                    ->filterByIsoShortCode( $country_iso_code )
                ->findOne();
                
            }

        
    }
        

}
