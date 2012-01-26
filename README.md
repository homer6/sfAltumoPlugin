Overview
------------
sfAltumoPlugin integrates Altumo into an existing Symfony 1.4 / Propel 1.6 
project. sfAltumoPlugin also provides additional functionality specific to 
Symfony and Propel:
  - a fully function working API toolkit for writing API methods (JSON)
  - a database build and deployment system based on git
  - a collection of symfony pake tasks

Altumo is a library of tools for web development under the MIT License. 
( See altumo for vendor license information )


Dependencies
------------
   - Git 1.7+
   - Symfony 1.4.*
   - Propel 1.6

Installation - New Project
--------------------------

  - See: https://github.com/homer6/blank_altumo


Installation - Existing Project
-------------------------------

  - Symfony root must be in htdocs/project (relative to the git root).
  - Symfony 1.4 must be installed in the lib/vendor directory (eg. htdocs/project/lib/vendor/symfony).
  - cd {git root}
  - git submodule add git://github.com/homer6/sfAltumoPlugin.git htdocs/project/plugins/sfAltumoPlugin
  - git submodule update --recursive --init
  - add "$this->enablePlugins('sfAltumoPlugin');" to ProjectConfiguration.class.php
  - cd htdocs/project 
  - ./symfony altumo:install-plugin
  - ./symfony altumo:install //see usage for details
  - ./symfony altumo:build


ApiRequest Caveat
-----------------

The ApiRequest class contains (in function authenticate()) the following line:

   `\sfContext::getInstance()->getUser()->signIn( $sf_guard_user, false );`

This line assumes that the object returned by getUser() implements method
`signIn`. The standard class myUser however does not implement that method,
so the project has to contain a class of that name that implements it in order
to be able to use standard API authentication.

