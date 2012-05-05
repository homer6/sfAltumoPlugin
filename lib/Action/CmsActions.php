<?php

/*
 * This file is part of the sfAltumoPlugin library.
 *
 * (c) Steve Sperandeo <steve.sperandeo@altumo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace sfAltumoPlugin\Action;



/**
* This class adds miscellaneous generic functions to sfActions. It is meant to be
* extended by a module's actions.
*
* @author Juan Jaramillo <juan.jaramillo@altumo.com>
*/
class CmsActions extends BaseActions {
    
    protected $cms_buffer_count = 0;
    protected $current_cms_fragment = null;

    
    public function preExecute(){

        $this->addCmsFunctions();
        
    }

    
    protected function userCanEditCmsFragments(){
        
        return $this->getUser()->isAuthenticated();
        
    }
    
    
    protected function addCmsFunctions(){

        $user_can_edit_cms_fragments = $this->userCanEditCmsFragments();
        
        $that = $this;

        $this->cms_start_fragment = function( $tag, $chrome_attributes = '' ) use ( $that ){
            
            return $that->startCmsFragment( $tag, $chrome_attributes );
            
        };        
        
        $this->cms_end_fragment = function() use ( $that ){
            
            return $that->endCmsFragment();
            
        };

    }


    public function startCmsFragment( $tag, $chrome_attributes = '' ){

        $chrome_attributes = \Altumo\Validation\Strings::assertString(
            $chrome_attributes,
            '$chrome_attributes expects a string'
        );

        // prevent nested fragments
            if( $this->hasCurrentCmsFragment() ){
                throw new \Exception( 'Already inside "' . $this->getCurrentCmsFragment()->getTag() . '". Cannot start another fragment.' );
            }

        // retrieve fragment                                             
            $fragment = \CmsFragmentPeer::retrieveByTag( $tag );

        // if this is a new segment, create a new one.
            if( is_null($fragment) ){
                $fragment = \CmsFragmentPeer::getStubCmsFragment( $tag );
            }

        // set chrome attributes
            $fragment->setChromeAttributes( $chrome_attributes );
            
        // set current fragment
            $this->setCurrentCmsFragment( $fragment );

        // start output buffering
            ob_start();
            $this->cms_buffer_count++;

    }
    

    public function endCmsFragment(){
        
        if( !$this->hasCurrentCmsFragment() ){
            throw new Exception( 'Not currently inside of a fragment.' );
        }
        
        // end output buffering
            $buffer_contents = ob_get_contents();
            ob_end_clean();
            $this->cms_buffer_count--;
            
        // if this is a new fragment, save buffered content in it
            $current_fragment = $this->getCurrentCmsFragment();
            
            if( $current_fragment->isNew() ){   
                $current_fragment->setContent( $buffer_contents );
                $current_fragment->save();
            }

        // output the content of the fragment
            echo $current_fragment->getHtml();
            
        // end current fragment
            $this->setCurrentCmsFragment( null );

    }
    
    
    protected function hasCurrentCmsFragment(){
        
        return null !== $this->getCurrentCmsFragment();
    
    }
    
    
    protected function setCurrentCmsFragment( $cms_fragment ){
        
        $cms_fragment = \Altumo\Validation\Objects::assertObjectInstanceOfClassOrNull(
            $cms_fragment,
            'CmsFragment',
            '$cms_fragment expects CmsFragment or null'
        );
        
        $this->current_fragment = $cms_fragment;
        
    }    
    
    
    /**
    * Gets the CmsFragment that is currently being printed.
    * 
    * @return CmsFragment
    */
    protected function getCurrentCmsFragment(){
        
        return $this->current_fragment;
        
    }

}