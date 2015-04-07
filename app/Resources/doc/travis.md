# Orchestra integration on travis #
--------

This tutorial is going to describe step by step all the action you can do on the travis build

## Check the ruby version
It is required by the travis gem to have ruby in version superior as 1.9.6

    ruby --version

## Install ruby in last version
To manage all the ruby version, use rvm (ruby version manager)

First install rvm

    curl -sSL https://get.rvm.io | bash

List all the ruby version known by rvm 

    rvm list known

Install the version needed

    rvm install 2.1

Use the version installed

    rvm use 2.1

## Install travis
In the root directory of your project, run the command

    bundle install

Now you can check that travis is installed

    bundle exec travis --help

## Login on travis
You need to be logged in on the travis pro version (where all the build are made)

    bundle exec travis login --pro

Check the login by listing all the repositories

    bundle exec travis repos --pro

## Cache management
You can check all the cache present for a repository 

    bundle exec travis cache -r open-orchestra/openorchestra-cms-bundle

You can decide to delete the cache on one branch if needed

    bundle exec travis cache -r open-orchestra/openorchestra-cms-bundle  -b reduce_deps --delete
