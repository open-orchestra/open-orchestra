I) Le bundle Site
=================== 

Le bundle PHPOrchestraSite est le site bêta de PHPOrchestra, le site est inspiré du site hub-sales.fr .
Il dispose d'un seul contrôleur, d'un fichier fixtures_site.yml et d'un fichier de traduction. 

Le contrôleur est copie du code de « NodeController » que j'ai adaptée à met besoin .

Les fichiers JavaScript, CSS et les images se trouvent dans web/bundles/phporchestrasite. 

Pour le moment seul les blocs Contact et Carrousel on étaient ajoutés au site. le reste des nœuds sont des blocs TinyMCEWysiwyg.

Les vues qui géré les nœuds sont présentes dans le dossier views du bundle. La vue show.html.twig contiendra la structure HTML, le doctype, les balise <html>, <header> et <body>.
