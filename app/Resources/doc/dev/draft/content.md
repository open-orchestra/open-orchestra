### Présentation
L'un des points forts d'Open Orchestra est de proposer une approche RAD de la gestion des contenus, aspect central d'un CMS. Se basant sur les possibilités techniques offertes par MongoDB, Open Orchestra ne nécessite en général aucun développement spécifique pour gérer les nouveaux types de contenus spécifiques à son application ainsi que la contribution des contenus correspondant. Tout se configure directement dans le Back Office.

Par exemple le type contenu "Actualité" pourrait être caractérisé par un titre de type "ligne de texte", une accroche de type "texte limité à 250 caractères", une image de type "média" et un corps de texte de type "texte riche". Plutôt que de devoir développer les différentes couches nécessaires à la contribution d'actualités (Entités, Requêtes sur les repositories, Formulaires, etc ...), le développeur n'a qu'à décrire en Back Office le type de contenu "Actualité" en précisant un à un les types de champs nécessaires. Toute la partie stockage MongoDB est automatiquement prise en charge par Orchestra, de même que les formulaires de contribution de ces actualités, ainsi que la liste filtrable des actualités existantes. Le développeur n'a alors qu'à se concentrer sur ce qui fait la spécificité de son application : la partie Front.

Les notions Orchestra derrière cette fonctionnalité sont les Contents et Content Types. Chaque attribut d'un Content Type est appelé Content Attribute.

### Content Types
Chaque contenu contribuable dans un CMS appartient à une famille qu'Orchestra appelle son type de contenu, ou Content Type. Pour un blog par exemple, on pourrait trouver les Content Types "billet" et "commentaire". Bien que différents d'un point de vue fonctionnel, Orchestra gère tous ces éléments de la même façon, comme des documents appartenant à la collection Mongo "ContentType".
Un Content Type est défini par :
* un contentTypeId : unique pour chaque ContentType, 'news' par exemple pour le ContentType 'Actualité'.
* un name : libellé avant tout utilisé dans les interface Back Office. Plus qu'un simple libellé il s'agit en fait d'une collection de libellés, un par langue activée pour le Back Office.
* une version : le content Type est versionné, car il est possible de faire évoluer son modèle dans la vie d'une application en ajoutant/supprimant des attributs par exemple
* un status : un Content Type peut être publié ou non, ce qui le rend disponible ou non à la contribution
* une collection de fields : c'est l'ensemble des attributs qui le composent ("titre", "accroche", "image" et "texte" pour l'actualité)

C'est ce dernier point qui est au centre de la gestion des contenus dans Orchestra. Il est rendu possible grâce à mongoDB qui permet en tant qu'ODM NoSql de stocker dans une même collection des documents de structure variable.

### Content
Les contenus, ou Contents pour Orchestra, sont les instances des Content Types. Par exemple l'actualité qui traîte de l'élection du nouveau président est un Content instanciant le Content Type "Actualité". Tout comme pour les Content Types, bien que distincts fonctionnellement, un Content de type "Actualité" et un Content de type "Commentaire" sont gérés de la même façon, comme documents de la collection Mongo Content.
Un Content est défini par :
* un contentTypeId : indique de quel Content Type est le contenu
* un name : un libellé pour ce contenu, ou plus exactement une collection de libellés dans différentes langues
* une version : les contenus sont versionnés
* un status : les contenus sont assujettis à un workflow de publication
* un état de suppression : les contenus supprimés depuis le Back Office le sont de manière logique et non physique. Cet attribut indique l'état de suppression logique.
* des fields : la liste des attributs spécifiques du content issus du Content Type.

Là encore c'est l'aspect NoSql de MongoDB qui permet d'avoir une collection générique de content dans laquelle chaque document dispose pourtant de sa propre structure.

### Content Attributes
