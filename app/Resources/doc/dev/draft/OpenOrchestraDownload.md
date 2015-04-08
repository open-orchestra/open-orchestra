# Download OpenOrchestra

Open Orchestra is composed of two projects, open-orchestra which is the CMS and open-orchestra-front-demo which will display the sites and pages created in the CMS.

## Requirements

To install OpenOrchestra you need:

* Apache2 `sudo aptitude install apache2`
* PHP `sudo aptitude install php5-dev php5-cli php-pear`
* Mongo  `sudo pecl install mongo`
* PHP extension copy `extension=mongo.so` on your php.ini

## Install Virtualbox
The project is running on a virtual environment to be production ready

    aptitude install virtualbox

## Install Vagrant
We are going to use the vagrant project to manage all the vitualbox

    wget https://dl.bintray.com/mitchellh/vagrant/vagrant_1.6.3_x86_64.deb
    dpkg -i vagrant_1.6.3_x86_64.deb

## Install ansible
All the project server configuration is going to be handled by ansible.
To avoid version troubles, switch to release 1.8.2

    git clone git://github.com/ansible/ansible.git --recursive
    cd ./ansible
    git checkout -b release1.8.2 origin/release1.8.2
    git submodule init
    git submodule update --recursive
    source ./hacking/env-setup

Go on the project page for more inforation : http://www.ansible.com

## Download Composer
Composer is the package manager used by modern PHP applications.

To install composer with curl:

    curl -sS https://getcomposer.org/installer | php

If you don't have curl installed, you can also download with php:

    php -r "readfile('https://getcomposer.org/installer');" | php

see [Download Composer](https://getcomposer.org/download/)

## Install OpenOrchestra
Install open-orchestra with composer:

    ./composer.phar create-project open-orchestra/open-orchestra path/to/your/folder -s dev
    ./composer.phar create-project open-orchestra/open-orchestra-front-demo path/to/your/folder -s dev

## Install roles from ansible-galaxy
Install roles needed to launch the box
as a prerequisite, update your python modules if required with those two

    aptitude install python-yaml
    aptitude install python-jinja2

then go into openorchestra directory

    ansible-galaxy install --role-file=provisioning/galaxy.yml

## Override the dns redirection
In the `/etc/hosts` file of your computer add the following lines :

    192.168.33.10   admin.openorchestra.dev
    192.168.33.10   front.openorchestra.dev
    192.168.33.10   demo.openorchestra.dev
    192.168.33.10   media.openorchestra.dev

## Launch the box
When you launch the box, it will take some time to :
Import the base box,
Launch it,
Run all the provisionning scripts

    vagrant up

## Install the assets
We are using npm to manage some server side javascript librairies and bower to manage the client side librairies

Still connected to the vagrant box, go in the project directory inside the box

    cd /var/www/openorchestra

Install the npm dependancies

    npm install

The npm should have also installed the bower component.

Launch the grunt command to generate all assets

    ./node_modules/.bin/grunt

## Load the fixtures
In the symfony project directory `/var/www/openorchestra`

    php app/console doctrine:mongo:fixture:load --env=prod

Now you can log on `http://admin.openorchestra.dev/login` with username=admin and password=admin for the CMS and see the result on `http://demo.openorchestra.dev`.
