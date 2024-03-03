#!/bin/sh

echo -e "\033[1;33mRunning mess detector:\033[0m"
php \
    -d xdebug.mode=off \
    -d pcov.enable=0 \
  vendor/bin/phpmd src text \
    --exclude=src/Kernel.php \
    ./test/mess-detector.xml
