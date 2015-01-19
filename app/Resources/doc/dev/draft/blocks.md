
# I/ Description

Dans tous le site, le contenu est affiché par les blocks.

Afin de pouvoir facilement le reconnaitre et les configurer nous avons mis en place : 

  - Une stratégie d'affichage en front
  - Une stratégie surchargeant l'affichage front pour le Backoffice
  - Une stratégie fournissant un logo distinctif et un titre
  - Une stratégie permettant de modifier les champs de formulaire

Il existe une commande permettant de générer automatiquement des blocs, voir blockGeneration

# II/ Formulaire

Il existe des champ de formulaires utiliser seulement pour les blocs.

## 1/ OrchestraBlockCheckBoxType

Cette classe permet d'afficher dans le formulaire d'un bloc une checkbox:

    $form->add('autoplay', 'orchestra_block_checkbox', array(
        'mapped' => false,
        'data' => $attributes['autoplay'],
        'label' => 'php_orchestra_backoffice.block.dailymotion.autoplay',
        'required'  => false,
    ));

Cependant dans les strategies Displays il faudra tester si le nom du champ fait partie des attributs car si la checkbox n'est pas coché la première fois elle ne renvoie rien.
Les fois suivantes elle renvoie '1' ou rien.

    if (array_key_exists('autoplay', $attributes) && $attributes['autoplay'] == true) {
    
    }
    if (!array_key_exists('related', $attributes) || $attributes['related'] == false) {
    
    }

Dans BlockTypeSubscriber nous regardons la différence entre:

    $event->getForm()->getData()->getAttributes();

et

    $event->getData();

Ansi nous savons si une checkbox n'est pas coché et renvoyons false.
