# I/ Système de blocs

Dans Open Orchestra, les pages sont composées de blocs représentant chacun un élément de page à afficher.

Afin de pouvoir facilement les configurer et en ajouter, nous avons mis en place des stratégies pour chaque bloc sous forme de services : 

  - Une stratégie d'affichage en front
  - Une stratégie surchargeant l'affichage front pour le Backoffice
  - Une stratégie fournissant un logo distinctif et un titre
  - Une stratégie permettant de modifier les champs de formulaire

Ces stratégies sont identifiées par l'utilisation de tags spécifiques dans la déclaration du service.

# II/ Les différentes stratégies

## Stratégies d'affichage

Pour l'affichage d'un bloc (en Frontoffice ou en Backoffice), le service doit être taggé par : 

    tags:
        - { name: php_orchestra_display.display_block.strategy }

Et implémenter l'interface : `OpenOrchestra\DisplayBundle\DisplayBlock\DisplayBlockInterface`

## Stratégies pour le logo

Pour l'affichage du logo visible dans le Backoffice lors de la contribution de pages,
le service doit être taggé par : 

    tags:
        - { name: open_orchestra_backoffice.display_icon.strategy }

Et implémenter l'interface : `OpenOrchestra\BackofficeBundle\DisplayIcon\DisplayInterface`

## Stratégies pour le formulaire

Pour l'affichage des formulaires d'édition dans le Backoffice, le service doit être taggé par : 

    tags:
        - { name: open_orchestra_backoffice.generate_form.strategy }

Et implémenter l'interface : `OpenOrchestra\Backoffice\GenerateForm\GenerateFormInterface`

# III/ Commande de génération

Afin de pouvoir générer facilement des blocks, une commande Symfony est disponible.

Pour l'utiliser simplement dans le cas d'ajout de block dans les vendors, il suffit de reprendre ceci et changer le nom du block: 

    php app/console orchestra:generate:block 
        --block-name="TestBlock" 
        --form-generator-dir="vendor/itkg/openorchestra-cms-bundle/Backoffice/GenerateForm/Strategies" 
        --front-display-dir="vendor/itkg/openorchestra-display-bundle/DisplayBundle/DisplayBlock/Strategies" 
        --backoffice-icon-dir="vendor/itkg/openorchestra-cms-bundle/BackofficeBundle/DisplayIcon/Strategies" 
        --backoffice-display-dir="vendor/itkg/openorchestra-cms-bundle/BackofficeBundle/DisplayBlock/Strategies" 
        --no-interaction

Pour une génération dans d'autres bundles, il est nécessaire de spécifier le namespace du bundle ainsi que le nom du fichier de configuration dans le bundle.
