
Architecture OpenOrchestra
==========================

1 Introduction
--------------

Ceci est un document de travail, voué à évoluer et poser les bonnes questions,
avant que toute architecture ne soit validée.

2 Fonctionnalités attendues
---------------------------

Liste des fonctionnalités qui sont souhaitées pour OpenOrchestra, qu'elles
soient héritées ou non de PHP Factory.

| Fonctionnalité    | Commentaire                                              |
|-------------------|----------------------------------------------------------|
| HMVC CMS          | Symfony supporte le forward aux controllers et ESI       |
| NoSQL             | Support de MongoDB et couche d'abstraction via Mandango  |
| Multi-device      | WURFL or other lib                                       |
| Multi-site        | Multi-app ?                                              |
| i18n/l10n         | Sf2 native                                               |
| Médiathèque       | Reprendre les médiathèques évoluées de PHP Factory       |
| RAD               | Prévoir le déploiement rapide de nouveaux écrans BO      |
| Refonte ergo BO   | Voir thème bootstrap Ajax sélectionné par R. Carles      |
| Inline editing    | Priorité moindre                                         |
| Legacy compat.    | En S2, faciliter la migration des projets PHP Factory    |
| Extensibilité     | Possibilité de greffer des produits tiers (smart, etc.)  |


3 Normes de développement
-------------------------

### 3.1 Répertoires

    .
    ├── build # Scripts to build project, launch unit tests, etc.
    ├── conf  # Basic system configuration
    │   ├── apache2
    │   ├── mongodb
    │   ├── php
    │   └── varnish
    ├── doc  # Project-wide documentation 
    └── src  # Sources
        └── symfony2


### 3.2 Où placer les développements

Les développements Symfony2 seront placés en tant que bundles dans le répertoire
vendor de Symfony2 :
`./src/symfony2/vendor/open-orchestra/nom-du-bundle-en-minuscules-et-tirets`

### 3.3 Autoloading

Les normes PSR-0 et PSR-4 sont toutes les deux possibles.

Pour le moment nous commencerons avec PSR-0 comme standard.
http://www.sitepoint.com/battle-autoloaders-psr-0-vs-psr-4/

Ce choix n'est pas définitif.

### 3.4 Namespace

En accord avec la norme *PSR-0* ou *PSR-4*, les 2 premiers niveaux du namespace
sont *vendor\package*, dans notre cas, le vendor sera systématiquement
**PHPOrchestra\NomDuBundle**, par exemple :
- PHPOrchestra\CMSBundle
- PHPOrchestra\CoreBundle
- PHPOrchestra\LegacyBundle
- PHPOrchestra\UserBundle
- PHPOrchestra\MediaBundle

### 3.5 Conventions d'écriture

Nous suivrons les normes PSR-1 et PSR-2 pour les conventions d'écriture.
http://www.php-fig.org/psr/psr-1/
http://www.php-fig.org/psr/psr-2/

Et résumées ici pour Symfony :
http://symfony.com/doc/current/contributing/code/standards.html

Les règles seront intégrées à la plateforme d'intégration continue.

### 3.6 Tests unitaires

Tous les développements sensibles du noyau seront testés en utilisant PHPUnit.
Les tests seront intégrés à la plateforme d'intégration continue.

### 3.7 Plateforme d'intégration continue

Travis-ci sera utilisé. (voir Pascal pour la mise en place)
+Scrutinizer

4 Modèle de données
-------------------

### 4.1 Base de données

La base de données principale sera en MongoDB

### 4.2 Modèle de données

![uml_model](open-orchestra-cms-uml.png "OpenOrchestra UML class model")

#### 4.2.1 Collection site

```json
{
  "siteId": 1,
  "domain": "www.example.org",
  "language": "en"
}
```

#### 4.2.2 Collection node

```json
{
    "nodeId": 1,
    "nodeType": "page"
    "siteId": 1,
    "parentId": null,
    "path": "/1",
    "alias": "home"
    "name": "Accueil",
    "version": 4,
    "language": "fr",
    "status": "published",
    "templateId": 42,
    "deleted": false,
    "theme": "customBundle:customTheme",
    "blocks":
    {
        "1":
        {
            "component": "controller/action",
            "attributes":
            {
                "custom_attribute": "value",
                "custom_attribute": "value",
                "custom_attribute": "value",
                "custom_attribute": "value"
                //, etc.
            }
        }
        //, etc.
    },
    "areas":
    [
        {
            "areaId": "html_id", // HTML identifier like "container", "header", "footer"
            "classes" : ["class1"/*, etc. */], // Additional HTML classes
            "boPercent" : 10.4, // Percent for bo screen viewing
            "boDirection" : "h", // v : vertical positioning in bo, h : horizontal positioning in bo 
            "subAreas":
            [
                {
                    "areaId": "html_id",
                    "classes": ["classN"],
    
                    // Usually blocks are in area leaves, so you *should* find
                    // either blocks or sub_areas, but not both
                    "blocks":
                    [
                        {
                            "nodeId": 0, // 0 = current node
                            "blockId": "1",
                            "boPercent" : 10.4 // Percent for bo screen viewing
                        }
                        //, etc.
                    ],
    
                    "subAreas":
                    [
                        // etc. Unlimited level of recursive areas
                    ]
                }
                //, etc. Unlimited number of areas
            ]
        }
    ]
}
```

#### 4.2.3 Collection content

```json
{
    "contentId": 1,
    "contentType": "news", // news, comment, article, etc.
    "version": 1,
    "language": "fr",
    "status": "published",
    "shortName": "Recognizable title", // Used to show content in BO lists
    "contentTypeVersion": 1 // Version of the contentType when content was saved
    "attributes":
    {
        "custom_attribute_name": "value",
        "custom_attribute_name": "value",
        "custom_attribute_name": "value",
        "custom_attribute_name": "value"
        //, etc.
    }
}
```

#### 4.2.4 Collection contentType

```json
{
    "contentTypeId": "news", // news, comment, article, etc.
	"name": "{\"en\":\"English Name\", \"fr\":\"Nom Français\", etc...}" // json of content type labels in available languages
    "version": 1,
	"status": draft,
    "deleted": false,
    "fields": // json array of objects fields
    "[
		{
        "fieldId": "name", // internal field id
        "label": "{\"en\":\"Name\", \"fr\":\"Nom\", etc...}", // json of internationals labels
        "defaultValue": "some default value",
        "searchable": true, // if field is searchable via index
        "type": "orchestra_text", // Orchestra custom field type
		"symfonyType": "text", // Symfony form type to use to render the field in content edition => known in conf but saved here for better perf when editing a content
		"options": {"max_length":25, "required": true} // json of symfony form type options
    	},
		{custom field 2},
		{custom field 3},
		etc ...
	]"
}
```

#### 4.2.5 Collection user

```json
{
    "id": 1,
    "login": "jdupond",
    "hash": "0123456789abcde",
    "salt": "1337",
    "firstName": "Jean",
    "lastName": "Dupond",
    "email": "jean.dupond@example.org",
    "addresses":
    {
        "default":
        {
            "street1": "1000 Jefferson Blvd",
            "zipcode": "ZIP001",
            "city": "City",
            "country": "Country"
        }
        //, etc.
    }
}
```

5 Spécifications détaillées
---------------------------

### 5.1 Gestion des pages

#### 5.1.1 Maquettes ergonomiques

* [Onglet contenu](mockups/node-content-tab.png)

* [Insertion de bloc](mockups/node-content-tab-block-selection.png)

* [Onglet principal](mockups/node-main-tab.png)

* [Onglet SEO](mockups/node-seo-meta-tab.png)

### 5.2 Gestion des contenus

### 5.3 Gestion des sites

### 5.4 Gestion du routing

### 5.5 Multilinguisme

La langue peut être fixée soit par le domaine, soit par le préfixe dans l'URL.

#### 5.5.1 Déterminer la langue par le site

Par domaine :

* www.example.org => "fr"

* fr.domain.com => "fr"

* en.domain.com => "en"

Pour choisir la langue, la variable d'environnement PO_LANG doit être fixée.

```apache
<VirtualHost *:80>
    # [...]
    SetEnv PO_LANG fr
</VirtualHost>
```

#### 5.5.2 Déterminer la langue par l'URL

* http://www.example.org/fr/

* http://www.example.org/en/contact

* http://www.example.org/es/my/path?query

#### 5.5.3 Gestion des traductions

Les traductions des textes utilisés dans les gabarits seront réalisées via
le service Translator de Symfony2.

Le format de stockage des traductions ser XLIFF.

http://symfony.com/doc/current/book/translation.html

### 5.6 Gestion des versions

### 5.7 Multisite

### 5.8 Workflow de publication

Le moteur de workflow permet de gérer les étapes de publication d'un contenu du
site. Celui-ci peut s'appliquer à une page (collection *node*) ou à n'importe
quel type de contenu (collection *content*).

Pour fonctionner, le moteur s'appuie sur des états de publication des
documents (brouillon -> à valider -> publié), des transitions entre ces états,
des rôles utilisateurs (contributeur, correcteur, validateur, etc.) et des
utilisateurs auxquels on affecte ces rôles pour chaque type de document concerné
(un même utilisateur peut être correcteur pour des news et contributeur pour des
pages).

Cette logique restera très proche de celle déjà en place pour PHP Factory.

Le workflow est utilisé à chaque fois que l'on enregistre une version de
document dont l'état est modifié.

#### 5.8.1 Les états

Les états possibles pour un document sont une liste arbitraire que
l'administrateur peut modifier. Les états seront enregistrés dans une collection
*workflow_status*. Au moins un état correspondra à état de publication.
Lorsqu'on passe un document dans un état de publication, le document lui-même
est flaggé comme étant publié (ces 2 informations, état et publication sont
décorrellés dans le document).

/À valider/ Les états sont communs à toute la plateforme (et non par site).

```json
{
    "name": "draft",
    "label":
    {
        "en": "Draft",
        "fr": "Brouillon"
        // , etc.
    },
    "published": false
},
{
    "name": "published",
    "label":
    {
        "en": "Published",
        "fr": "Publié"
        // , etc.
    },
    "published": true
}
```

#### 5.8.2 Les rôles

La liste des rôles est également arbitraire et modifiable par l'administrateur.
Collection *workflow_role*

```json
{
    "name": "contributor",
    "label":
    {
        "en": "Contributor",
        "fr": "Contributeur"
        // , etc.
    }
},
{
    "name": "publisher",
    "label":
    {
        "en": "Publisher",
        "fr": "Editeur"
        // , etc.
    }
}
```

#### 5.8.3 Les transitions

Les transitions sont une liste d'autorisations qui reflètent le workflow de
publication. Par exemple : "Le contributeur peut passer un contenur de l'état
*draft* à l'état *to_validate*".

Certaines transitions peuvent n'être autorisées que pour l'auteur du contenu.
Collection *workflow_transition*

| role        | status_from | status_to   | if_owner |
|-------------|-------------|-------------|----------|
| contributor | draft       | to_validate | false    |
| validator   | to_validate | published   | false    |
| validator   | to_validate | draft       | false    |

#### 5.8.4 Affectation des rôles

Un utilisateur peut avoir un rôle pour un certain type de contenu.
Cette information vient compléter la collection existante *user*.

```json
{
    // [User info],
    "workflow_roles":
    {
        "node": "contributor",
        "content_news": "contributor",
        "content_blog": "validator"
        // , etc.
    }
}
```

### 5.9 Listes, CRUD (RAD BO)



### 5.10 Indexation et recherche

### 5.11 Cache

### 5.12 Médiathèque

### 5.13 Gestion des utilisateurs

### 5.14 Gestion des droits

### 5.15 Thème ergonomique BO

6 ORM, couche d'abstraction d'accès aux données
-----------------------------------------------

7 Composants/Bundles utilisés
-----------------------------

| Composant         | Version     | Utilisation                                              |
|-------------------|-------------|----------------------------------------------------------|
| MongoDB           | 2.4.x-2.6.x | Base de données principale, stockages des données CMS    |
| Redis             |       2.4.x | Cache applicatif, gestion des sessions                   |
| Varnish           |         3.x | Cache HTTP, ESI                                          |
| PHP5              | 5.4.x-5.5.x | Interpréteur                                             |
| Symfony2          |       2.4.x | Framework                                                |
| Doctrine          |         dev | ORM/ODM                                                  |
| Mandango          |         dev | MongoDB ORM en cours de remplacement par Doctrine        |
| Assetic           |             | Gestion des assets                                       |
| Twig              |             | Moteur de templating                                     |
| PHPUnit           |       4.0.x | Tests unitaires                                          |
| Jenkins           |             | Intégration continue                                     |
| Travis-ci         |             | Intégration continue                                     |
| Git               |             | Gestion des sources                                      |
|                   |             |                                                          |

8 Gestion des sources
---------------------