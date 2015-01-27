## Navigator
Le navigator est un helper Orchestra permettant de générer une pagination paramétrable et prête à être habillée via css.
L'appel au navigator depuis un twig se fait comme suit :
    {{ navigator(nbPages [, curPage, [queryParams, [maxPagesDispAroundCur]]]) }}
  - nbPages : nombre total de pages
  - curPage : page courante. 1 par défaut
  - queryParams : tableau de type clé/valeur contenant les paramètres à ajouter à la queryString de chaque lien dans la pagination. array() par défaut
  - maxPagesDispAroundCur : nombre maximum de pages à afficher de chaque côté de la page courante. Les pages non affichées sont signalées par ... 2 par défaut