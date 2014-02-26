Steps list to create the environnement :

1/ Install OS : Debian 7.4
2/ Install Apache 2 (pre-fork mode)
3/ Install Mysql
4/ Install Php
5/ Install Varnish
6/ Configure Varnish to listen on port 80 and request Apache on port 8080 (see conf/varnish/README.MD)
   Configure Apache to listen on port 8080 (see conf/apache2/README.MD)
7/ Install MongoDB
8/ Install git and clone project from github (https://github.com/itkg/phporchestra.git)
9/ Configure Apache Vhost (see conf/apache2/php-orchestra for vhost file)
   /!\ CHANGE PATH IN VHOST + CREATE LOG DIR