<?php

class sfAltumoMakeGeckoboardRequestTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, null ),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
      // add your own options here
        		
      new sfCommandOption( 'url', null, sfCommandOption::PARAMETER_REQUIRED ),
      new sfCommandOption( 'key', null, sfCommandOption::PARAMETER_REQUIRED ),

    ));

    $this->namespace        = 'altumo';
    $this->name             = 'run-geckoboard-request';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [run-gb-request|INFO] task makes a HTTP request with authentication as per Geckoboard spec
Call it with:

  [php symfony altumo:run-geckoboard-request|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
    // add your code here

        
    $url = $options['url'];
    $api_key = $options['key'];

    $request = new \Altumo\Http\OutgoingHttpRequest( $url );
    $request->setVerifySslPeer( false );
    $request->addHeader( 'Authorization', sprintf( 'Basic %s', $api_key ) );
    echo $request->send();

  }
}
