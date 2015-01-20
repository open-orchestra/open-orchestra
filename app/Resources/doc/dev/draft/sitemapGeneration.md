## Génération des sitemaps
Les sitemaps des différents sites créés sur une plateforme orchestra sont générables par une commande console disponible sur le front :
    app/console orchestra:sitemaps:generate
Ceci génère dans le répertoire /web un fichier sitemap pour chaque site déclaré sur la plateforme. Les fichiers sont générés avec le pattern de nommage suivant : sitemap.{hostname}.xml
Il est possible de passer une option à cette commande pour ne générer le sitemap que d'un site en particulier :
    app/console orchestra:sitemaps:generate siteId=x
## Internationalisation
Actuellement l'internationalisation n'est pas prise en compte dans la génération ([https://support.google.com/webmasters/answer/2620865?hl=fr](https://support.google.com/webmasters/answer/2620865?hl=fr))

## Droits d'accès
Actuellement les droits ne sont pas checkés et tous les nodes (publics ou privés) apparaissent dans le sitemap.

## Accès web aux sitemaps
Actuellement rien n'est établi quand à la façon de servir ces fichiers : rewrite apache ? contrôleur symfony ?