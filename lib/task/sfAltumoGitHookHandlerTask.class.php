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
 * Handles all installed Git hooks by passing the call onto 
 * \sfAltumoPlugin\Build\GitHookHandler::handle()
 * 
 * Alternatively, installs the git hooks within git if hook-name is "install".
 * 
 * @author Steve Sperandeo <steve.sperandeo@altumo.com>
 */
class sfAltumoGitHookHandlerTask extends sfAltumoBaseTask {

    /**
    * @see sfTask
    */
    protected function configure() {
        
        parent::configure();
        
        $this->addArguments(array(
            new sfCommandArgument( 'hook-name', sfCommandArgument::REQUIRED, 'The git hook name ("install" to install hooks).' ),
        ));

        $this->addOptions(array(
            //new sfCommandOption( 'build', null, sfCommandOption::PARAMETER_OPTIONAL, 'Modifies an existing database according to available build files.', null ),            
        ));

        $this->name = 'git-hook-handler';

        $this->briefDescription = 'Calls the altumo git hook handler or installs the git hooks.';

        $this->detailedDescription = <<<EOF
Calls the altumo git hook handler. Alternatively, installs the git hooks within git if hook-name is "install".
EOF;
    }

    
    /**
    * @see sfTask
    */
    protected function execute( $arguments = array(), $options = array() ) {

        $hook_name = $arguments['hook-name'];
        
        if( $hook_name === 'install' ){
            
            $git_hooks = array(
                array(
                    'source' => sfConfig::get( 'sf_root_dir' ) . '/plugins/sfAltumoPlugin/install/git_hook_handler.sh',
                    'destination_path' => realpath( sfConfig::get( 'sf_root_dir' ) . '/../../.git/hooks' ),
                    'targets' => array(
                        'post-commit'
                    )
                ),
                array(
                    'source' => sfConfig::get( 'sf_root_dir' ) . '/plugins/sfAltumoPlugin/install/git_hook_handler_sfAltumoPlugin.sh',
                    'destination_path' => realpath( sfConfig::get( 'sf_root_dir' ) . '/plugins/sfAltumoPlugin/.git/hooks' ),
                    'targets' => array(
                        'post-commit', 
                        'post-merge' //git pull
                    )
                )
            );
            
            foreach( $git_hooks as $git_hook ){
                
                $general_hook_template_file = $git_hook['source'];
                $target_path = $git_hook['destination_path'];

                //check to make sure the folder is writable
                //we want the hooks to be overwritten, so we're not going to check for that here
                    if( !is_writable($target_path) ){
                        throw new sfCommandException( sprintf('"%s" is not writable. Please ensure this user can write to that directory.', $target_path) );
                    }
                    
                //install the hooks
                    foreach( $git_hook['targets'] as $target ){
                        $target_filename = $target_path . '/' . $target;
                        copy( $general_hook_template_file, $target_filename );
                        chmod( $target_filename, 0755 );
                    }
                
            }
            
        }else{
            
            $handler = new \sfAltumoPlugin\Build\GitHookHandler( $hook_name );
            
        }     
        
        
        
    }
    
}
