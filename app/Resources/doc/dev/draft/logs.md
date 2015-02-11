# I/ Les logs

Un tableau de log s'affiche dans la partie administration du backoffice.
Il affiche la date et l'heure, l'ip de l'utilisateur, le nom de l'utilisateur, le nom du site courrant et le message de log.

Le LogBundle est dans dans phporchestra-cmsbundle.

# II/ Configuration

Dans app/config/log.yml ce trouve la configuration des logs. Ce fichier de configuration nous permet de déclarer des handlers.
Les handlers détermine ou enregistrer les logs, le type d'information a enregistrer et des channels.

Nous enregistrons les logs dans mongoDB nous avons donc un handler de type mongo, avec les informations de connection à la base et
la collection dans laquelle enregistrer les logs. Le level détermine le type d'information enregistrer dans les logs, 200 correspond
à information, mais il y a aussi debug, erreur etc...

    mongo:
        type: mongo
        level: 200
        mongo:
            host: "localhost"
            database: "%php_orchestra_cms.mongodb.database%"
            collection: log
        channels: [phporchestra]

# III/ Processor

Le logger qui permet d'enregistrer les logs à toujour la date et l'heure, mais pour pouvoir enregistrer l'adresse ip et le nom
de l'utilisateur nous avons créé un processor. Nous avons donné le channel phporchestra au processor pour qu'à chaque que des
logs vont être écrit dans ce channel il passe dans le processor.

Le processor doit être taggé par:

    tags:
        - { name: monolog.processor, method: processRecord, channel: phporchestra }

# IV/ Logger

Les services qui écrivent les logs doivent avoir : `Symfony\Bridge\Monolog\Logger`

Et être taggé par :

    tags:
        - { name: monolog.logger, channel: phporchestra }

Dans PhpOrchestra lorsqu'un action comme la modification d'un noeud est effectué un évènement est créé et c'est lui qui écrit les messages des logs.
Le message des logs prends une clé de traduction et un tableau de context, ensuite dans les fichiers de traduction nous écrivons les messages.

Comme suit : `Update a node with node id node_id, node version node_version and node language node_language`

Les variables comme node_id sont les clé du tableau de context et sera remplacé par la valeur lors de l'affichage.

Les évènement qui écrivent dans les logs sont dans : `LogBundle\EventSubscriber`

# V/ L'affichage

Le fichier de vue du tableau qui affiche les logs est dans : `BackofficeBundle\Resources\views\AdministrationPanel\logs.html.twig`

Les facades et transformer sont dans : `LogBundle\Facade` et `LogBundle\Transformer`
