## Le cache partagé dans OpenOrchestra
Le système de bloc est au coeur de la génération des pages dans Open Orchestra. Afin d'exploiter au maximum les possibilités de mise en cache que ce découpage peut offrir, tous les blocs sont rendus via le helper twig render_esi. Si le reverse proxy utilisé est Symfony, le fonctionnement est standard. Mais si Varnish est utilisé, les fonctionnalités de cache et décache deviennent plus puissantes.
Deux axes de gestion du cache sont utilisés dans Open Orchestra : la durée de vie, ainsi que le tagage spécifique.

Lors de l'édition de chaque node et de chaque bloc, il est proposé au contributeur de renseigner une durée de vie associée au cache généré pour cet élément. De par l'utilisation des ESI, un bloc peut de fait avoir une durée de vie différente des autres blocs qui l'accompagnent, ainsi que de la page qui le contient. Le cache des nodes, et donc des pages, est systématiquement public. Par contre chaque bloc indique via sa stratégie d'affichage s'il est public ou privé, ce qui autorisera ou non son cachage dans la passerelle de cache.

Grâce au bundle [foshttpcache](http://foshttpcachebundle.readthedocs.org), le cache des pages ainsi que ceux des fragments des blocs sont taggés spécifiquement, ce qui permet une invalidation par tag précise et automatique, libérant ainsi le développeur et l'administrateur de la plateforme d'une purge complexe. Vous trouverez ci-dessous les tags automatiquement ajoutés selon le contexte.

### Tagage 
#### Node
Dans le cas d'un node, et donc d'une page, le cache est taggué par le nodeId, le nodeLanguage et le siteId.

#### Bloc
Tous les blocs sont taggués basiquement avec le tag 'block', ce qui permet de les distinguer des caches de node. Ensuite, chaque type de bloc peut ajouter ses propres tags spécifiques, qu'ils soient génériques, ou qu'ils prennent en compte les contributions associées. Un bloc dont le cache doit être taggué spécifiquement peut le faire grâce à sa stratégie d'affichage, quand celle-ci surcharge la méthode getTags de l'abstractController. De même par défaut les caches des blocs sont privés pour éviter par un oubli de configuration de mettre en cache des données personnelles. Cependant un bloc peut aisément se déclarer comme public pour autoriser le cache dans la passerelle de cache. Dans ce cas sa stratégie d'affichage n'a qu'à surcharger la méthode isPublic.
Voici bloc par bloc, les spécifications de cache

* Bloc Gallery
    * Bloc public
    * Cache taggué par l'ensemble des mediaId qui le composent
* Bloc Configurable Content
    * Bloc public
    * Cache taggué par le content type et le contentId
* Bloc Content List
    * Bloc public
    * Bloc taggué par les contentId qui le composent ainsi que les content types correspondant
