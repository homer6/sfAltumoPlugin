#!/bin/bash

# This should be copied to project/.git/hooks/post-commit

SCRIPT=$(readlink -f $0)
PROJECT_PATH=`dirname $SCRIPT`/../../htdocs/project
PHP_BIN=`which php`
HOOK_NAME=$(basename $SCRIPT)

echo $PROJECT_PATH/symfony altumo:git-hook-handler $HOOK_NAME
#$PHP_BIN $PROJECT_PATH/symfony altumo:git-hook-handler $HOOK_NAME
