# I/ PROCESS D'UPLOAD ET DE REDIMMENSIONNEMENT

Les images contribuées dans la médiathèque peuvent être disponibles en front sous plusieurs formats/ratios. Cependant les contributeurs n'ont pas à uploader toutes ces variantes, celles-ci sont automatiquement générées par Orchestra à partir de l'unique média uploadé par le contributeur.
Pour celà l'intégrateur peut spécifier dans la conf d'Orchestra *(conf à décrire)* les différents formats dont le front a besoin.

Si certaines variantes générées ne sont pas satisfaisantes, le contributeur peut utiliser à posteriori l'outil de cropping pour générer lui-même la variante.

Le process de base est le suivant :
* 1/ Upload et paramètrage du média depuis la médiathèque
* 2/ A la réception du média, Orchestra génère les différentes variantes paramétrées en conf (via Imagik)
* 3/ Les variantes ainsi que l'originale sont déplacées dans leur répertoire de stockage, là où elles pourront être consultées par le web
* 4/ Ultérieurement et en dehors de cette séquence, un contributeur peut utiliser l'outil de cropping de la médiathèque pour surcharger une ou plusieurs des variantes automatiquement générées par Orchestra.

# II/ Stockage des médias
Basiquement le stockage des médias se fait sur le serveur web. Cependant pour des usages plus avancés (stockage externe dans le cloud par exemple (Amazon S3 ou autre)) le bundle KNPGaufrette est utilisé. Une conf spécifique dans MediaBundle permet d'indiquer le filesystem utilisé pour la médiathèque. Par défaut Orchestra utilise l'adapter local filesystem.
Dans la mesure où les médias peuvent potentiellement être stockés ailleurs qu'en local, l'utilisation de la fonctionnalité de crop commence par le rappatriement en local du fichier via la méthode read($key) des adapters.

Il reste à étudier le cas de l'affichage des médias, Gaufrette ne fournissant pas de méthode générique pour retrouver l'url à une ressource uploadée.
