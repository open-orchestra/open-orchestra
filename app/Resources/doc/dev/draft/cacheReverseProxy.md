## Le cache partagé dans OpenOrchestra
Le système de bloc est au coeur de la génération des pages dans Open Orchestra. Afin d'exploiter au maximum les possibilités de mise en cache que ce découpage peut offrir, tous les blocs sont rendus via le helper twig render_esi. Si le reverse proxy utilisé est Symfony, le fonctionnement est standard. Mais si Varnish est utilisé, les fonctionnalités de cache et de décache deviennent plus puissantes.
Deux axes de gestion du cache sont utilisés dans Open Orchestra : la durée de vie et le tagage spécifique.

Lors de l'édition de chaque node et de chaque bloc, il est proposé au contributeur de renseigner une durée de vie associée au cache généré pour cet élément. De par l'utilisation des ESI, un bloc peut de fait avoir une durée de vie différente des autres blocs qui l'accompagnent, ainsi que de la page qui le contient. Le cache des nodes, et donc des pages, est systématiquement public. Par contre chaque bloc indique via sa stratégie d'affichage s'il est public ou privé, ce qui autorisera ou non son cachage dans la passerelle de cache.

Grâce au bundle [foshttpcache](http://foshttpcachebundle.readthedocs.org), le cache des pages ainsi que ceux des fragments des blocs sont taggés spécifiquement, ce qui permet une invalidation par tag précise et automatique, libérant ainsi le développeur et l'administrateur de la plateforme d'une purge complexe. Vous trouverez ci-dessous les tags automatiquement ajoutés selon le contexte.

### Tagage 
#### Node
Dans le cas d'un node, et donc d'une page, le cache est taggué par le nodeId, le nodeLanguage et le siteId.

#### Bloc
Tous les blocs sont taggués selon deux axes : une série de tags génériques communs à tous les blocs, et une série de tags spécifiques à chacun d'entre eux.

##### Tags génériques
Chaque bloc est taggué par le type de celui-ci (block-gallery, block-content, etc ...) Les blocs sont également taggués de manière systématique par les id des nodes qui les utilisent. Comme les blocs s'affichent différement selon les langues, la langue d'affichage est également utilisée comme tag. Enfin le site utilisé pour le rendu du bloc définit le dernier tag générique.

##### Tags spécifiques
Un bloc dont le cache doit être taggué spécifiquement peut le faire grâce à sa stratégie d'affichage, quand celle-ci surcharge la méthode getTags de l'abstractController.

Par défaut les caches des blocs sont privés pour éviter qu'un oubli de configuration ne mette en cache des données personnelles. Cependant un bloc peut aisément se déclarer public et ainsi autoriser le cache dans la passerelle de cache. Dans ce cas sa stratégie d'affichage doit surcharger la méthode isPublic.

Voici bloc par bloc, les spécifications de cache.

* Bloc AddThis
    * Type : privé
    * Tags : -

* Bloc AudienceAnalysis
    * Type : public
    * Tags : -

* Bloc Carrousel
    * Type : TODO
    * Tags : TODO

* Bloc Configurable Content
    * Type : public
    * Tags : contentType et contentId du contenu sélectionné

* Bloc Contact
    * Type : private
    * Tags : -

* Bloc ContentList
    * Type : public
    * Tags : contentId de chaque contenu correspondant et contentType de tous les types de contenus correspondant

* Bloc Content
    * Type : public
    * Tags : contentType et contentId du contenu affiché

* Bloc Footer
    * Type : public
    * Tags : nodeId de tous les noeuds présents dans le footer

* Bloc Gmap
    * Type : public
    * Tags : -

* Bloc LanguageList
    * Type : public
    * Tags : -

* Bloc Menu
    * Type : public
    * Tags : nodeId de tous les éléments présents dans le sous-menu

* Bloc SubMenu
    * Type : public
    * Tags : nodeId de tous les éléments présents dans le menu

* Bloc TinyMceWysiwyg
    * Type : public
    * Tags : -

* Bloc Video
    * Type : public
    * Tags : -

* Bloc Gallery
    * Type : public
    * Tags : mediaId de tous les éléments qui la compose (pas seulement sur la page courante)

* Bloc MediaListByKeyword
    * Type : public
    * Tags : mediaId de tous les éléments qui la compose

#### X-UA-Device

OpenOrchestra gère le multi device avec Varnish en ajoutant dans les entêtes de la requête un paramètre X-UA-Device.

Dans le fichier `openorchestra.vcl`, Varnish teste le User-Agent pour renvoyer le tag X-UA-Device correspondant: 

    if (req.http.User-Agent ~ "(?i)android") {
            set req.http.X-UA-Device = "android";
    }

Ainsi lors de l'affichage de la page du site OpenOrchestra cherche si les templates android existent. [Voir aussi la documentation sur le multi-devices](https://github.com/itkg/open-orchestra/blob/master/app/Resources/doc/dev/draft/multiDevices.md).
