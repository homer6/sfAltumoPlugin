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
 * This class adds CMS functionallity to BaseActions.
 *
 * @author Juan Jaramillo <juan.jaramillo@altumo.com>
 */
class CmsActions extends BaseActions {

    protected $cms_buffer_count = 0;
    protected $current_cms_fragment = null;


    /**
     * Executes before anything else.
     */
    public function preExecute(){

        $this->addCmsFunctions();

    }


    /**
     * Enables the Cms editor.
     * Adds Javascript/Stylesheets to the response.
     *
     * @param $skip_jquery
     *  // optionally skip adding jquery if you're loading it from elsewhere.
     *
     *
     * @return void
     */
    public function enableCmsEditor( $skip_jquery = false ){

        if( !$skip_jquery ){
            $this->getResponse()->addJavascript( '//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js' );
        }

        $this->getResponse()->addJavascript( '/js/lib/vendor/cmsThis/jquery-cmsThis.js' );

        $this->getResponse()->addStylesheet( '/js/lib/vendor/cmsThis/css/cmsThis.css' );

    }


    /**
     * Makes a couple of dynamic functions available to the template for quick access to CMS fragments.
     * The functions are:
     *
     *  $cms_start_fragment
     *      // starts keeping track of a fragment.
     *
     *  $cms_end_fragment
     *     // stops keeping track of a fragment.
     *
     * You would normally put a start and an end around content that you want to make editable.
     *
     * @return void
     */
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


    /**
     * Starts a CMS fragment by using output buffering. It will also create a new model and save it if it doesn't exist.
     *
     * @param $tag
     *  // tag is a unique identifier for a given fragment
     *
     * @param string $chrome_attributes
     *  // attributes of the element that wraps the fragment. This will just be added to the element's definition.
     *
     * @throws \Exception
     *
     * @return void
     */
    public function startCmsFragment( $tag, $chrome_attributes = '', $fragment_type = 'text' ){

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
            $fragment = \CmsFragmentPeer::getStubCmsFragment( $tag, $fragment_type );
        }

        // set chrome attributes
        $fragment->setChromeAttributes( $chrome_attributes );

        // set current fragment
        $this->setCurrentCmsFragment( $fragment );

        // start output buffering
        ob_start();
        $this->cms_buffer_count++;

    }


    /**
     * Ends a CMS fragment.
     *
     * @throws Exception
     *
     * @return void
     */
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


    /**
     * Returns true if we're currently inside of a CMS fragment (e.g. have called startCmsFragment)
     *
     * @return bool
     */
    protected function hasCurrentCmsFragment(){

        return null !== $this->getCurrentCmsFragment();

    }


    /**
     * Setter for the current_fragment attribute.
     *
     * @param $cms_fragment
     */
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