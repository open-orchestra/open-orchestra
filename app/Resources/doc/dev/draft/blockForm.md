# I/ champ formulaire KeyWord

Les keywords saisis dans les formulaires du backoffice peuvent être traités au niveau du modèle de deux façons différentes.
S'ils ont vocation à être stockés au niveau d'une des propriétés de l'entité, alors ils seront déclarés comme une collection d'embed (ex : content).
S'ils ont vocation à être stockés dans un tableau hash d'attributs, alors ils seront traités sous la forme d'une string (ex : block contentList).

Une option du champ de formulaire permet de spécifier le type de traitement. Par défaut, le comportement est embed.

        $builder->add('keywords', 'orchestra_keywords', array(
            'embedded' => false,
            'required' => false,
            'label' => 'php_orchestra_backoffice.form.content_list.content_keyword',
        ));


