#!/bin/bash

if [ -d build/ ]; then rm -rf build/; fi

echo 'building frontend...'
(cd tipettino && yarn 1> /dev/null && yarn build 1> /dev/null)
cp -r "tipettino/dist/" "build/"

echo 'building backend...'
(cd backend/ && composer install 1> /dev/null)
cp -r backend/* build/

echo 'copying keys to build folder'
cp keys.php build/keys.php