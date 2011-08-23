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
* An instance of this class represents a set of php operations that get executed
* during the database update process.
* 
* DataUpdate::run() is executed after any applicable SQL scripts for the 
* hash are executed. For example, if a given hash has an SQL upgrade script, the
* SQL will be applied to the database first and then the data update code is 
* executed.
* 
* @author Juan Jaramillo <juan.jaramillo@altumo.com>
*/
class BaseDataUpdate implements \sfAltumoPlugin\Deployment\DataUpdateInterface{
 
    public function __construct(){
    }
    
    public function run(){
    }

}
