## Contenu
* ContentList
    * Affiche une liste de contenus répondant à des critères paramétrés
    * Front : Ok

* Content
    * Affiche un contenu en pleine page dont l'id est passé dans l'url
    * Front : [Symfony plante car pas de strategy d'affichage trouvée] (https://trello.com/c/tVDlIjW1/579-fo-bloc-content-plantage-symfony-strategy-not-found)

* ConfigurableContent
    * Choix d'un contenu spécifique à afficher
    * Front : Pas d'habillage, brut de décoffrage attribute : value

* TinyMCEWysiwyg
    * Contribution de Rich Text
    * Front : Ok

## Medias
* Carrousel
    * Carrousel (auto-défilant) constitué de plusieurs images contribuées dans la médiathèque
    * Front : 
        * [Le FO plante car pas de carrouselId alors qu'il est bien contribué](https://trello.com/c/tbLKZ7Wu/583-fo-bloc-carrousel-plantage-si-pas-de-carrouselid-contribue)
        * [Ko => js obsolète à réintégrer](https://trello.com/c/pp3aAC1v/539-etq-ufront-le-rendu-du-block-carroussel-est-different-de-l-actuel-et-fonctionnel) (même js que gallery ?)

* Gallery
    * Médiathèque paginée constituée de plusieurs images contribuées dans la médiathèque
    * Front : Ok mais point de contribution à revoir sur l'intégration front : nombre de col + largeur VS uniquement images flottantes

* Video
    * Contribution d'une vidéo youtube, dailymotion ou vimeo
    * Front : Ok

* MediaListByKeyword
    * Affiche une liste de médias selon un mot clé
    * Back : [Erreur à la soumission du formulaire](https://trello.com/c/ySA4rltQ/597-bo-bloc-contentlist-plantage-a-la-soumission)
    * Front :
        * Le bloc plante parce qu'il n'y a pas de check sur l'existence des attributs
        * A rechecker quand le form sera réparé
        * Affichage à l'arrache : mode Gallery ?

## Navigation
* LanguageList
    * Affichage d'un selecteur de langue en FO permettant de naviguer entre les différentes langues du site
    * Front :
        * la mécanique ne tient pas compte des dernières évo sur le routing et les langues (ajout en brut d'un préfixe de langue)
        * Ramène sur la home plutôt que d'afficher le node courant dans la nouvelle langue

* Menu
    * Menu affichant le 1er niveau d'arborescence du site
    * Front : Ok

* SubMenu
    * Menu avec racine et profondeur
    * Front : [Le front plante systématiquement](https://trello.com/c/LJxf5nje/623-fo-bloc-submenu-plantage-error-call-to-a-member-function-getnodeid-on-a-non-object)

* Search
    * Affiche un outil de recherche
    * Back :
        * les libellés ne sont pas forcément intuitifs : value pour label et node id pour noeud d'affichage des résultats
        * [Le node devrait être sélectionnable dans un select](https://trello.com/c/M1NrSkEZ/586-bo-bloc-search-selection-du-node-d-affichage)
    * Front : [Le bloc fait planter symfony car il ne trouve pas l'attribut class bien que contribué en BO](https://trello.com/c/tbLKZ7Wu/583-fo-bloc-carrousel-plantage-pas-de-carrouselid-alors-que-bien-contribue)

* SearchResult
    * Affiche les résultats issus d'un bloc Recherche
    * Back : Les champs à contribuer ne sont pas du tout explicites (doc à produire ?)
    * Front : Incheckable car pas d'indexation

## Misc
* Header
    * Affichage d'un Header (Choix d'un media)
    * Front : Ok

* Footer
    * Affichage d'un Footer (Aucune contribution)
    * Front : Affichage indéterminé : rien ne plante, mais rien de particulier ne se passe non plus. Selon le code devrait afficher un menu
* Login
    * Connexion / Profil
    * Front : minimaliste mais Ok

* AddThis
    * Partage social via AddThis
    * Back : contribution peu explicite (Ajout de doc ?)
    * Front : Ok

* AudienceAnalysis
    * Taggage Xiti/Google Analytics
    * Front : Ok

* Gmap
    * Affiche une google map centrée sur point configuré
    * Back : [La contribution n'est pas triviale et pourrait être améliorée](https://trello.com/c/2E7e9zds/587-bo-bloc-gmap-amelioration-de-contribution)
    * Front : Ok

* Contact
    * Formulaire de contact
    * Back : Champ form indéterminé
    * Front : Le submit envoie sur /contact/send en dur

## A supprimer
* Sample
    * Bloc de test pour le développement de la mécanique des blocs devant être supprimé
    * Front : ?

* News
    * Bloc de test d'affichage d'un contenu spécifique (vu de l'intégrateur)
    * Front : ?
