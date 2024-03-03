#!/bin/sh

echo -e "\033[1;33mRunning acceptance tests:\033[0m"
php \
    -d pcov.enabled=0 \
    -d xdebug.mode=off \
  vendor/bin/behat \
    --config=test/behat.yml \
    --strict \
    --no-colors \
    --format=progress \
