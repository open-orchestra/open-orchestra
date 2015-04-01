# Les paramètres d'un noeud

## Page

L'attribut page est le nom de la page (noeud), il est également utilisé pour construire le pattern de l'url.
Cet attribut est requis pour pouvoir créer la page.

## Pattern de l'url

L'attribut pattern de l'url est construit automatiquement avec le nom de la page, il renseigne le pattern qui permettra d'accéder à cette page sur le site.
Cet attribut est requis pour pouvoir créer la page.

## Protocole

L'attribut protocole permet de définir par quel protocole la page est accessible (http, https, etc...).
Cet attribut est requis pour pouvoir créer la page. Par défaut OpenOrchestra prend le protocole renseigné dans la configuration du site.

## Fréquence de modification indicative (pour le sitemap)

L'attribut fréquence de modification indicative est utilisé pour la génération du sitemap.

## Importance relative par rapport aux autres pages du site (pour le sitemap)

L'attribut importance relative permet de savoir quelle est l'importance de cette page par rapport aux autres. Cet attribut est utilisé pour la génération du sitemap.

## Le thème

L'attribut thème permet de choisir le thème qui sera utilisé par cette page.
Cet attribut est requis pour pouvoir créer la page.

## Menu

L'attribut menu permet de définir si cette page sera visible sur le menu du site. Cet attribut est utilisé par le bloc menu.

## Footer

L'attribut footer permet de définir si cette page sera visible dans le pied de page du site. Cet attribut est utilisé par le bloc footer.

## Meta

Les attributs meta permettant de fournir des informations sur la nature et le contenu de la page web, ils sont ajoutés dans l'entête de la page avec des balises meta.
Ces attributs sont aussi renseignés dans la configuration du site. Lors de l'affichage de la page si ces attributs sont vides alors ce sont les attributs correspondants du site qui sont utilisés

### Meta keywords

Cet attribut est utilisé pour grouper des mots-clés relatifs à la page. Ces mots peuvent être utilisés par certains moteurs de recherche pour classer le site.

### Meta description

Cet attribut est utilisé par les moteurs de recherche pour indexer la page.

### Meta index

Cet attribut permet de définir si cette page doit être indexée par le moteur de recherche.

### Meta follow

Cet attribut permet de définir si le moteur de recherche peut suivre les liens contenus dans la page pour indexer d'autres documents.

## Rôle nécessaire pour afficher la page

L'attribut rôle permet de définir quel rôle permet d'accéder à cette page. Par défaut la page est publique, si un rôle est sélectionné seul un utilisateur avec les rôles nécessaires peut voir cette page.

## Max age pour le cache de la réponse de la page

L'attribut max age permet de définir le temps durant lequel cette page restera en cache.

## Page source

L'attribut page source permet de créer une nouvelle page en copiant une page déjà créée.

## Identifiant du template

L'attribut identifiant du template permet de définir le template à utiliser pour créer la page.
Il vous faut soit l'attribut page source, soit identifiant template pour créer la page, ces attributs ne peuvent être vides en même temps. 
