# Orchestra deploy on integration environment #
--------

This tutorial is going to describe step by step how you can deploy the openOrchestra project on the integration environment:

## Install Gem and bundler
In order to separate all the project of your computer, we use bundler to execute only the specified version of capifony and capistrano

    aptitude install ruby ruby-dev
    gem install bundler

## Install capifony
In the root directory of your project, run the command

    bundle install

## SSH configuration
Make sur that your ssh configuration is ready and your personnal key is installed on the integration server

    # ~/.ssh/config
    Host open_orchestra_root
        Hostname 10.0.1.246
        User root
        ForwardAgent yes
    Host open_orchestra_front_inte
        Hostname 10.0.1.246
        User open_orchestra_front_inte
        ForwardAgent yes
    Host open_orchestra_backoffice_inte
        Hostname 10.0.1.246
        User open_orchestra_backoffice_inte
        ForwardAgent yes

## Test the command
Run the following command to test the installation and connection to the server

    cap inte deploy:log_revision

## Deploy
Before deploying the project, make sure that the composer.lock file is up-to-date on the master branch

    ./composer.phar update
    git add composer.lock
    git commit -m "update vendor"
    git pull --rebase origin master
    git push origin master:update_vendor

Once the tests are green, you can merge the branch into master

Then you can run the deploy command in the project directory

    cap inte deploy

Once this is done, you can check the project.
