# OrchestraType

OpenOrchestra propose plusieurs types de champs de formulaire par défaut pour créer des éléments composites comme des listes déroulantes ou des champs textes utilisant du Javascript spécifique (palette de couleur et mot-clé).

## OrchestraChoiceType

La classe OrchestraChoiceType permet de créer facilement des listes déroulantes dans OpenOrchestra.
Vous devez passer au constructeur de la classe une liste de choix et le nom du type de champ.

## OrchestraColorChoiceType

La classe OrchestraColorChoiceType permet de créer une liste déroulante de couleurs (rouge, orange, vert).
Ce type de champ est utilisé dans le formulaire des status.

Nom : 'orchestra_color_choice'

## OrchestraColorPickerType

La classe OrchestraColorPickerType permet de créer un champ avec une palette de couleurs.

Nom : 'orchestra_color_picker'

## OrchestraContentTypeChoiceType

La classe OrchestraContentTypeChoiceType permet de créer une liste déroulante de types de contenu.

Nom : 'orchestra_content_type_choice'

## OrchestraFrequenceChoiceType

La classe OrchestraFrequenceChoiceType permet de créer une liste déroulante de fréquence (Toujours, Toutes les heures, Quotidien, Hebdomadaire, Mensuel, Annuel, Jamais).

Nom : 'orchestra_frequence_choice'

## OrchestraKeywordstype

La classe OrchestraKeywordstype permet de créer un champ pour taguer par mot-clé.

Nom : 'orchestra_keywords'

## OrchestraMediaType

La classe OrchestraMediaType est utilisée pour créer une collection de médias.

Nom : 'orchestra_media'

## OrchestraNodeChoiceType

La classe OrchestraNodeChoiceType permet de créer une liste déroulante des pages existantes. Les pages sont ordonnés comme dans le menu de navigation en Back Office.

Nom : 'orchestra_node_choice'

## OrchestraRoleChoiceType

La classe OrchestraRoleChoiceType permet de créer une liste déroulante de rôles.

Nom : 'orchestra_role_choice'

## OrchestraSiteChoiceType

La classe OrchestraSiteChoiceType permet de créer une liste déroulante des sites disponibles sur OpenOrchestra.

Nom : 'orchestra_site_choice'

## OrchestraThemeChoiceType

La classe OrchestraThemeChoiceType permet de créer une liste déroulante des thèmes disponibles sur OpenOrchestra.

Nom : 'orchestra_theme_choice'

## OrchestraVideoType

La classe OrchestraVideoType permet de créer un champ texte qui attend l'identifiant ou l'url d'une vidéo.
Si c'est une url qui est donnée alors OpenOrchestra extrait l'identifiant de l'url.

Nom : 'orchestra_theme_choice'

## Exemple d'utilisation

Ajoutez le nom du type de champ :

    $builder->add('theme', 'orchestra_theme_choice', array(
        'label' => 'open_orchestra_backoffice.form.node.theme'
    ));

Dans cet exemple "orchestra_theme_choice" est le nom du type de champ OrchestraThemeChoiceType.

OrchestraMediaType est utilisé dans une collection, pour ajouter plusieurs médias : 

    $builder->add('pictures', 'collection', array(
        'type' => 'orchestra_media',
        'allow_add' => true,
        'attr' => array(
            'data-prototype-label-add' => $this->translator->trans('open_orchestra_backoffice.block.gallery.form.media.add'),
            'data-prototype-label-new' => $this->translator->trans('open_orchestra_backoffice.block.gallery.form.media.new'),
            'data-prototype-label-remove' => $this->translator->trans('open_orchestra_backoffice.block.gallery.form.media.delete'),
        ),
        'label' => 'open_orchestra_backoffice.block.gallery.form.pictures',
    ));
