#!/bin/sh

echo -e "\033[1;33mRunning coverage for unit and integration tests:\033[0m"
php \
    -d pcov.enabled=1 \
    -d xdebug.mode=off \
  vendor/bin/phpunit \
    --configuration=test/.config/phpunit.xml \
    --testsuite=unit,integration
