#!/bin/sh

echo -e "\033[1;33mRunning mutation tests:\033[0m"
php \
    -d pcov.enabled=0 \
    -d xdebug.mode=off \
  vendor/bin/infection \
    --configuration=test/.config/infection.json
