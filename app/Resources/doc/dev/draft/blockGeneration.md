# I/ Système de block

Dans tous le site, le contenu est affiché par les blocks.

Afin de pouvoir facilement le reconnaitre et les configurer nous avons mis en place : 

  - Une stratégie d'affichage en front
  - Une stratégie surchargeant l'affichage front pour le Backoffice
  - Une stratégie fournissant un logo distinctif et un titre
  - Une stratégie permettant de modifier les champs de formulaire

# II/ Stratégie d'affichage

Pour l'affichage, le service doit être taggé par : 

    tags:
        - { name: php_orchestra_display.display_block.strategy }

Et étendre : `OpenOrchestra\DisplayBundle\DisplayBlock\DisplayBlockInterface`

# III/ Stratégie pour le logo

Pour l'affichage, le service doit être taggé par : 

    tags:
        - { name: open_orchestra_backoffice.display_icon.strategy }

Et étendre : `OpenOrchestra\BackofficeBundle\DisplayIcon\DisplayInterface`

# IV/ Stratégie pour le formulaire

Pour l'affichage, le service doit être taggé par : 

    tags:
        - { name: open_orchestra_backoffice.generate_form.strategy }

Et étendre : `OpenOrchestra\Backoffice\GenerateForm\GenerateFormInterface`

# V/ Commande de génération

Afin de pouvoir générer facilement des blocks, une commande est disponible.

Pour l'utiliser simplement dans le cas d'ajout de block dans les vendors, il suffit de reprendre ceci et changer le nom du block: 

    php app/console orchestra:generate:block 
        --block-name="TestBlock" 
        --form-generator-dir="vendor/itkg/openorchestra-cms-bundle/OpenOrchestra/Backoffice/GenerateForm/Strategies" 
        --front-display-dir="vendor/itkg/openorchestra-display-bundle/OpenOrchestra/DisplayBundle/DisplayBlock/Strategies" 
        --backoffice-icon-dir="vendor/itkg/openorchestra-cms-bundle/OpenOrchestra/BackofficeBundle/DisplayIcon/Strategies" 
        --backoffice-display-dir="vendor/itkg/openorchestra-cms-bundle/OpenOrchestra/BackofficeBundle/DisplayBlock/Strategies" 
        --no-interaction

Pour une génération dans d'autre bundle, il est nécessaire de spécifier le namespace du bundle ainsi que le nom du fichier de conf dans le bundle.
