#!/bin/sh

echo -e "\033[1;33mRunning code sniffer:\033[0m"
php \
    -d xdebug.mode=off \
    -d pcov.enable=0 \
  vendor/bin/phpcbf \
    --standard=test/code-sniffer.xml \
    src \
    test \
    bin \
    config \
    migrations
