#!/bin/sh

echo -e "\033[1;33mRunning code sniffer:\033[0m"
php \
    -d xdebug.mode=off \
    -d pcov.enable=0 \
  vendor/bin/phpcs \
    --standard=test/.config/code-sniffer.xml \
    --ignore=src/Kernel.php \
    src \
    test \
    bin \
    config \
    migrations
