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
 * @package    propel.generator.plugins.sfAltumoPlugin.lib.model
 */
class StatePeer extends BaseStatePeer {
    
    /**
    * Find a State by name, and optionally filter by country.
    * 
    * @param mixed $name
    * @param Country $country
    * @return State
    */
    public static function retrieveByName( $name, $country = null ){
        return StateQuery::create()
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
        return StateQuery::create()
            ->where( 'State.IsoCode LIKE ?', $iso_code )
            ->orWhere( 'State.IsoShortCode LIKE ?', $iso_code )
            ->_if( !is_null( $country ) )
                ->filterByCountry( !is_null( $country ) ? $country : null )
            ->_endif()
        ->findOne();
    }
    
} // StatePeer
