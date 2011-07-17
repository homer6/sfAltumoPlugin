<?php
/*
 * This file is part of the sfAltumoPlugin library.
 *
 * (c) Steve Sperandeo <steve.sperandeo@altumo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
* Base class for Altumo tasks
* 
* @package sfAltumoPlugin
* 
* @author Juan Jaramillo <juan.jaramillo@altumo.com>
*/
abstract class sfAltumoBaseTask extends sfBaseTask {
    
    /**
    * @see sfTask
    */
    protected function configure() {
    
        $this->namespace = 'altumo';
    }
    
    
    /**
    * Other shared functions can go here.
    */
}