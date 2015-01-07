# I/ LE STOCKAGE DES MEDIAS DANS ORCHESTRA
Dans Orchestra les médias sont stockés par défaut sur le serveur web. Cependant selon les besoins du projet, il peut être nécessaire de stocker les médias ailleurs, dans le cloud par exemple. Orchestra utilise donc une couche d'abstraction pour réaliser le stockage et la lecture des médias, cette couche reposant sur le bundle knp Gaufrette. Gaufrette dispose de nombreux adapteurs pour stocker les fichiers selon différents protocoles / filesystems. Ce bundle est de plus extensible afin de pouvoir répondre à n'importe quelle problématique spécifique en développant l'adapteur adéquat.
Si le projet nécessite de changer la méthode de stockage des fichiers, il suffit donc uniquement de reconfigurer Gaufrette. (*conf gaufrette et mediabundle à décrire*)

# II/ PROCESS D'UPLOAD ET DE REDIMMENSIONNEMENT
Les images contribuées dans la médiathèque peuvent être disponibles en front sous plusieurs formats/ratios. Cependant les contributeurs n'ont pas à uploader toutes ces variantes, celles-ci sont automatiquement générées par Orchestra à partir de l'unique média uploadé par le contributeur.
Pour celà l'intégrateur peut spécifier dans la conf d'Orchestra *(conf à décrire)* les différents formats requis par le front.

Si certaines variantes générées ne sont pas satisfaisantes, le contributeur peut utiliser à posteriori l'outil de cropping de la médiathèque pour générer lui-même la variante.

Le process de base est le suivant :
* 1/ Upload et paramètrage du média depuis la médiathèque
* 2/ A la réception du média, Orchestra génère les différentes variantes paramétrées en conf (via Imagik). Tous ces fichiers sont stockés via l'adapteur gaufrette configuré (local filesystem par défaut)
* 3/ Ultérieurement et en dehors de cette séquence, un contributeur peut utiliser l'outil de cropping de la médiathèque pour surcharger une ou plusieurs des variantes automatiquement générées par Orchestra. Dans ce cas Orchestra commence par récupérer en local dans le /tmp le média originel stocké via gaufrette puis stocke toujours par l'intérmédiaire de gaufrette la nouvelle version croppée, écrasant ainsi l'ancienne version.

# III/ AFFICHAGE EN FRONT
Dans la mesure où la méthode de stockage des médias peut ou ne peut pas autoriser l'accès direct aux médias depuis un navigateur web selon les cas, le process d'affichage est un peu plus complexe qu'un simple lien vers la ressources désirée. A la place on a un lien vers un contrôleur symphony (*A préciser*) qui réalise un file_get_contents et sert le contenu récupéré avec les entêtes http correspondantes. De cette manière, en s'appuyant sur l'adapteur gaufrette défini pour le stockage, le média est à nouveau servi de manière universelle sans ajustement à prévoir lors de l'intégration. Aucun code particulier n'est nécessaire pour la récupération des médias, la conf de l'adapteur ayant déjà été réalisée pour le stockage.
