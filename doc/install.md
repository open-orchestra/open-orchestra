# Orchestra install on dev environment #
--------

This tutorial is going to describe the step by step installation for the phpOrchestra global environment:

## Install OS
It is a requirement that every developper run under an unix OS

## Install Virtualbox
The project is running on a virtual environment to be production ready

    aptitude install virtualbox

## Install Vagrant
We are going to use the vagrant project to manage all the vitualbox

    wget https://dl.bintray.com/mitchellh/vagrant/vagrant_1.6.3_x86_64.deb
    dpkg -i vagrant_1.6.3_x86_64.deb

## Install ansible
All the project server configuration is going to be handled by ansible

    git clone git://github.com/ansible/ansible.git
    cd ./ansible
    source ./hacking/env-setup

Go on the project page for more inforation : http://www.ansible.com

## Clone the front repository
In the parent directory of the current directory run

    git clone git@github.com:itkg/phporchestra-front-demo.git

## Launch the box
When you launch the box, it will take some time to :
Import the base box,
Launch it,
Run all the provisionning scripts

    vagrant up

## Install the assets
We are using npm to manage some server side javascript librairies and bower to manage the client side librairies

Connect to the vagrant box

    vagrant ssh

Go in the project directory

    cd /var/www/phporchestra

Install the npm dependancies

    npm install

## Load the fixtures
In the symfony project directory

    php app/console doctrine:mongo:fixture:load

## Override the dns redirection
In the `/etc/hosts` file of your computer add the following lines :

    192.168.33.10	phporchestra.dev
    192.168.33.10	front-phporchestra.dev

## Result
Once this command, all the client side javascripts librairies should have been installed.
You can now go on the website on the url : http://phporchestra.dev/app_dev.php/admin