# Orchestra install on dev environment #
--------

This tutorial is going to describe the step by step installation for the openOrchestra global environment:

## Install OS
It is a requirement that every developper run under an unix OS, 64 bits version.

## Install Virtualbox
The project is running on a virtual environment to be production ready

    aptitude install virtualbox

## Install Vagrant
We are going to use the vagrant project to manage all the vitualbox

    wget https://dl.bintray.com/mitchellh/vagrant/vagrant_1.6.3_x86_64.deb
    dpkg -i vagrant_1.6.3_x86_64.deb

## Install ansible
All the project server configuration is going to be handled by ansible.
To avoid version troubles, switch to release 1.7.1

    git clone git://github.com/ansible/ansible.git --recursive
    cd ./ansible
    git checkout -b release1.8.2 origin/release1.8.2
    git submodule init
    git submodule update --recursive
    source ./hacking/env-setup

Go on the project page for more inforation : http://www.ansible.com

## Clone the repositories
In the parent directory of the current directory run

    git clone git@github.com:itkg/open-orchestra-front-demo.git
    git clone git@github.com:itkg/open-orchestra.git

## Install roles from ansible-galaxy
Install roles needed to launch the box
As a prerequisite, update your python modules if required with those two

    aptitude install python-yaml
    aptitude install python-jinja2

Then go into openorchestra directory

    ansible-galaxy install --role-file=provisioning/galaxy.yml

## Override the dns redirection
In the `/etc/hosts` file of your computer add the following lines :

    192.168.33.10   admin.openorchestra.dev
    192.168.33.10   front.openorchestra.dev
    192.168.33.10   demo.openorchestra.dev
    192.168.33.10   echonext.openorchestra.dev
    192.168.33.10   media.openorchestra.dev

## Temporary Override the dns redirection for the integration server
In the `/etc/hosts` file of your computer add the following lines:

    10.0.1.246      demo.openorchestra.inte
    10.0.1.246      front.openorchestra.inte
    10.0.1.246      smartadmin.openorchestra.inte
    10.0.1.246      echonext.openorchestra.inte
    10.0.1.246      media.openorchestra.inte
    10.0.1.246      admin.openorchestra.inte

## Launch the box
When you launch the box, it will take some time to :
Import the base box,
Launch it,
Run all the provisionning scripts

    vagrant up

## Prepare the projet
You need to install all the php dependancies before starting the project
Start by downloading composer

    vagrant ssh
    cd /var/www/open-orchestra
    php -r "readfile('https://getcomposer.org/installer');" | php

Then install the project

    ./composer.phar install

## Install the assets
We are using npm to manage some server side javascript librairies and bower to manage the client side librairies

Still connected to the vagrant box, go in the project directory inside the box

    cd /var/www/open-orchestra

Install the npm dependancies

    npm install

The npm should have also installed the bower component.

Launch the grunt command to generate all assets

    ./node_modules/.bin/grunt

## Load the fixtures
In the symfony project directory

    php app/console doctrine:mongo:fixture:load


## Result
Once this command, all the client side javascripts librairies should have been installed.
You can now go on the website on the url : http://admin.openorchestra.dev/app_dev.php/admin
