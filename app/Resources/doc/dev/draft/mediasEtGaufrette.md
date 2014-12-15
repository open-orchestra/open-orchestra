# I/ PROCESS D'UPLOAD ET DE REDIMMENSIONNEMENT

Les images contribuées dans la médiathèque peuvent être disponibles en front sous plusieurs formats/ratios. Cependant les contributeurs n'ont pas à uploader toutes ces variantes, celles-ci sont automatiquement générées par Orchestra à partir de l'unique média uploadé par le contributeur.
Pour celà l'intégrateur peut spécifier dans la conf d'Orchestra *(conf à décrire)* les différents formats dont le front a besoin.

Si certaines variantes générées ne sont pas satisfaisantes, le contributeur peut utiliser à posteriori l'outil de cropping pour générer lui-même la variante.

Le process de base est le suivant :
* 1/ Upload et paramètrage du media depuis la médiathèque
* 2/ A la réception du média, Orchestra génère les différentes variantes paramétrées en conf (via Imagik)
* 3/ Les varaiantes ainsi que l'originale sont déplacées dans leur répertoire de stockage, là où elles pourront être consultées par le web
* 4/ Ultérieurement et en dehors de cette séquence, un contributeur peut utiliser l'outil de cropping de la médiathèque pour surcharger une ou plusieurs des variantes automatiquement générées par Orchestra.

# II/ Stockage des médias
Basiquement le stockage des médias se fait sur le serveur web. Cependant pour des usages plus avancés (stockage externe dans le cloud par exemple (Amazon S3 ou autre)) le bundle KNPGaufrette peut être activé. Une conf spécifique dans MediaBundle permet d'indiquer si oui ou non le Bundle doit-être activé pour la médiathèque. Dans ce cas la conf de MediaBundle indique également quel adapteur doit être utilisé. L'adapteur lui est configuré dans le app/config.

Le process de contribution des médias décrit en I est alors altéré : si gaufrette est activé, les médias ne sont plus déplacés en local, mais via l'adapteur sélectionné.