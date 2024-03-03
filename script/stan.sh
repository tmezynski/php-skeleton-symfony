#!/bin/sh

echo -e "\033[1;33mRunning phpstan:\033[0m"
php \
    -d xdebug.mode=off \
    -d pcov.enable=0 \
  vendor/bin/phpstan analyse \
    -c test/stan.neon \
    --no-progress\
    --no-interaction \
    --no-ansi
