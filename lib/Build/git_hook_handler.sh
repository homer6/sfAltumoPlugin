#!/bin/bash

# This should be copied to project/.git/hooks/post-commit
# use "./symfony altumo:git-hook-handler install" to install all of the hooks

SCRIPT=$(readlink -f $0)
PROJECT_PATH=`dirname $SCRIPT`/../../htdocs/project
HOOK_NAME=$(basename $SCRIPT)

$PROJECT_PATH/symfony altumo:git-hook-handler $HOOK_NAME
