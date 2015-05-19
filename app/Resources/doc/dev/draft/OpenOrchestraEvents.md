# Les évènements OpenOrchestra

OpenOrchestra dispatch plusieurs évènements que vous pouvez utiliser en créant des listeners ou subscribers qui écouteront ces évènements.
Ces évènements sont dispatchés la plupart du temps dans les controllers et sont beaucoup utilisés dans `LogBundle\EventSubscriber`
Il vous faut créer une méthode qui prend en paramètre l'évènement que vous écoutez et vous devez rattacher le nom de l'évènement que vous voulez catcher à votre méthode.

Par exemple dans votre subscriber :

    class ExempleSubscriber implements EventSubscriberInterface
    {
        /**
         * @param NodeEvent $event
         */
        public function nodeUpdate(NodeEvent $event)
        {
            $this->info('open_orchestra_log.node.update', $event->getNode());
        }
        
        /**
         * @return array The event names to listen to
         */
        public static function getSubscribedEvents()
        {
            return array(
                NodeEvents::NODE_UPDATE => 'nodeUpdate'
            );
        }
    }


## Editorial

### Noeud

Les fichiers des évènements des noeuds, zones et blocs sont dans `OpenOrchestra\ModelInterface\NodeEvents` et `OpenOrchestra\ModelInterface\Event\NodeEvent`.

* NodeEvent
    * Création d'un noeud : NODE_CREATION
    * Suppression d'un noeud : NODE_DELETE
    * Modification d'un noeud  : NODE_UPDATE
    * Duplication d'un noeud : NODE_DUPLICATE
    * Ajout d'une langue à un noeud : NODE_ADD_LANGUAGE
    * Changement de status d'un noeud : NODE_CHANGE_STATUS
    * Modification du chemin du noeud : PATH_UPDATED

* NodeEvent : Area
    * Modification d'une zone : NODE_UPDATE_AREA
    * Suppression d'une zone : NODE_DELETE_AREA

* NodeEvent : Block
    * Modification d'un bloc : NODE_UPDATE_BLOCK
    * Mis à jour de la position d'un bloc : NODE_UPDATE_BLOCK_POSITION
    * Suppression d'un bloc : NODE_DELETE_BLOCK

### Template

Les fichiers des évènements des templates sont dans `OpenOrchestra\ModelInterface\TemplateEvents` et `OpenOrchestra\ModelInterface\Event\TemplateEvent`.

* TemplateEvent
    * Création d'un template : TEMPLATE_CREATE
    * Suppression d'un template : TEMPLATE_DELETE
    * Modification d'un template : TEMPLATE_UPDATE
    * Suppression d'une zone dans un template : TEMPLATE_AREA_DELETE
    * Modification d'une zone dans un template : TEMPLATE_AREA_UPDATE


### Média

Les fichiers des évènements des dossiers et médias sont dans `OpenOrchestra\Media\MediaEvents` et `OpenOrchestra\Media\FolderEvents` pour les fichiers contenants les noms des évènements.
Les évènements sont dans `OpenOrchestra\Media\Event\FolderEvent` et `OpenOrchestra\Media\Event\MediaEvent`.

* FolderEvent
    * Création d'un dossier : FOLDER_CREATE
    * Suppression d'un dossier : FOLDER_DELETE
    * Modification d'un dossier : FOLDER_UPDATE

* MediaEvent
    * Ajouter une image : ADD_IMAGE
    * Supprimer une image : MEDIA_DELETE
    * Crop une image : MEDIA_CROP

* ImagickEvent permet de récupérer le nom absolu du média et son contenu.
    * Modifier une image : RESIZE_IMAGE

ImagickEvent est utilisé lors de l'upload des médias.


### Contenu

Les fichiers des évènements des contenus sont dans `OpenOrchestra\ModelInterface\ContentEvents` et `OpenOrchestra\ModelInterface\Event\ContentEvent`.

* ContentEvent
    * Création d'un contenu : CONTENT_CREATION
    * Suppression d'un contenu : CONTENT_DELETE
    * Modification d'un contenu  : CONTENT_UPDATE
    * Duplication d'un contenu : CONTENT_DUPLICATE
    * Changement de status d'un contenu : CONTENT_CHANGE_STATUS

## Administration

### Type de contenu

Les fichiers des évènements des types de contenus sont dans `OpenOrchestra\ModelInterface\ContentTypeEvents` et `OpenOrchestra\ModelInterface\Event\ContentTypeEvent`.

* ContentTypeEvent
    * Création d'un type de contenu : CONTENT_TYPE_CREATE
    * Suppression d'un type de contenu : CONTENT_TYPE_DELETE
    * Modification d'un type de contenu : CONTENT_TYPE_UPDATE

### Keyword

Les fichiers des évènements des tags dans `OpenOrchestra\ModelInterface\KeywordEvents` et `OpenOrchestra\ModelInterface\Event\KeywordEvent`.

* KeyWordEvent
    * Création d'un tag : KEYWORD_CREATE
    * Suppression d'un tag : KEYWORD_DELETE

### Redirection

Les fichiers des évènements des redirections sont dans `OpenOrchestra\ModelInterface\RedirectionEvents` et `OpenOrchestra\ModelInterface\Event\RedirectionEvent`.

* RedirectionEvent
    * Création d'une redirection : REDIRECTION_CREATE
    * Suppression d'une redirection : REDIRECTION_DELETE
    * Modification d'une redirection : REDIRECTION_UPDATE

### Rôle

Les fichiers des évènements des rôles sont dans `OpenOrchestra\ModelInterface\RoleEvents` et `OpenOrchestra\ModelInterface\Event\RoleEvent`.

* RoleEvent
    * Création d'un rôle : ROLE_CREATE
    * Suppression d'un rôle : ROLE_DELETE
    * Modification d'un rôle : ROLE_UPDATE

### Site

Les fichiers des évènements des sites sont dans `OpenOrchestra\ModelInterface\SiteEvents` et `OpenOrchestra\ModelInterface\Event\SiteEvent`.

* SiteEvent
    * Création d'un site : SITE_CREATE
    * Suppression d'un site : SITE_DELETE
    * Modification d'un site : SITE_UPDATE

### Status

Les fichiers des évènements des status sont dans `OpenOrchestra\ModelInterface\StatusEvents` et `OpenOrchestra\ModelInterface\Event\StatusEvent`.

* StatusEvent
    * Création d'un status : STATUS_CREATE
    * Suppression d'un status : STATUS_DELETE
    * Modification d'un status : STATUS_UPDATE

* StatusableEvent
    * Changement d'un status : STATUS_CHANGE

StatusableEvent est utilisé lors du changement de status des noeuds, contenus et des références des médias.
    

### Thème

Les fichiers des évènements des thèmes sont dans `OpenOrchestra\ModelInterface\ThemeEvents` et `OpenOrchestra\ModelInterface\Event\ThemeEvent`.

* ThemeEvent
    * Création d'un thème : THEME_CREATE
    * Suppression d'un thème : THEME_DELETE
    * Modification d'un thème : THEME_UPDATE

### Utilisateur

Les fichiers des évènements des groupes et utilisateurs sont dans `OpenOrchestra\UserBundle\GroupEvents` et `OpenOrchestra\UserBundle\UserEvents` pour les noms des évènements.
Les évènements sont dans `OpenOrchestra\UserBundle\Event\GroupEvent` et `OpenOrchestra\UserBundle\Event\UserEvent`.

* GroupEvent
    * Création d'un groupe : GROUP_CREATE
    * Suppression d'un groupe : GROUP_DELETE
    * Modification d'un groupe : GROUP_UPDATE

* UserEvent
    * Création d'un utilisateur : USER_CREATE
    * Suppression d'un utilisateur : USER_DELETE
    * Modification d'un utilisateur : USER_UPDATE
    * Modification du mot de passe d'un utilisateur : USER_CHANGE_PASSWORD

## Exemple de dispatch d'un évènement

Utilisation d'un NodeEvent :

    $this->get('event_dispatcher')->dispatch(NodeEvents::NODE_UPDATE, new NodeEvent($node));

Utilisez la méthode de symfony `dispatch` et mettez en paramètre le nom de l'évènement et l'évènement lui-même.
Ensuite mettez en place un listener ou un subscriber qui écoutera l'évènement.
