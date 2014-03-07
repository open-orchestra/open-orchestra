# Orchestra install on Debian #
----------

Here is a step by step tutorial to create the environnement :

##### 1. Install OS
OS used is Debian 7.4. It can be downloaded at  [https://www.debian.org/releases/wheezy/](https://www.debian.org/releases/wheezy/)

##### 2. Install Apache 2
Apache is used in pre-fork mode. To install it on debian :  

    apt-get install apache2-mpm-prefork

##### 3. Install MySQL
To install the last version of MySQL :

    apt-get install mysql-server
Once install is done, you can run the following script to secure your MySQL server :

    mysql_secure_installation

##### 4. Install PHP
To install the last version of PHP :

    apt-get install php5 php-pear php5-mysql

In addition, mongo driver for php has to be installed :

    pecl install mongo

To activate the extension, edit /etc/ph5/apache2/php.ini and add the following line :

    extension=mongo.so

Finally, restart Apache with :

    service apache2 restart


##### 5. Install Varnish
To install the last version of Varnish you should begin with updating your sources.list to check packages on Varnish repisotories instead of Debian ones.

    curl http://repo.varnish-cache.org/debian/GPG-key.txt | apt-key add -
	echo "deb http://repo.varnish-cache.org/debian/ wheezy varnish-3.0" >> /etc/apt/sources.list
    apt-get update

You can then install Varnish

    apt-get install varnish

##### 6. Configure ports listening
The architecture requires Varnish to listen on port 80 and request Apache on port 8080.

To configure Varnish to listen on port 80, edit file **/etc/default/varnish** and modify the section **Alternative 2** to set option -a of DAEMON_OPTS var to 80 :

    ## Alternative 2, Configuration with VCL
    #
    # Listen on port 6081, administration on localhost:6082, and forward to
    # one content server selected by the vcl file, based on the request.  Use a 1GB
    # fixed-size cache file.
    # DAEMON_OPTS="-a :80 \
              -T localhost:6082 \
              -f /etc/varnish/default.vcl \
              -S /etc/varnish/secret \
              -s malloc,256m"

To make Varnish request Apache on port 8080 edit file **/etc/varnish/default.vcl** and change those line :

    backend default {
     .host = "127.0.0.1";
     .port = "8080";
    }

Next, you have to configure Apache to listen on port 8080. To do this, edit **/etc/apache2/sites-available/YOUR-VHOST-CONF-FILE**

    <VirtualHost *:8080>

Then restart Apache and Varnish :

     /etc/init.d/apache2 restart
     /etc/init.d/varnish restart

##### 7. Install MongoDB
As for Varnish, first step to install MongoDB is to update the sources.list file to add 10gen repositories.

    apt-key adv --keyserver keyserver.ubuntu.com --recv 7F0CEB10
    echo 'deb http://downloads-distro.mongodb.org/repo/debian-sysvinit dist 10gen' | tee /etc/apt/sources.list.d/mongodb.list
    apt-get update

Then install mongoDB :

    apt-get install mongodb-10gen=2.2.3

##### 8. Clone project
Install git and clone project from github : [https://github.com/itkg/phporchestra.git](https://github.com/itkg/phporchestra.git)

##### 9. Configure Apache Vhost
You can see **conf/apache2/php-orchestra** for a vhost sample  
**/!\ CHANGE PATH IN VHOST + CREATE LOG DIR**

----------   
**Additional info :**  
The secret token chosen during the symfony installation procss is $php-orchestra$