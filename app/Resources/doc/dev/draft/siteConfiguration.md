# Les paramètres d'un site

## Nom

L'attribut nom est le nom du site. Il permet de générer l'identifiant du site.

## L'identifiant du site

L'identifiant du site est généré lorsque vous remplissez le nom du site, mais il reste modifiable lors de la création d'un site.
Cet attribut est unique, par conséquent une fois le site créé il n'est plus possible de le modifier.
OpenOrchestra vérifie lors de la validation du formulaire que cet identifiant de site n'existe pas déjà.

## Alias

OpenOrchestra permet de créé plusieurs alias pour un site.

### Protocole

L'attribut protocole permet de définir par quel protocole le site est accessible par défaut. Il est possible de définir un protocole différent pour chaque page.

### Domaine

L'attribut domaine permet de définir le domaine de l'alias.

### Langue

L'attribut langue permet de définir la langue par défaut sur le site.

### Préfix de la langue

L'attribut préfix de la langue permet de définir le préfix de la langue visible dans l'url des pages du site.

### Alias principal

L'attribut alias principal permet de définir si c'est cette alias qui prime sur les autres. Nous utilisons seulement l'alias principal lors de la génération du sitemap

## Blocs disponibles

L'attribut liste tous les blocs disponibles sur OpenOrchestra. Les blocs sélectionnés seront ceux visibles lors de la contribution des pages du site.

## Thème par défaut du site

L'attribut thème correspond au thème par défaut utilisé pour le site. Il est possible de sélectionner un thème différent lors de la création d'une page.

## Fréquence de modification indicative

L'attribut fréquence de modification indicative est utilisé pour la génération du sitemap.

## Importance relative par rapport aux autres pages du site

L'attribut importance relative permet de savoir qu'elle est l'importance de cette page par rapport aux autres.
Cet attribut est utilisé pour la génération du sitemap.

## Meta

Les attributs meta permettant de fournir des informations sur la nature et le contenu de la page web, ils sont ajoutés dans l'entête de la page avec des balises meta.
Ces attributs peuvent être modifiés par page.

### Meta keyword

L'attribut est utilisé pour grouper des mots-clés relatifs aux pages du site.
Ces mots peuvent être utilisés par certains moteurs de recherche pour classer le site.

### Meta description

L'attribut est utilisé par les moteurs de recherche pour indexer les pages du site.

### Meta index

L'attribut permet de définir si les pages du site doivent être indexées par le moteur de recherche.

### Meta follow

L'attribut permet de définir si le moteur de recherche peut suivre les liens contenus dans la page pour indexer d'autres documents.

### Informations contenues dans le fichier robots.txt

Cet attribut est utilisé pour la génération du robots.txt.

* Le User-agent permet de spécifier les agents qui pourront accéder au site. Par défaut * accès accordé à tous les agents.
* Allow permet de spécifier de définir au moteur de recherche les répertoires et pages du site qui peuvent être parcourus.
