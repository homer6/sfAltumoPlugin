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
 * Runs all of the tests for this application.
 * 
 * @author Steve Sperandeo <steve.sperandeo@altumo.com>
 */
class sfAltumoTestTask extends sfAltumoBaseTask {

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


        $this->name = 'test';

        $this->briefDescription = 'Runs all of the unit tests for this application.';

    $this->detailedDescription = <<<EOF
Runs the sfAltumoPlugin tests and the project-specific tests.

EOF;
    }


    /**
    * @see sfTask
    */
    protected function execute( $arguments = array(), $options = array() ) {
        
        //sfAltumoPlugin tests
        $test_suite = new \Altumo\Test\TestSuite( __DIR__ . '/../../test' );
        
        //Project tests
        $test_suite = new \Altumo\Test\TestSuite( __DIR__ . '/../../../../test' );

    }
    
}
