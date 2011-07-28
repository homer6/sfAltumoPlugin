#!/bin/bash

# This should be copied to project/.git/hooks/post-commit
# use "./symfony altumo:git-hook-handler install" to install all of the hooks

SCRIPT=$(readlink -f $0)
PROJECT_PATH=`dirname $SCRIPT`/../../htdocs/project
HOOK_NAME=$(basename $SCRIPT)

# unset the $GIT_DIR because git hooks are setting it to ".git"
# see: http://debuggable.com/posts/git-tip-auto-update-working-tree-via-post-receive-hook:49551efe-6414-4e86-aec6-544f4834cda3
unset GIT_DIR
export GIT_ROOT_DIRECTORY=$PROJECT_PATH

$PROJECT_PATH/symfony altumo:git-hook-handler $HOOK_NAME

unset GIT_ROOT_DIRECTORY
unset IMPORT_FROM_SF_ALTUMO
