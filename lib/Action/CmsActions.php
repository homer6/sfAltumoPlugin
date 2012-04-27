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

    
    public function preExecute(){

        $this->addCmsFunctions();
        
    }
    
    
    protected function userCanEditCmsFragments(){
        
        return $this->getUser()->isAuthenticated();
        
    }
    
    
    protected function addCmsFunctions(){

        $user_can_edit_cms_fragments = $this->userCanEditCmsFragments();
        
        $this->cms_fragment = function( $tag, $chrome_attributes = '' ){
            
            $chrome_attributes = \Altumo\Validation\Strings::assertString(
                $chrome_attributes,
                '$chrome_attributes expects a string'
            );
            
            $fragment = \CmsFragmentPeer::retrieveByTag( $tag );
            
            if( is_null($fragment) ){
                $fragment = \CmsFragmentPeer::getStubCmsFragment( $tag );
            }

            return $fragment->getHtml( $chrome_attributes );

        };

        
    }


    /**
    * Enables the Cms editor.
    */
    public function enableCmsEditor(){
        
        $this->getResponse()->addJavascript( '//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js' );
        $this->getResponse()->addJavascript( '/sfAltumoPlugin/js/lib/vendor/altEdit/jquery-altEdit.js' );
        
        $this->getResponse()->addStylesheet( '/sfAltumoPlugin/js/lib/vendor/altEdit/css/altEdit.css' );
        
    }

}