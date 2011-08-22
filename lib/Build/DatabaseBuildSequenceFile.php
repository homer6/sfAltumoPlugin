<?php

/*
 * This file is part of the Altumo library.
 *
 * (c) Steve Sperandeo <steve.sperandeo@altumo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace sfAltumoPlugin\Build;


/**
* An instance of this class represents the xml log file that is used to perform
* database builds. This log records all of the build operations that exist in
* the application.
* 
* @author Steve Sperandeo <steve.sperandeo@altumo.com>
*/
class DatabaseBuildSequenceFile extends \Altumo\Xml\XmlFile{
 
    
    /**
    * Constructor for this \Altumo\Xml\XmlFile.
    * 
    * @param string $filename //full path of the filename
    * @param boolean $readonly //whether this \Altumo\Xml\XmlFile is going to be used as a readonly object (doesn't write to xml file)
    * @throws \Exception if file or directory is not writable
    * @return \Altumo\Xml\XmlFile
    */
    public function __construct( $filename, $readonly = true ){    
    
        parent::__construct( $filename, $readonly );
     
    }
    
    
    /**
    * Gets the default empty file as an xml string.
    * 
    * @return string
    */
    protected function getDefaultEmptyFile(){
        
        return '<BuildSequence/>';
        
    }
    
    
    /**
    * Adds a build sequence change.
    * 
    * 
    * @param string $hash
    * @param boolean $upgrade
    * @param boolean $data_update
    * @param boolean $drop
    * @param boolean $snapshot
    * @param boolean $altumo
    * 
    * @throws \Exception if file is not open
    * @throws \Exception if file is not writable
    */    
    public function addChange( $hash, $upgrade = null, $data_update = null, $drop = null, $snapshot = null, $altumo = null ){
        
        $this->assertFileOpen();
        $this->assertFileWritable();
        
        $xml_root = $this->getXmlRoot();
            $change = $xml_root->addChild('Change');
            
                $change->addAttribute( 'hash', $hash );
                            
                if( !is_null($upgrade) ){
                    if( $upgrade ){
                        $change->addAttribute( 'upgrade', 'true' );
                    }else{
                        $change->addAttribute( 'upgrade', 'false' );
                    }
                }       
                                     
                if( !is_null($data_update) ){
                    if( $data_update ){
                        $change->addAttribute( 'data_update', 'true' );
                    }else{
                        $change->addAttribute( 'data_update', 'false' );
                    }
                }
            
                if( !is_null($drop) ){
                    if( $drop ){
                        $change->addAttribute( 'drop', 'true' );
                    }else{
                        $change->addAttribute( 'drop', 'false' );
                    }
                }
            
                if( !is_null($snapshot) ){
                    if( $snapshot ){
                        $change->addAttribute( 'snapshot', 'true' );
                    }else{
                        $change->addAttribute( 'snapshot', 'false' );
                    }
                }
            
                if( !is_null($altumo) ){
                    if( $altumo ){
                        $change->addAttribute( 'altumo', 'true' );
                    }else{
                        $change->addAttribute( 'altumo', 'false' );
                    }
                }        
        
    }
    
    
    /**
    * Gets the hash of the latest delta
    * 
    * @return string
    */
    public function getLastestHash(){
        
        $this->assertFileOpen();
        return $this->getXmlRoot()->xpath( 'Change[last()]/attribute::hash', false );
        
    }
    
    
    /**
    * Gets the hash of the latest snapshot
    * 
    * @return string
    */
    public function getLastestSnapshotHash(){
        
        $this->assertFileOpen();
        return $this->getXmlRoot()->xpath( 'Change[@snapshot="true"][last()]/attribute::hash', false );
        
    }
    
    
    /**
    * Gets an array of commit hashes (that was an altumo plugin delta) 
    * since (but not including) the supplied commit hash.
    * 
    * @param string $since_hash             //if empty, will return all altumo
    *                                         hashes         
    * @return array
    */
    public function getAltumoHashesSince( $since_hash = '' ){
        
        return $this->getHashesSince( $since_hash, 'altumo' );
        
    }
    
    
    
    /**
    * Gets a single upgrade hash string.
    * 
    * @return string
    */
    public function getFirstUpgrade(){
        
        $result = $this->getXmlRoot()->xpath( 'Change[@upgrade="true"][1]/attribute::hash', false );
        if( is_null($result) ){
            throw new \Exception( 'This build sequence does not contain an upgrade script.' );
        }
        return $result;
        
    }
    
    
    /**
    * Gets an array of commit hashes (that an upgrade script was present in) 
    * since (but not including) the supplied commit hash.
    * 
    * @param string $since_hash
    * @return array
    */
    public function getUpgradeHashesSince( $since_hash ){
        
        return $this->getHashesSince( $since_hash, 'upgrade' );
        
    }    
    
    
    /**
    * Gets an array of commit hashes (that a data update script was present in) 
    * since (but not including) the supplied commit hash.
    * 
    * @param string $since_hash
    * @return array
    */
    public function getDataUpdateHashesSince( $since_hash ){
        
        return $this->getHashesSince( $since_hash, 'data_update' );
        
    }
        
    
    /**
    * Gets an array of commit hashes (that a php or sql upgrade script was present in) 
    * since (but not including) the supplied commit hash.
    * 
    * @param string $since_hash
    * @return array
    */
    public function getPhpOrSqlUpgradeHashesSince( $since_hash ){
        
        return $this->getHashesSince( $since_hash, array( 'upgrade', 'data_update' ) );
        
    }
    
    
    /**
    * Gets an array of commit hashes (that an snapshot script was present in) 
    * since (but not including) the supplied commit hash.
    * 
    * @param string $since_hash
    * @return array
    */
    public function getSnapshotHashesSince( $since_hash ){
        
        return $this->getHashesSince( $since_hash, 'snapshot' );
        
    }
    
    
    /**
    * Gets an array of commit hashes (that a drop script was present in) since
    * (but not including) the supplied commit hash.
    * 
    * @param string $since_hash
    * @return array
    */
    public function getDropHashesSince( $since_hash ){
        
        return $this->getHashesSince( $since_hash, 'drop' );
        
    }
    
    
    /**
    * Gets an array of commit hashes (that an upgrade script was present in) 
    * before (AND including the current hash) the supplied commit hash.
    * 
    * @param string $before_hash
    * @return array
    */
    public function getUpgradeHashesBefore( $before_hash ){
        
        return $this->getHashesBefore( $before_hash, 'upgrade' );
        
    }
    
    
    /**
    * Gets an array of commit hashes (that a snapshot script was present in) 
    * before (AND including the current hash) the supplied commit hash.
    * 
    * @param string $before_hash
    * @return array
    */
    public function getSnapshotHashesBefore( $before_hash ){
        
        return $this->getHashesBefore( $before_hash, 'snapshot' );
        
    }
    
    
    /**
    * Gets an array of commit hashes (that a drop script was present in) before
    * (AND including the current hash) the supplied commit hash.
    * 
    * @param string $before_hash
    * @return array
    */
    public function getDropHashesBefore( $before_hash ){
        
        return $this->getHashesBefore( $before_hash, 'drop' );
        
    }
    
    
    
    /**
    * Gets an array of commit hashes (that an $attribute script was present in) 
    * since (but not including) the supplied commit hash.
    * 
    * @param string $since_hash
    *   // The hash to start from, cronologically
    * 
    * @param string|array $attributes
    *   // A single attribute or an array of attributes to match to "true"
    * 
    * @param string $match_all_attributes
    *   // Whether to require all attributes to be "true" or to match based
    *   // on at least one attribute. (when using an array of more than 2 attributes)
    * 
    * 
    * @throws \Exception 
    *   //if build sequence attribute isn't recognized
    * 
    * @throws \Exception 
    *   //if file is not open
    * 
    * 
    * @return array
    */
    protected function getHashesSince( $since_hash, $attributes, $match_all_attributes ){
        
        $this->assertFileOpen();
        
        if( !is_array( $attributes ) ){
            $attributes = array( $attributes );
        }
        
        
        if( $match_all_attributes ){
            $attribute_operator = 'and';
        } else {
            $attribute_operator = 'or';
        }

        
        foreach( $attributes as $attribute ){
            if( !in_array($attribute, $this->getValidAttributes()) ){
                throw new \Exception( sprintf('Invalid build sequence attribute "%s".', $attribute) );
            }
        }
        
        //if the "since" hash was not found, set the hash position to so that it will match all entries
            if( count( $this->getXmlRoot()->queryWithXpath( 'Change[@hash="' . $since_hash . '"]', \Altumo\Xml\XmlElement::RETURN_TYPE_STRING, false ) ) == 0 ){
                $hash_position = 0;
            }else{
                //get the position of the since_hash
                $hash_position = count( $this->getXmlRoot()->queryWithXpath( 'Change[@hash="' . $since_hash . '"]/preceding-sibling::*', \Altumo\Xml\XmlElement::RETURN_TYPE_STRING, false ) ) + 1;
            }
        
            $attribute_selector = '';
            foreach( $attributes as $attribute ){
                $attribute_selector[] = '@' . $attribute . '="true"';
            }
            
            $attribute_selector = implode( ' ' . $attribute_operator . ' ', $attribute_selector );
            

        
        //get the changes
        $changes = $this->getXmlRoot()->queryWithXpath( 'Change[position() > ' . $hash_position . '][' . $attribute_selector . ']/attribute::hash', \Altumo\Xml\XmlElement::RETURN_TYPE_STRING, false );        
        
        return $changes;
        
    }
    
    
    /**
    * Gets an array of the valid XML attributes a "Change" element may have.
    * 
    * @return array
    */
    protected function getValidAttributes(){
        
        return array( 'upgrade', 'data_update', 'drop', 'snapshot', 'altumo' );
        
    }
    
    
    /**
    * Gets an array of commit hashes (that an $attribute script was present in) 
    * before (AND including) the supplied commit hash.
    * 
    * @param string $before_hash
    * @param string $attribute
    * 
    * @throws \Exception //if build sequence attribute isn't recognized
    * @return array
    */
    protected function getHashesBefore( $before_hash, $attribute ){
        
        $this->assertFileOpen();
        
        if( !in_array($attribute, $this->getValidAttributes()) ){
            throw new \Exception( 'Invalid build sequence attribute.' );
        }
        
        //if the "since" hash was not found, set the hash position to so that it will match all entries
        if( count( $this->getXmlRoot()->queryWithXpath( 'Change[@hash="' . $before_hash . '"]', \Altumo\Xml\XmlElement::RETURN_TYPE_STRING, false ) ) == 0 ){
            $hash_position = count( $this->getXmlRoot()->queryWithXpath( 'Change', \Altumo\Xml\XmlElement::RETURN_TYPE_STRING, false ) );
        }else{
            //get the position of the before_hash
            $hash_position = count( $this->getXmlRoot()->queryWithXpath( 'Change[@hash="' . $before_hash . '"]/preceding-sibling::*', \Altumo\Xml\XmlElement::RETURN_TYPE_STRING, false ) ) + 1;
        }
        
        //get the changes
        $changes = $this->getXmlRoot()->queryWithXpath( 'Change[position() <= ' . $hash_position . '][@' . $attribute . '="true"]/attribute::hash', \Altumo\Xml\XmlElement::RETURN_TYPE_STRING, false );        
        
        return $changes;
        
    }
    
    
    /**
    * Returns true if $hash has an upgrade_script.
    * 
    * 
    * @param string $hash
    * 
    * 
    * @return bool
    */
    public function isUpgradeHash( $hash ){

        return $this->hashHasTrueAttribute( $hash, 'upgrade' );
        
    }
 

    /**
    * Returns true if $hash has a data_update
    * 
    * 
    * @param string $hash
    * 
    * 
    * @return bool
    */
    public function isDataUpdateHash( $hash ){

        return $this->hashHasTrueAttribute( $hash, 'data_update' );
        
    }
    
    
    /**
    * Returns true if $hash has the given $attribute
    * 
    * 
    * @param string $hash
    *   // hash to evaluate
    * 
    * @param mixed $attribute
    *   // attribute to match to "true"
    */
    protected function hashHasTrueAttribute( $hash, $attribute ){
        
        $this->assertFileOpen();
        
        if( !in_array($attribute, $this->getValidAttributes()) ){
            throw new \Exception( 'Invalid build sequence attribute.' );
        }
        
        $has_attribute = count( $this->getXmlRoot()->queryWithXpath( 'Change[@hash="' . $hash . '" and @' . $attribute . '="true"]', \Altumo\Xml\XmlElement::RETURN_TYPE_STRING, false ) ) == 1;

        return $has_attribute;
    }

    
}
