# README #
----------

Directory conf/apache2 contains the following file :

- **php-orchestra :** Apache Vhost conf file located in /etc/apache/sites-availables  

**Additional infos :**

In order to make Varnish and Apache working together, Apache must listen on port 80. To do this, edite /etc/apache2/ports.conf and replace the following lines :

        NameVirtualHost *:80
        Listen 80
		
with thoses :

        NameVirtualHost 127.0.0.1:8080
		Listen 127.0.0.1:8080
