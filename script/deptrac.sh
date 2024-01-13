#!/bin/sh

echo -e "\033[1;33mRunning layer dependency tests:\033[0m"
php \
    -d pcov.enabled=0 \
    -d xdebug.mode=off \
  vendor/bin/deptrac analyse \
    --config-file=test/.config/deptrac.yml \
    --cache-file=var/.deptrac.cache
