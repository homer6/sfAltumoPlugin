<?php

/*
* This file is part of the sfAltumoPlugin library.
*
* (c) Steve Sperandeo <steve.sperandeo@altumo.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace sfAltumoPlugin\Dom;


/**
* This class extends lib/vendor/QueryPath (@see \QueryPath) to improve a few design umplessantries.
* 
* The primary one being the standalone qp* functions, which don't trigger
* the autoloader. This also puts QueryPath within a namespace for uniformity.
* 
* @author Juan Jaramillo <juan.jaramillo@altumo.com>
*/
class QueryPath extends \QueryPath {
    
    /**
    * Creates a new QueryPath from an HTML string.
    * this function is equivalent to the standalone htmlqp() provided by QueryPath,
    * 
    * @param string $html
    *   // some HTML string
    * 
    * @param array $options
    *   // options to pass to QueryPath (@see \QueryPath)
    * 
    * @return \sfAltumoPlugin\Dom\QueryPath
    */
    public static function createFromHtml( $document = NULL, $options = array() ) {

        $options += array(
            'ignore_parser_warnings' => TRUE,
            'convert_to_encoding' => 'ISO-8859-1',
            'convert_from_encoding' => 'auto',
            //'replace_entities' => TRUE,
            'use_parser' => 'html',
            // This is stripping actually necessary low ASCII.
            //'strip_low_ascii' => TRUE,
        );

        return new self($document, null, $options);

    }

    
    /**
    * Appends an HTML fragment to this element. It assumes that the $html may
    * not be well formed and ignores any parse errors when possible.
    * 
    * @param string $html
    * @return QueryPath
    */
    public function appendHtml( $html ) {

        $new_fragment_element = self::createFromHtml( $html );
        $new_html = $new_fragment_element->find( 'body' )->innerHTML();
        
        // if only text was provided, then just append input as text
        if( is_null($new_html) ){
            $this->text( $html );
        } else {
            $this->append( $new_html );
        }

        return $this;
            
    }

}