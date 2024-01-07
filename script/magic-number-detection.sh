#!/bin/sh

echo -e "\033[1;33mRunning magic numbers detection:\033[0m"
php \
    -d xdebug.mode=off \
    -d pcov.enable=0 \
  vendor/bin/phpmnd \
    --extensions=array,assign,default_parameter,operation,property \
    --include-numeric-string \
    --ignore-numbers=-1,0,1 \
    --hint \
    --progress \
    -n \
    src
