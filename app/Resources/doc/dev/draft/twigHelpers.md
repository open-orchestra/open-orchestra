## Navigator
Le navigator est un helper Orchestra permettant de générer une pagination paramétrable et prête à être habillée via css.
L'appel au navigator depuis un twig se fait comme suit :
    {{ navigator(numberOfPages [, currentPage, [queryParameters, [maxPagesDisplayedAroundCurrent]]]) }}
  - numberOfPages : nombre total de pages
  - currenPage : page courante. 1 par défaut
  - queryParameters : tableau de type clé/valeur contenant les paramètres à ajouter à la queryString de chaque lien dans la pagination. array() par défaut
  - maxPagesDisplayedAroundCurrent : nombre maximum de pages à afficher de chaque côté de la page courante. Les pages non affichées sont signalées par ... 2 par défaut