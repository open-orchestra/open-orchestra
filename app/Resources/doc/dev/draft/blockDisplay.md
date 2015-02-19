## Principe d'indépendance d'affichage

En Front Office, certains blocs peuvent avoir besoin d'habillage et de fonctionnement client qui leur soient propres.
Afin de conserver leur logique d'autonomie par rapport au reste de la page, ils doivent pouvoir récupérer eux-même les feuilles de style et le code javascipt dont ils ont besoin.
Pour ce faire l'usage de requireJs est conseillé.


## Exemple d'utilisation : le bloc Gallery

Dans le DisplayBundle, le répertoire Ressources/views/Block contient les templates d'affichage Front des différent blocs.
Le fichier Gallery/show.html.twig se termine par deux lignes permettant le chargement dynamique des fichiers js et css associés à l'affichage du bloc Gallery.
La première fait un appel explicite à requireJs et indique de charger, une fois requireJs chargé, le fichier de comportement du bloc : loadJs.js.

    [script data-main="{{ asset('/bundles/phporchestradisplay/block/Gallery/js/loadJs.js') }}" src="{{ asset('/bundles/phporchestradisplay/libs/require.js') }}"][/script]

La seconde ligne charge directement le fichier de gestion des css : loadCss.

    [script src="{{ asset('/bundles/phporchestradisplay/block/Gallery/js/loadCss.js') }}"][/script]

Chacun de ces deux fichiers utilise la fonction requireJs. Celle-ci permet de spécifier dans un premier temps les fichiers nécessaires à l'éxecution du code principal, puis de décrire ce code principal à éxecuter quand tous les prérequis sont chargés.

Dans notre exemple, la galerie utilise le plugin jQuery fancybox. Le fichier loadJs déclare donc avoir besoin de jQuery, puis des différents fichiers qui composent le plugin fancybox. Le code principal décrit lui les actions à réaliser quand ces fichiers auront été chargés, permettant ainsi le fonctionnement de la galerie.

La galerie utilise également son propre css. Le fichier loadCss utilise donc aussi requireJs pour réclamer la librairie requireCss qui permet de charger à la volée des feuilles de style. Quand cette librairie est chargée, le code principal de loadCss récupère les css nécessaires à l'habillage de la galerie.

## Maintenabilité des blocs

Afin de garder une cohérence entre les différents blocs, il est proposé d'utiliser l'arborescence de fichiers suivante :

    |_ MonBundle
        |_ Resources
            |_ public
            |   |_ block
            |   |   |_ NomDeMonBloc
            |   |       |_ css
            |   |       |   |_ * Placez ici les fichiers css de votre bloc *
            |   |       |
            |   |       |_ js
            |   |       |   |_ * Placez ici les fichiers javascript de votre bloc. Ceci comprend notamment les fichiers de chargement de js et de css que vous pouvez nommer loadJs.js et loadCss.js
            |   |       |
            |   |       |_ img
            |   |           |_ * Placez ici les fichiers image de votre bloc *
            |   |
            |   |_ libs
            |       |_ * Placez ici les librairies communes à plusieurs blocs *
            |
            |_ views
                |_ Block
                    |_ NomDeMonBloc
                        |_ * Placez ici les templates d'affichage de votre bloc *
