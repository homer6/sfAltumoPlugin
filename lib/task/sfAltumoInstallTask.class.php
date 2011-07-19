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
 * Sets up all the things necessary to get this website running.
 * 
 * @author Steve Sperandeo <steve.sperandeo@altumo.com>
 */
class sfAltumoInstallTask extends sfAltumoBaseTask {

    /**
    * @see sfTask
    */
    protected function configure() {
        
        parent::configure();
        
        $this->addArguments(array(
            //new sfCommandArgument( 'username', sfCommandArgument::OPTIONAL, 'The database username', 'root' ),
            new sfCommandArgument( 'database-host', sfCommandArgument::REQUIRED, 'The hostname of the MySQL database.' ),
            new sfCommandArgument( 'database-user', sfCommandArgument::REQUIRED, 'The username of the MySQL user that will be used by this application.' ),
            new sfCommandArgument( 'database-password', sfCommandArgument::REQUIRED, 'The password of the MySQL user that will be used by this application.' ),
            new sfCommandArgument( 'database', sfCommandArgument::REQUIRED, 'The name of the MySQL database that will be used by this application.' ),
            new sfCommandArgument( 'domain', sfCommandArgument::REQUIRED, 'The domain name (including subdomain) of this application.' ),
            new sfCommandArgument( 'environment', sfCommandArgument::REQUIRED, 'This Symfony environment of this environment (eg. dev_username, production, testing)' )
        ));

        /*
        $this->addOptions(array(
            new sfCommandOption( 'database-host', null, sfCommandOption::PARAMETER_REQUIRED, 'The hostname of the MySQL database.', 'localhost' ),
        ));
        */

        //./symfony altumo:install localhost my_db_user my_db_password my_database my.dev.domain.com dev_ssperandeo

        $this->name = 'install';

        $this->briefDescription = 'Sets up all the things necessary to get this website running.';

    $this->detailedDescription = <<<EOF
Sets up all the things necessary to get this website running:
 - untemplates the templated files
 - installs the database credentials and project path in the necessary config
   files
 - provides a sample vhost to install
 - fixes the file and directory permissions
 - clears the cache
 - setup the database builder
 - installs the githooks
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
        
        
        //get the project root and set the template variables
            $project_root = realpath( sfConfig::get('sf_root_dir') . '/../../' );
            $domain_name = $arguments['domain'];
            $create_database_temp_file = sfConfig::get('sf_root_dir') . '/create_database.sql';
            
            $template_variables = array(
                'PROJECT_ROOT' => $project_root,
                'PROJECT_DOMAIN' => $domain_name,
                'DATABASE_HOST' => $arguments['database-host'],
                'DATABASE_USER' => $arguments['database-user'],
                'DATABASE_PASSWORD' => $arguments['database-password'],
                'DATABASE' => $arguments['database'],
                'ENVIRONMENT' => $arguments['environment']
            );
        

        //fixes the file and directory permissions        
            `./symfony project:permissions`;
            $this->log( 'Symfony permissions set.' );
            //make apache logs folder writable
            chmod( $project_root . '/htdocs/logs', 0777 );
            $this->log( 'Apache log file permissions set.' );

        //untemplates the templated files
            $template_path = $project_root . '/htdocs/project/plugins/sfAltumoPlugin/install';
            $templated_files = array(
                array(
                    'source' => 'databases.yml.tpl',
                    'destination' => sfConfig::get('sf_config_dir') . '/databases.yml'
                ),
                array(
                    'source' => 'propel.ini.tpl',
                    'destination' => sfConfig::get('sf_config_dir') . '/propel.ini'
                ),
                array(
                    'source' => 'index.php.tpl',
                    'destination' => sfConfig::get('sf_web_dir') . '/index.php'
                ),
                array(
                    'source' => 'vhost.tpl',
                    'destination' => sfConfig::get('sf_root_dir') . '/' . $domain_name
                ),
                array(
                    'source' => 'create_database.sql.tpl',
                    'destination' => $create_database_temp_file
                )
            );
                        
            foreach( $templated_files as $templated_file ){
                
                $template_file_contents = file_get_contents( $template_path . '/' . $templated_file['source'] );
                
                foreach( $template_variables as $variable_name => $value ){
                    $template_file_contents = str_replace( '[[' . $variable_name . ']]', $value, $template_file_contents );
                }
                
                file_put_contents( $templated_file['destination'], $template_file_contents );
                
            }
            $this->log( 'Template files installed.' );
            
         
        //setup the database builder
            `./symfony altumo:update-database init`;
            $this->log( 'Database updater initialized.' );
            
        //install git hooks
            `./symfony altumo:git-hook-handler install`;
            $this->log( 'Git hooks installed.' );

        //display the next steps to take
        
            //get the next number available in /etc/apache2/sites-enabled
                $next_available_sites_enabled = 0;                
                $files = \Altumo\Utils\Finder::type('file')->follow_link()->relative()->in( '/etc/apache2/sites-enabled' );
                foreach( $files as $file ){
                    if( preg_match('/^(\\d+)/', $file, $regs) ){
                        $new_number = (integer)$regs[1];
                        if( $new_number > $next_available_sites_enabled ){
                            $next_available_sites_enabled = $new_number;
                        }
                    }
                }
                $next_available_sites_enabled++;
                $next_available_sites_enabled = str_pad( $next_available_sites_enabled, 3, "0", STR_PAD_LEFT );
                
            //get the database script
                $database_script = file_get_contents( $create_database_temp_file );
                unlink( $create_database_temp_file );
                //indent it
                    $database_script = preg_replace( '/^/m', '            ', $database_script );

            $next_steps = <<<STEPS
            
    NEXT STEPS:
    
        //install the vhost 
            sudo cp $domain_name /etc/apache2/sites-available
            sudo ln -s /etc/apache2/sites-available/$domain_name /etc/apache2/sites-enabled/$next_available_sites_enabled-$domain_name
            rm $domain_name
            sudo /etc/init.d/apache2 restart
            
        //create the database and user
$database_script
            
        //register domain and point to dns servers    
        //setup dns entries (or hosts file entries)

        ./symfony altumo:test-environment
        ./symfony cc
        ./symfony altumo:update-environment
            
STEPS;
        
        echo $next_steps . "\n";
    }
    
}
