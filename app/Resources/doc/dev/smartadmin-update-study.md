Suite à l'étude de la portabilité de smart admin dans sa nouvelle version, voici un compte-rendu qui aurait mal passé par Trello !

**Remarques préliminaires**

Une nouvelle version de smart admin va être dispo sur la seconde moitié d'octobre, il faudra la récupérer dès que possible pour ne pas ré-accumuler une dette comme celle qu'on a à présent. Je pense qu'on peut néanmoins intégrer dès maintenant la version dont on dispose sans attendre la suivante, le gap sera moins douloureux à combler si on procède par itérations.

Parmi les versions de smart admin utilisables, il y avait un dilemme entre continuer avec la version ajax déjà en place et switcher sur la version html basique. Après étude, il s'avère que le code est identique, seule la conf js change. Je propose donc qu'on parte sur la version html.

Un autre choix est à faire quand au fonctionnement global du design en BO. Sur le site de démo, on peut jouer avec la conf via le bloc de settings qui pop à droite (bloc beige de la roue dentée). Pour cette étude j'ai retenu les options 'fixed header, fixed navigation, fixed ribbon'. A noter la présence d'un nouveau comportement me semble-t'il : 'menu on top'. Le report correct des tags générés dans notre layout a rescussité le scroll sur le menu de gauche.

L'archive complète propose les fichiers less des css publiées dans chaque version de smart admin (ajax, html, php, etc ...). Comme NicoT l'a proposé, il pourrait être intéressant de les intégrer à notre grunt, mais je préconise d'étudier cet aspect dans un second temps, quand le redressement de smart admin sera effectif et poussé sur gitHub.

J'ai commencé sur mon local une migration 'à la sauvage' (quand on veut faire pro on dit un proto ). Voici mes remarques.


**Réécriture de code**

Plusieurs éléments html nécessitent une réécriture de code pour suivre l'évolution de smart admin (header, user-box, left menu, etc...) Cela ne devrait cependant pas être trop délicat, la structure générale étant restée la même.


**Nouveautés à intégrer**

De nouveaux éléments ont été ajoutés, j'ai remarqué principalement :

* un footer
* des shorcuts au clic sur le user
* un bout de code spécifique pour IE8 affichant un message pour télécharger une version plus récente du navigateur (problèmes à venir avec cette restriction ?)
* une nouvelle lib js : pace.js. Cette lib permet l'ajout de loaders dynamiques lors du chargement des pages. Sur le smart admin de démo on a une jolie barre de chargement sur les 2 ou 3 premières rangées de pixels en haut de l'écran. Cependant cette barre s'active sur les changements de dom plutôt que sur les chargements ajax => voir s'il est possible d'en faire notre loader ajax générique.

Il faut donc prévoir du temps pour inclure ces éléments.

Dans le même ordre d'idée, des éléments précédemment existants ont été perdus lors de la refacto de cet été. J'ai noté :

* le titre présent dans le corps de page, accompagné d'un picto propre à l'univers concerné
* les boutons 'jarvis-widget' situés en haut à droite des tables, qui permettaient par exemple de passer les tableview en pleine page ou d'en changer la couleur.

Il faut donc aussi prévoir du temps pour réintégrer ces éléments.


**Nettoyage de code**

Comme la version de smart admin actuellement en place n'est pas issue directement d'une archive propre, mais d'un code présent sur une version de dev de phpfactory, nous n'étions pas certains de ce qui était natif et de ce qui avait été bricolé pour phpfactory. Nous disposons maintenant d'une archive exhaustive, nous pouvons donc faire le tri entre ce qui est à conserver/refacto et ce qui doit disparaître. Cela concerne notamment les assets encore présents dans cmsbundle.

De plus toutes les librairies proposées par smartadmin ne seront pas utilisées (chart pie, GMaps skins, etc ...) La plupart des libs à ne pas inclure est évidente, mais pour certaines la question se pose (lib de comportement pour devices mobiles, jquery-validate, etc ...) Point à creuser.


**Bugs**

La mise à jour des html/js/css ne s'est pas trop mal passée sur mon local, néanmoins j'ai quand même noté quelques bugs à corriger :

* la fonction nav_page_height n'existe plus, il faudra donc trouver un substitut quand nous nous en servons, si toutefois c'est encore nécessaire
* la page affiche un scroll horizontal pour seulement 1px de trop => débusquer d'où sort ce pixel récalcitrant
* les pictos + situés dans le menu pour déplier les branches ne sont pas visibles, alors que les - le sont. Est-ce juste un problème sur le picto ou plus profond sur le js ? => à creuser


**Recette globale smart admin**

Une fois tous ces points solutionnés, je préconise une petite recette fonctionnelle effectuée par un œil externe au dev (le PO ?) pour valider que le BO fonctionne correctement.
