<?php
/*
 * This file is part of the sfAltumoPlugin library.
 *
 * (c) Steve Sperandeo <steve.sperandeo@altumo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace sfAltumoPlugin\Utils;


/**
* Generates unique public primary keys for Propel Model Objects.
* 
* ** adapted from old code - ongoing refactoring **
* 
* @author Juan Jaramillo <juan.jaramillo@altumo.com>
*/
class publicPrimaryKeyMaker {
    
    const KEY_FIELD_NAME = 'PublicPrimaryKey';
    const KEY_LENGTH = 8;
    const KEY_CHARACTER_POOL = 'ABCDEFGHJKLMNPQRTUVWXY123456789';
    
    /**
    * Make and assign a Public Primary Key for Object (if it does not have one already)
    *  * Object must implement getPublicPrimaryKey() and setPublicPrimaryKey()
    *  * Object Peer must implement retrieveByPublicPrimaryKey()
    * 
    * @param mixed $object
    * @param mixed $ppk_field The field name to use (default = PublicPrimaryKey)
    * @param $key_length the integer string length to be generated.
    * @param $key_char_pool a non-delimited string containing the pool of characters to pick from.
    * @return null
    */
    public static function processObject( $object, $ppk_field = self::KEY_FIELD_NAME, $key_length = self::KEY_LENGTH, $key_char_pool = self::KEY_CHARACTER_POOL ){
        
        if( !is_object( $object ) ){
            throw new Exception( 'Cannot make PPK for non-object' );
        }
        
        if( self::getPublicPrimaryKeyValue( $object, $ppk_field )  == null ){
            self::setPublicPrimaryKeyValue( $object, $ppk_field, self::getUniqueKey( $object, $ppk_field, $key_length, $key_char_pool ) );
        }
        
    }
    
    /**
    * Get the current value of the obect's public primary key.
    * @param Object $object
    * @param string $ppk_field
    * @return string
    */
    private static function getPublicPrimaryKeyValue( $object, $ppk_field ){
        return eval( 'return $object->get' . $ppk_field . '();' );
    }    
    
    /**
    * Sets the value of the obect's public primary key.
    * 
    * @param Object $object
    * @param string $ppk_field
    * @param string $value
    */
    private static function setPublicPrimaryKeyValue( $object, $ppk_field, $value ){
        return eval( 'return $object->set' . $ppk_field . '($value);' );
    }
    
    
    /**
    * This is a simple system to generate unique keys. It will need to be improved in the future for better performance.
    * 
    * @param Object $object - must have a getPeer method.
    */
    private static function getUniqueKey( $object, $ppk_field = self::KEY_FIELD_NAME, $key_length = self::KEY_LENGTH, $key_char_pool = self::KEY_CHARACTER_POOL  ){
        
        $object_peer =  self::getObjectPeer( $object );
        
        if( is_null( $object_peer ) ){
            throw new \Exception( "Object must have a Peer class." );
        }

        $tries = 0;
        while( self::primaryKeyValueExists( ($new_id = \Altumo\String\String::generateRandomString( $key_length, $key_char_pool )), $object_peer, $ppk_field ) ){
            if( $tries++ > 30 ){
                throw new \Exception( "Tried to generate a unique value for {$ppk_field} {$tries} times and failed." ); 
            }
        }
        
        return $new_id;

    }
    
    private static function getObjectPeer( $object ){
        return eval( 'return $object->getPeer();' ); 
    }
    
    private static function primaryKeyValueExists( $primary_key_value, $object_peer, $ppk_field ){
        
        if( !is_callable( $callable = array( $object_peer, "retrieveBy{$ppk_field}" ) ) ){
            throw new \Exception( "Object Peer must implement retrieveBy{$ppk_field}" ); 
        }

        $existing_object = call_user_func( $callable, $ppk_field );

        return $existing_object;
        
    }
}
