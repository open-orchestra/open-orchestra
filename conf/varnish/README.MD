# README #
----------

Directory conf/varnish contains the following files :

- **varnish :** gereric varnish conf file located in /etc/default/
- **phporchestra.vcl :** specific varnish conf file for phporchestra located in /etc/varnish/

**Additional infos :**

In varnish conf file, Varnish is configured to listen on port 80. This file also indicates that vcl files are used.
So in phporchestra.vcl, the conf forward non-cached request on 127.0.0.1:8080.