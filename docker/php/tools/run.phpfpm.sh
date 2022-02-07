#!/usr/bin/env bash

# This let the script fail when a subcommand fails, container won't start so we will notice something went wrong
set -e

composer.phar dump-env prod

# Undo set -e from above
set +e

/usr/local/sbin/php-fpm
