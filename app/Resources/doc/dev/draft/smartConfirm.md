#  I/ Description

SmartConfirm s'affiche sur le backoffice lorsque que l'on supprime un élément (noeuds, zones, blocs, templates, contenus, etc ...). Il est composé d'un logo, d'un titre, d'une description et de deux boutons (Yes, No).  La méthode permettant d'affiché le message de confirmation est dans le fichier "orchestraLib.coffee" et la méthode s'appelle smartconfirm. Vous pouvez voir l'utilisation de cette méthode dans les fichiers "treeAjaxDelete.coffee", "areaView.coffee", "tableviewView.coffee".

Elle prend en paramètres:
* 1/ La classe du logo (par exemple pour affiché une corbeille on utilise la class fa-trash-o).
* 2/ Le titre du message (par exemple pour un bloc "Voulez vous supprimer ce bloc").
* 3/ La description (par exemple pour un bloc "La suppression sera définitive").
* 4/ Un tableau contenant les fonctions lors des cliques sur les boutons.

Le tableau doit contenir la fonction "yesCallback" qui gère l'évenement du clique sur le bouton "yes" et "noCallback" qui gère le clique sur le bouton "no". Ainsi que "callBackParams" qui est un paramètre des fonctions "yesCallback" et "noCallback".

# II/ Les vues

SmartConfirm utilise deux vues:
* 1/ Une vue pour les boutons, ce qui permet de traduire les messages des boutons dans les différentes langues ("smartConfirmButton._tpl.twig").
* 2/ Une vue pour afficher le logo, le titre et la description ("smartConfirmTitle._tpl.twig").

La vue du titre contient un point d'interrogation, il ne faut donc pas que le titre ce termine par un point.

# III/ Les traductions

Pour que les boutons soient traduit dans les différentes langues, nous utilisons une vue, ce qui nous permet d'utiliser le système de traduction de symfony2. Pour ce qui est du titre et de la description, il faut que les textes soit déjà traduit. Par exemple pour la traduction du titre d'un bloc est contenu dans la vue des zones ("areaView._tpl.twig").

# IV/ Exemple

    smartConfirm(
        'fa-trash-o',
        confirm_title,
        confirm_text,
        callBackParams:
          url: url
        yesCallback: (params) ->
          $.ajax
            url: params.url
            method: 'DELETE'
            success: (response) ->
              if redirectUrl != undefined
                displayMenu(redirectUrl)
              else
                redirectUrl = appRouter.generateUrl 'showHome'
                Backbone.history.navigate(redirectUrl, {trigger:true})
                displayMenu(redirectUrl)
              return
            error: (response) ->
              $('.modal-footer', this.el).html response.responseJSON.error.message
              return
        noCallback: ->
          $("#OrchestraBOModal").modal "show"
      )
