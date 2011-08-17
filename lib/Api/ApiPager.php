<?php

/*
 * This file is part of the sfAltumoPlugin library.
 *
 * (c) Steve Sperandeo <steve.sperandeo@altumo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace sfAltumoPlugin\Api;



/**
* This class represents the collection of information 
* necessary to support paged result sets.
*
* @author Steve Sperandeo <steve.sperandeo@altumo.com>
*/
class ApiPager{
        
    protected $paged = null;
    protected $limit = null;
    protected $page_size = null;
    protected $page_number = null;
    protected $total_results = null;

    
    /**
    * Constructor for this ApiPager.
    * 
    * @param boolean $paged                 //determines if this result is going
    *                                         to be wrapped around a result set 
    *                                       //set this to true for queries
    * @param \sfAltumoPlugin\Api\ApiRequest $request
    * 
    * @return \sfAltumoPlugin\Api\ApiPager
    */
    public function __construct( $paged = false, $request = null ){
    
        
        if( is_null($request) ){
            
            $this->setPaged( $paged );
            $this->setPageSize( 30 );
            $this->setPageNumber( 1 );
     
        }else{
            
            $page_size = $request->getParameter( 'page_size', 30 );
            $page_number = $request->getParameter( 'page', 1 );
            
            $this->setPaged( $paged );
            $this->setPageSize( $page_size );
            $this->setPageNumber( $page_number );
            
        }
        

    }        
    
    
    /**
    * Setter for the paged field on this ApiPager.
    * 
    * @param boolean $paged
    */
    public function setPaged( $paged ){
    
        $this->paged = $paged;
        
    }
    
    
    /**
    * Getter for the paged field on this ApiPager.
    * 
    * @return boolean
    */
    public function getPaged(){
    
        return $this->paged;
        
    }
    
    
    /**
    * Determines if this ApiPager is paged.
    * 
    * @return boolean
    */
    public function isPaged(){
    
        return $this->paged;
        
    }
    
    
    /**
    * Setter for the page_size field on this ApiPager.
    * If this page size is over 100, it limits it to 100.
    * 
    * @param integer $page_size
    */
    public function setPageSize( $page_size ){
    
        try{
            $page_size = \Altumo\Validation\Numerics::assertUnsignedInteger($page_size);
        }catch( \Exception $e ){
            $page_size = 30;
        }
        if( $page_size > 100 ){
            $page_size = 100;
        }
        
        $this->page_size = $page_size;
        
    }
    
    
    /**
    * Getter for the page_size field on this ApiPager.
    * 
    * @return integer
    */
    public function getPageSize(){
    
        return $this->page_size;
        
    }
        
    
    /**
    * Setter for the page_number field on this ApiPager.
    * 
    * @param integer $page_number
    */
    public function setPageNumber( $page_number ){
    
        try{
            $page_number = \Altumo\Validation\Numerics::assertPositiveInteger($page_number);
        }catch( \Exception $e ){
            $page_number = 1;
        }
        $this->page_number = $page_number;
        
    }
    
    
    /**
    * Getter for the page_number field on this ApiPager.
    * 
    * @return integer
    */
    public function getPageNumber(){
    
        return $this->page_number;
        
    }
        
        
    /**
    * Setter for the total_results field on this ApiPager.
    * 
    * @param integer $total_results
    * @throws Exception if $total_results is not an unsigned integer
    */
    public function setTotalResults( $total_results ){
            
        $this->total_results = \Altumo\Validation\Numerics::assertUnsignedInteger($total_results);
        
    }
    
    
    /**
    * Getter for the total_results field on this ApiPager.
    * 
    * @return integer
    */
    public function getTotalResults(){
    
        return $this->total_results;
        
    }
    
    
    /**
    * Determines if this result has many pages.
    * 
    * @return boolean
    */
    public function hasManyPages(){
    
        if( $this->getTotalResults() > $this->getPageSize() ){
            return true;
        }else{
            return false;
        }
        
    }


    /**
    * Gets this pager as an array.
    * 
    * @return array
    */
    public function getAsArray(){
    
        return array(
            'paged' => $this->getPaged(),
            'page_size' => $this->getPageSize(),
            'page_number' => $this->getPageNumber()
        );
    
    }
    
    
    /**
    * Adds the constraints assigned in this pager to this query.
    * 
    * @param ModelCriteria $query
    */
    public function decorateQuery( $query ){
        
        $query->setLimit( $this->getPageSize() );
        $query->setOffset( ( $this->getPageNumber() - 1 ) * $this->getPageSize() );
        
    }
    
    
}