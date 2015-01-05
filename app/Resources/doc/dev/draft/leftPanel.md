# I/ Context

Dans le cadre du left Panel, il doit être possible pour un intégrateur de rajouter une entrée simplement.

# II/ Usage

Pour cela il faut créer un service qui implement : `PHPOrchestra\Backoffice\LeftPanel\LeftPanelInterface`

Puis le tagger : 
    
    tags:
        - { name: php_orchestra_backoffice.left_panel.strategy }

# III/ Spécificité

Il est possible de définir de nouvelle catagorie en rajoutant les clé de traduction adéquate.

Il est possible de réordonner les différents éléments du menu en jouant sur le poids.
