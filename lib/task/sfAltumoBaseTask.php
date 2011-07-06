<?php
/*
 * This file is part of the sfAltumoPlugin package
 *
 * (c) Steve Sperandeo <steve.sperandeo@altumo.com>
 * (c) Juan Jaramillo <steve.sperandeo@altumo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Base class for Altumo tasks
 * 
 * @package    altumo
 * @subpackage task
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