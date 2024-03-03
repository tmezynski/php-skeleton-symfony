#!/bin/sh

echo -e "\033[1;33mRunning unit tests:\033[0m"
php \
    -d pcov.enabled=1 \
    -d xdebug.mode=off \
  vendor/bin/phpunit \
    --configuration=test/phpunit.xml \
    --testsuite=unit \
    --no-coverage
