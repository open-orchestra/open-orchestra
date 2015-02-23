# I/ Context

Dans le cadre de l'accès au nœud sur le front, nous avons mis en place un routing dynamique qui recherche dans l'arborescence
 le nœud concerné par une url relative

# II/ Amélioration

Nous avons mis en place dans le node un parameter : `routePattern` contenant le pattern de la route permettant d'accéder au nœud en question.

# III/ Usage

Sur le site front, il suffit d'activer le routing par base de données pour que le router génère tous les liens dans le cache.

Activation : (dans le fichier `routing.yml`)

    open_orchestra_database:
        resource: '.'
        type: database

Lors de la mise en place d'une route dans le node l'utilisateur doit suivre les prérequis Symfony :

 - Les variables dont il veut disposer entre {} ex : `/constructeur/{voiture}/blog`
 - Il y a un check sur l'unicité du routePattern avec tous les frères d'un nœud
