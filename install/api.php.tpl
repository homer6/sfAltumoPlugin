<?php


require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration( 'api', '[[ENVIRONMENT]]', false );
sfContext::createInstance($configuration)->dispatch();
