# I/ Context
Le but de ce document est de pouvoir ajouter un nouveau type de champ dans le formulaire de création/édition d'un contenu.

Le formulaire des contenus est créé à l'aide d'un formulaire de création/édition de type de contenu.
Dans ce formulaire, il est possible d'ajouter autant de champs que nécessaires à la saisie d'un contenu et de caractériser chacun de ces champs.
Ex :
  un type de contenu voiture avec un champ nom et un champ motorisation.
  Le champ nom sera du type text.
  Le champ motorisation sera du type menu déroulant.
  
Il existe déjà dans OpenOrchestra un certain nombre de types de champs : text, textarea, tinymce, integer, email, orchestra_media.

Imaginons :
 - que les motorisations soient caractérisées par un booléen malus.
 - que le champ motorisation soit un type complexe, un menu déroulant renseigné dynamiquement par des données en base,
 - que l'on veuille caractériser si ce champ est nécessaire ou non dans le formulaire de contenu où il sera ajouté,
 - que l'on veuille paramétrer ce menu pour obtenir le menu déroulant des motorisations avec malus, le menu déroulant des motorisations sans malus ou le menu déroulant de toutes les motorisations.

# II/ Ajout d'un champ
Dans un premier temps, on ajoute une entrée dans parameters.open_orchestra_backoffice.custom_types sous la forme :

parameters:
    open_orchestra_backoffice.custom_types:
       motorisation_choice_type:
            label: Motorisation

On a ainsi une nouvelle entrée "Motorisation" dans le menu déroulant des types de champs dans le formulaire des types de contenus.
Si cette entrée est sélectionnée, alors dans le formulaire des contenus, on aura un nouveau champ.
Ce nouveau champ correspond au FormType référencé au niveau du form.yml par motorisation_choice_type.
            
# III/ Ajout des options du champ
Maintenant on désire ajouter les deux options définies pour caractériser le menu déroulant des motorisations, à savoir nécessaire ou non, avec malus, sans malus, tous.

parameters:
    open_orchestra_backoffice.custom_types:
       motorisation_choice_type:
            label: Motorisation
            options:
                malus_type_value:
                    default_value: 0
                required:
                    default_value: false
    open_orchestra_backoffice.options:
        malus_type_value:
            type: malus_type_choice
            label: Malussé

Il existe déjà dans OpenOrchestra un certain nombre d'options : max_length, required, grouping, rounding_mode.
On référence donc dans notre nouveau type de champ ses deux options, malus_type_value et required et l'on définit la nouvelle option malus_type_value dans le paramètre open_orchestra_backoffice.options.
Le libellé de l'option dans le formulaire des types de contenus sera "Malussé".
L'option sera renseignée à l'aide d'un FormType référencé au niveau du form.yml par malus_type_choice (par exemple, menu déroulant avec comme entrée avec malus, sans malus, tous).