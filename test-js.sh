#!/bin/bash

# Run test task of Open Orchestra bundles
for i in vendor/open-orchestra/*/GruntFile.js; do
    ./node_modules/.bin//grunt -b . --gruntfile "$i" test;
done;
