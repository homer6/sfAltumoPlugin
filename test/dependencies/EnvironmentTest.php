<?php

/**
* This file is part of the Altumo library.
* 
* (c) Steve Sperandeo <steve.sperandeo@altumo.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


namespace Altumo\Test;

/**
* Unit tests for the environment depedencies for sfAltumoPlugin
* 
* @author Steve Sperandeo <steve.sperandeo@altumo.com>
*/
class EnvironmentTest extends \Altumo\Test\UnitTest{


    /**
    * Tests that all of the requirements of PHP are met.
    * 
    */
    public function testPhp(){

        $php_installed = `which php`;
        if( !empty($php_installed) ){
            
            $this->assertTrue( !empty($php_installed), 'PHP must be installed.' );
            
            //assert 5.3.4+
                $php_version = `php -v`;
                if( preg_match('/PHP (\\d+)\\.(\\d+)\\.(\\d+)/', $php_version, $regs) ){
                    
                    $major_version = (integer)$regs[1];
                    $minor_version = (integer)$regs[2];
                    $release_version = (integer)$regs[3];
                    
                    if( $major_version >= 5 && $minor_version >= 3 && $release_version >= 4 ){
                        $this->assertTrue( true, 'PHP version must be 5.3.4 or greater.' );
                    }else{
                        $this->assertTrue( false, 'PHP version must be 5.3.4 or greater.' );
                    }
                    
                }else{
                    
                    $this->assertTrue( false, 'PHP version could not be detected.' );
                    
                }
                
            $php_info = `php -i`;
            
            //assert PDO is loaded
                $this->assertTrue( strstr( $php_info, 'PDO support => enabled' ) !== false, 'PDO is not loaded as a PHP extension.' );


        }else{
            
            $this->assertTrue( false, 'PHP must be installed.' );
            
        }
        
              
    }


}



