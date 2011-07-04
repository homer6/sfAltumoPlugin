<?php
/*
// Sample Code from sfGuardPlugin

    if( sfConfig::get( 'app_sf_guard_plugin_routes_register', true ) && in_array( 'sfGuardAuth', sfConfig::get( 'sf_enabled_modules', array() ) ) ) {
        $this->dispatcher->connect('routing.load_configuration', array('sfGuardRouting', 'listenToRoutingLoadConfigurationEvent'));
    }

    foreach( array( 'sfGuardUser', 'sfGuardGroup', 'sfGuardPermission' ) as $module ) {
        if( in_array($module, sfConfig::get( 'sf_enabled_modules' ) ) ) {
            $this->dispatcher->connect( 'routing.load_configuration', array( 'sfGuardRouting', 'addRouteForAdmin'.str_replace( 'sfGuard', '', $module ) ) );
        }
    }
    
*/

// Include the Altumo auto loader
    require_once( dirname(__FILE__) . '/../lib/vendor/altumo/source/php/loader.php' );