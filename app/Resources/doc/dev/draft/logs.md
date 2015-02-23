# I/ Les logs

Un tableau de logs s'affiche dans la partie administration du backoffice.
Il affiche la date et l'heure, l'ip de l'utilisateur, le nom de l'utilisateur, le nom du site courant et le message de log.

Le LogBundle est dans openorchestra-cmsbundle.

# II/ Configuration

Dans app/config/log.yml se trouve la configuration des logs. Ce fichier de configuration nous permet de déclarer des handlers.
Les handlers déterminent où enregistrer les logs, le type d'information à enregistrer et les channels.

Afin d'enregistrer les logs dans mongoDb, il nous faut définir un handler avec les informations de connection à la base et le nom de la collection.
Le level détermine le type d'information enregistrée dans les logs, 200 correspond
à information, mais il y a aussi debug, erreur etc...

    mongo:
        type: mongo
        level: 200
        mongo:
            host: "localhost"
            database: "%php_orchestra_cms.mongodb.database%"
            collection: log
        channels: [openorchestra]

Les channels correspondent aux canaux dans lesquels sont écrits les logs. Si aucun channel est enregistré alors les logs sont écrits dans tous les
canaux. Il est possible de mettre plusieurs canaux, ou d'exclure certain canaux.
Les services qui ont le channel openorchestra écrivent que dans ce canal et notre handler affiche que ce qui est écrit dans le canal openorchestra.

# III/ Processor

Le logger qui permet d'enregistrer les logs a toujours la date et l'heure. Pour enregistrer l'adresse ip et le nom
de l'utilisateur nous avons créé un processor. Nous avons donné le channel openorchestra au processor pour qu'à chaque log
écrit dans ce channel il passe dans le processor.

Le processor doit être taggé par:

    tags:
        - { name: monolog.processor, method: processRecord, channel: openorchestra }

# IV/ Logger

Les services qui écrivent les logs doivent avoir : `Symfony\Bridge\Monolog\Logger`

Et être taggés par :

    tags:
        - { name: monolog.logger, channel: openorchestra }

Dans OpenOrchestra lorsqu'une action comme la modification d'un noeud est effectuée un évènement est créé et c'est lui qui écrit les messages des logs.
Le message des logs prend une clé de traduction et un tableau de context. Ensuite dans les fichiers de traduction nous écrivons les messages.

Comme suit : `Update a node with node id node_id, node version node_version and node language node_language`

Les variables comme node_id sont les clés du tableau de context et seront remplacées par la valeur lors de l'affichage.

Les évènements qui écrivent dans les logs sont dans : `LogBundle\EventSubscriber`

# V/ L'affichage

Le fichier de vue du tableau qui affiche les logs est dans : `BackofficeBundle\Resources\views\AdministrationPanel\logs.html.twig`

Les facades et transformers sont dans : `LogBundle\Facade` et `LogBundle\Transformer`
