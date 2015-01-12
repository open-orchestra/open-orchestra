# I/ Construction

Pour la construction de l'arbre avec tous les nodes, il suffit de donner l'ensemble des nodes au TreeManager qui se charge du classement

# II/ Parametre utiles

La construction de l'arbre se base sur deux parameters : 

 - Le parentId du node
 - L'order du node dans l'arborescence

# III/ Mécanisme

Lors du déplacement d'un node, une mise à jour de tous les fils de ce node est fait pour l'order.

Par la suite un event est envoyé afin de mettre à jour le path de tous les fils impliqué dans le déplacement.

# IV/ Conséquence

Lors d'un déplacement, sur le front et sur le back l'arbre est affiché avec les nouvelles priorité
