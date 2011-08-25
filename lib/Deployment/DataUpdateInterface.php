<?php

/*
 * This file is part of the sfAltumoPlugin library.
 *
 * (c) Steve Sperandeo <steve.sperandeo@altumo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace sfAltumoPlugin\Deployment;
 

/**
* This is the interface that all DataUpdate implement.
* 
* @see sfAltumoPlugin\Deployment\DataUpdate
* 
* @author Juan Jaramillo <juan.jaramillo@altumo.com>
*/
interface DataUpdateInterface{
 
    
    public function __construct();
    
    public function run();
    
}
