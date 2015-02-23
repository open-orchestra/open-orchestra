## Le stockage des médias
Dans Orchestra, les médias sont stockés par défaut sur le serveur web. Cependant selon les besoins du projet, il peut être nécessaire de les stocker ailleurs, sur un serveur externe, dans le cloud par exemple.
Orchestra utilise donc une couche d'abstraction pour réaliser le stockage et la lecture des médias, cette couche reposant sur [le KnpGaufretteBundle](https://github.com/KnpLabs/KnpGaufretteBundle).
Gaufrette dispose de nombreux adapteurs pour stocker les fichiers selon différents protocoles / filesystems. Ce bundle est de plus extensible afin de pouvoir répondre à n'importe quelle problématique spécifique en développant l'adapteur adéquat.
Si le projet nécessite de changer la méthode de stockage des fichiers uploadés, pour les placer sur un ftp externe par exemple, il y a juste deux configurations simples à effectuer :

1. Paramétrer l'adapteur de Gaufrette au niveau de l'application ([cf documentation de KnpGaufretteBundle](https://github.com/KnpLabs/KnpGaufretteBundle#configuration))
2. Paramétrer Orchestra pour indiquer à la médiathèque l'adapteur à utiliser (d'autres adapteurs pourraient être utilisés dans l'application pour des besoins indépendants de la médiathèque)
Pour celà, il faut surcharger le paramètre open_orchestra_media.filesystem en indiquant le nom du filesystem défini pour la médiathèque dans la conf de gaufrette au point précédent

## Process d'upload et redimmensionnement
Les images contribuées dans la médiathèque peuvent être disponibles en front sous plusieurs formats/ratios. Cependant les contributeurs n'ont pas à uploader toutes ces variantes, celles-ci sont automatiquement générées par Orchestra à partir de l'unique média uploadé par le contributeur.
L'intégrateur a la possibilité de spécifier dans la configuration d'Orchestra *(conf à décrire)* les différents formats requis par le front sur son projet.

Si certaines variantes générées ne sont pas satisfaisantes, le contributeur peut utiliser à posteriori l'outil de cropping de la médiathèque pour générer lui-même la variante.

Le processus de contribution d'un média est le suivant :

1. Upload et paramètrage du média depuis la médiathèque
2. A la réception du média, Orchestra génère par Imagik les différentes variantes paramétrées en conf par l'intégrateur. Tous ces fichiers sont stockés via l'adapteur gaufrette configuré précédement (local filesystem par défaut)
3. Ultérieurement et en dehors de cette séquence, un contributeur peut utiliser l'outil de cropping de la médiathèque pour redécouper une ou plusieurs des variantes automatiquement générées par Orchestra.
Dans ce cas Orchestra commence par récupérer en local dans le /tmp le média originel stocké via gaufrette. Le contributeur peut alors travailler sur un crop manuel de ce média. Quand il valide son travail, Orchestra stocke par gaufrette la nouvelle version, écrasant ainsi l'ancienne.

## Affichage en front
Dans la mesure où la méthode de stockage des médias peut ou ne peut pas autoriser l'accès direct aux médias depuis un navigateur web, le process d'affichage est un peu plus complexe qu'un simple lien vers la ressource désirée.
Ce travail de récupération de média est effectué par le contrôleur OpenOrchestra\MediaBundle\Controller\MediaController, par la méthode getAction(). Cette méthode reçoit l'identifiant de stockage du média désiré et retourne le contenu du média avec les entêtes nécessaires à son affichage.
Quelque soit le fichier issu de la médiathèque qu'on cherche à servir, il suffit donc de générer un lien sur la route 'php_orchestra_media_get' en indiquant la clé de stockage du média pour que celui-ci soit renvoyé au client.
