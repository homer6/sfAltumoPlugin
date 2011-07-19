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
 * Tests the dependencies for this environment.
 * 
 * @author Steve Sperandeo <steve.sperandeo@altumo.com>
 */
class sfAltumoTestDependenciesTask extends sfAltumoBaseTask {

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


        $this->name = 'test-environment';

        $this->briefDescription = 'Tests for the required dependencies of this environment.';

    $this->detailedDescription = <<<EOF
Test for things like PHP 5.3, PDO, Python, etc.

EOF;
    }


   /**
   * @see sfTask
   */
    protected function execute( $arguments = array(), $options = array() ) {
        
        $test_suite = new \Altumo\Test\TestSuite( __DIR__ . '/../../test/dependencies' );

    }
    
}
