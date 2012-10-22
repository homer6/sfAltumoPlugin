<?php

/*
 * This file is part of the sfAltumoPlugin library.
 *
 * (c) Steve Sperandeo <steve.sperandeo@altumo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace sfAltumoPlugin\Automation\Robot;

/**
* All Automation robots must implement this interface.
* 
* @author Juan Jaramillo <juan.jaramillo@altumo.com>
*/
interface RobotInterface{


    /**
    * @see \sfAltumoPlugin\Automation\Robot\Base::run
    */
    public function run();
    
    
    /**
    * @see \sfAltumoPlugin\Automation\Robot\Base::create
    */
    public static function create();

    
}