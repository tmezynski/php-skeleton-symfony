#!/bin/sh

echo -e "\033[1;33mRunning integration tests:\033[0m"
php \
    -d pcov.enabled=1 \
    -d xdebug.mode=off \
  vendor/bin/phpunit \
    --configuration=test/.config/phpunit.xml \
    --testsuite=integration \
    --no-coverage
