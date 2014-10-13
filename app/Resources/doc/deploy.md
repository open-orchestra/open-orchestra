# Orchestra deploy on integration environment #
--------

This tutorial is going to describe step by step how you can deploy the phpOrchestra project on the integration environment:

## Install Gem and bundler
In order to separate all the project of your computer, we use bundler to execute only the specified version of capifony and capistrano

    aptitude install gem
    gem install bundler

## Install capifony
In the root directory of your project, run the command

    bundle install

## SSH configuration
Make sur that your ssh configuration is ready and your personnal key is installed on the integration server

    # ~/.ssh/config
    Host php_orchestra_root
        Hostname 10.0.1.246
        User root
        ForwardAgent yes
    Host php_orchestra_front_inte
        Hostname 10.0.1.246
        User php_orchestra_front_inte
        ForwardAgent yes
    Host php_orchestra_backoffice_inte
        Hostname 10.0.1.246
        User php_orchestra_backoffice_inte
        ForwardAgent yes

## Test the command
Run the following command to test the installation and connection to the server

    bundle exec cap symfony:logs:tail

## Deploy
Before deploying the project, make sure that the composer.lock file is up-to-date on the master branch

Then you can run the deploy commande

    bundle exec cap deploy

Once this is done, you can check the project.

If it is not running check the right by connecting on the server and put the group back

    ssh php_orchestra_root
    chgrp -R www-data /var/www/backoffice-phporchestra/
