# I/ Contexte

Dans le cadre du left Panel, il doit être possible pour un intégrateur de rajouter une entrée simplement.

# II/ Usage

## Création de la stratégie

Pour cela il faut créer un service qui implémente : `OpenOrchestra\Backoffice\LeftPanel\LeftPanelInterface`.
Voir la classe OpenOrchestra\Backoffice\LeftPanel\Strategies\AdministrationPanelStrategy pour un exemple d'implémentation.

Puis le tagger avec `open_orchestra_backoffice.left_panel.strategy` : 
    
    tags:
        - { name: open_orchestra_backoffice.left_panel.strategy }

## Affichage du menu

L'affichage de l'élément de menu est réalisé par la méthode show() de LeftpanelInterface qui doit renvoyer la chaine HTML correspondante.

Le lien du menu doit avoir les attributs suivants :

* href : une ancre qui correspond à la route utilisée par backbone
* id : concaténation de "nav-" et du nom de la stratégie tel que renvoyé par `getName()`
* data-url : url correspondant aux données à afficher lors du clic sur le menu 

# III/ Spécificité

Il est possible de définir de nouvelles catégories en rajoutant les clés de traduction adéquates.

Il est possible de réordonner les différents éléments du menu en jouant sur le poids via la méthode `getWeight()` de `LeftpanelInterface`,
les éléments de poids plus important étant affichés en dernier.

La méthode `getParent()` de la stratégie permet d'établir une hiérarchie de menus en définissant le nom du menu parent.
La racine du menu est le noeud de nom `administration`.

La restriction d'accès à un élément du menu se fait en définissant un rôle spécifique dans la méthode `getRole()`.
