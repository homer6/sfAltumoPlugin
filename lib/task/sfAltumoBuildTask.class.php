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
 * Main compile" or "make" script. This will compile the website into a more 
 * executable form (a build).
 * 
 * @author Steve Sperandeo <steve.sperandeo@altumo.com>
 */
class sfAltumoBuildTask extends sfAltumoBaseTask {

    /**
    * @see sfTask
    */
    protected function configure() {
        
        parent::configure();
        
        $this->addArguments(array(
            //new sfCommandArgument( 'username', sfCommandArgument::OPTIONAL, 'The database username', 'root' ),
        ));

        $this->addOptions(array(
            //new sfCommandOption( 'output_file', null, sfCommandOption::PARAMETER_OPTIONAL, 'The path of the target Javascript file', null ),
        ));


        $this->name = 'build';

        $this->briefDescription = 'Compiles the website into a more executable form (a build).';

    $this->detailedDescription = <<<EOF
Compiles the website into a more executable form (a build):
 - all propel builds
 - closure's javascript dependencies builder 

EOF;
    }


    /**
    * @see sfTask
    */
    protected function execute( $arguments = array(), $options = array() ) {
        
        //sfAltumoPlugin tests
        //$test_suite = new \Altumo\Test\TestSuite( __DIR__ . '/../../test' );
                
        //Project tests
        //$test_suite = new \Altumo\Test\TestSuite( __DIR__ . '/../../../../test' );
        
        
        $commands = array( 
            './symfony propel:build-sql',
            './symfony propel:build-forms',
            './symfony propel:build-model',
            './symfony propel:build-filters',
            './symfony build-javascript-dependencies'        
        );
        
        foreach( $commands as $command ){
            
            `$command`;
            
        }
        

    }
    
}
