# Les paramètres d'un site

## Nom

L'attribut nom est le nom du site. Il permet de générer l'identifiant du site.

## L'identifiant du site

L'identifiant du site est généré lorsque l'on remplit le nom du site, mais il reste modifiable lors de la création d'un site.
Cet attribut est unique, par conséquent une fois le site créé il n'est plus possible de le modifier.
OpenOrchestra vérifie lors de la validation du formulaire que cet identifiant de site n'existe pas déjà.

## Alias

OpenOrchestra permet de créer plusieurs alias pour un site.

### Protocole

L'attribut protocole permet de définir par quel protocole le site est accessible par défaut. Il est possible de définir un protocole différent pour chaque page.

### Domaine

L'attribut domaine permet de définir le domaine de l'alias.

### Langue

L'attribut langue permet de définir la langue par défaut sur le site.

### Préfixe de la langue

L'attribut préfixe de la langue permet de définir le préfixe de la langue visible dans l'url des pages du site.

### Alias principal

L'attribut alias principal permet de définir si cet alias qui prime sur les autres. OpenOrchestra utilise seulement l'alias principal lors de la génération du sitemap

### Exemple de création d'un alias

    Protocole par défaut : http
    Domaine : demo.openorchestra.dev
    Langue : Français
    Préfixe pour la langue : fr
    Alias pricipal : on

L'url de la page d'accueil du site serait alors `http://demo.openorchestra.dev/fr` et la page test `http://demo.openorchestra.dev/fr/test`

## Blocs disponibles

L'attribut liste tous les blocs disponibles sur OpenOrchestra. Les blocs sélectionnés seront ceux visibles lors de la contribution des pages du site.

## Thème par défaut du site

L'attribut thème correspond au thème par défaut utilisé pour le site. Il est possible de sélectionner un thème différent lors de la création d'une page.

## Attribut de génération de sitemap

Les attributs fréquence de modification indicative et d'importance relative par rapport aux autres pages, sont des valeurs par défaut surchargeable au cas par cas dans les noeuds.

### Fréquence de modification indicative

L'attribut fréquence de modification indicative est utilisé pour la génération du sitemap.

### Importance relative par rapport aux autres pages du site

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

## Informations contenues dans le fichier robots.txt

Le contenu de cet attribut correspond à ce que contiendra le robots.txt de chaque site.

### Exemple de contribution du robots.txt

    User-agent: *
    Allow: /

L'instruction User-agent: * signifie que la ou les instruction(s) qui suivent s'applique pour tous les agents.
L'instruction Allow: signifie que le moteur de recherche peut parcourir l'ensemble des répertoires et des pages du site.
