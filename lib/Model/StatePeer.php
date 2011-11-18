<?php



/**
 * Skeleton subclass for performing query and update operations on the 'state' table.
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

class StatePeer extends \BaseStatePeer {

    
    /**
    * Find a State by name, and optionally filter by country.
    *
    * @param mixed $name
    * @param Country $country
    * @return State
    */
    public static function retrieveByName( $name, $country = null ){
        
        return \StateQuery::create()
            ->filterByName( $name )
            ->_if( !is_null( $country ) )
                ->filterByCountry( !is_null( $country ) ? $country : null )
            ->_endif()
        ->findOne();
        
    }

    
    /**
    * Find a State by iso (or short) code, and optionally filter by country.
    *
    * @param mixed $name
    * @param Country $country
    * @return State
    */
    public static function retrieveByCode( $iso_code, $country = null ){
        
        return \StateQuery::create()
            ->where( 'State.IsoCode LIKE ?', $iso_code )
            ->orWhere( 'State.IsoShortCode LIKE ?', $iso_code )
            ->_if( !is_null( $country ) )
                ->filterByCountry( !is_null( $country ) ? $country : null )
            ->_endif()
        ->findOne();
        
    }
    
    /**
    * Returns a multidimentional array of State where the top level are 
    * Country names and the bottom level are State objects
    * 
    * e.g.
    * 
    * array(
    *   'Canada' => array(
    *     0 => State    // Alberta
    *     1 => State    // British Columbia
    * ...
    * 
    * @param StateQuery $query  // optional StateQuery to filter results
    * @return array
    */
    public static function retrieveStatesGroupByCountry( $query = null ){
        
        if( !is_null($query) ){
            
            \Altumo\Validation\Objects::assertObjectClass( $query, 'StateQuery' );
            
        } else {
            
            $query = StateQuery::create();
            
        }
        
        $result = array();
        
        $all_states = $query
            ->useCountryQuery()
                ->addAscendingOrderByColumn( CountryPeer::NAME )
            ->endUse()
            ->addAscendingOrderByColumn( StatePeer::NAME )
        ->find();
        
        foreach( $all_states as $state ){
            
            $result[$state->getCountry()->getName()][] = $state;
            
        }
        
        return $result;
        
    }
 
    
}
