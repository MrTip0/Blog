#!/bin/bash

(cd tipettino && yarn && yarn build) & (cd backend/ && composer install)
cp -r "tipettino/dist/" "build/"
cp keys.php build/keys.php
cp -r backend/* build/