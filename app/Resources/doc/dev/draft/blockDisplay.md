## Principe d'indépendance d'affichage

En Front Office, certains blocs peuvent avoir besoin d'habillage et de fonctionnement client qui
leur soient propres. Par exemple le bloc carrousel propose une navigation entre les médias par clic
qui nécessite du javascript 'de fonctionnement'. De même pour avoir ce comportement de scrolling,
le bloc a besoin d'une css particulière, à vocation fonctionnelle et donc indépendante du thème.
Afin de conserver leur logique d'autonomie par rapport au reste de la page, les blocs doivent donc
pouvoir récupérer eux-même les feuilles de style et le code javascipt dont ils ont besoin pour leur
fonctionnement.
Pour répondre à ce problème le layout principal de node charge la librairie requireJs permettant
ainsi à chaque bloc de la page de faire appel à la fonction require().
En complément, pour permettre le chargement dynamique des css, Open Orchestra propose un module AMD
à utiliser conjointement à requireJs : openOrchestraCss.


## Exemple d'utilisation : le bloc Gallery

Dans le MediaBundle, le répertoire Resources/views/Block contient les templates d'affichage Front
des blocs Media.
Le fichier Gallery/show.html.twig se termine par le chargement du fichier blockLoader.js réclamant
le chargement dynamique des js et css associés à l'affichage du bloc Gallery.

    [script src="{{ asset('/bundles/openorchestramedia/block/Gallery/blockLoader.js') }}"][/script]

Comprenant la desciption de deux fonctions javascript, ce fichier utilise requireJs pour charger
les prérequis à l'initialisation du bloc, puis quand les prérequis sont chargés, lance l'initialisation.
Celle-ci comprend l'éxécution de javascript mais également le chargement de css via le module
openOrchestraCss.

## Maintenabilité des blocs

Afin de garder une cohérence entre les différents blocs, il est proposé d'utiliser l'arborescence de
fichiers suivante :

    |_ MonBundle
        |_ Resources
            |_ public
            |   |_ block
            |   |   |_ NomDeMonBloc
            |   |       |_ css
            |   |       |   |_ * Placez ici les fichiers css de votre bloc *
            |   |       |
            |   |       |_ js
            |   |       |   |_ * Placez ici les fichiers javascript de votre bloc *
            |   |       |
            |   |       |_ img
            |   |       |   |_ * Placez ici les fichiers image de votre bloc *
            |   |       |
            |   |       |_ blockLoader.js * Le fichier de chargement du bloc, chargeant les js et css spécifiques * 
            |   |
            |   |_ libs
            |       |_ * Placez ici les librairies communes à plusieurs blocs *
            |
            |_ views
                |_ Block
                    |_ NomDeMonBloc
                        |_ * Placez ici les templates d'affichage de votre bloc *
