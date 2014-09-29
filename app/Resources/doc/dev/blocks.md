I) Les Blocks 
=============

1 Contact 
---------
Le bloc contact permettra d'intégrer un simple formulaire de contact avec le nom, l’e-mail, le sujet et un message. Si des champs supplémentaires sont nécessaires. 

il suffira de les ajouter dans la fonction "buildForm(FormBuilderInterface $builder, array $options)" présent dans la classe CMSBundle/Form/Type/ContactType. 

Lorsque l'internaute envoie une demande de contact, un mail de confirmation et envoyé à l'internaute et un mail est transmit à l’administrateur du site avec les informations du demandeur et le contenu du message. 

Le contrôleur  « ContactController » gère la création du formulaire de contact et l'envoie des mails. 
Ce contrôleur dispose de deux méthodes : 

- ContactFormShowAction($id,$class) : qui génère le formulaire, 
- ContactMailSendAction() : qui envoie les mails. 

Pour configuer l'envoi des E-mail aller dans app/config/parameters est renseigner les arguments suivant : 
	- mailer_transport: 
	- mailer_host: 
	- mailer_user: 
	- mailer_password: 

Le visuel des E-mails est dans le dossier CMSBundle/Ressources/views/Email. Deux vues sont présentes une vie pour le mail envoyé à l'administrateur du site un pour l'utilisateur qui aura fait la demande de contact. 


2 Header 
---------
Le bloc header reste à penser. Dans un premier temps je pensé faire un tableau de Wysiwyg afin, de pouvoir afficher un logo, du texte etc etc. Mais cette solutions n'est pas encore validée. 

3 Carrousel 
------------
Le bloc carrousel permettra d'afficher un carrousel d'images, la fonction showAction présente dans "CarousselController" prendre 3 paramètres : 
 
- $pictures : un tableau d'images 
- $width : la largeur du carrousel en px 
- $height : hauteur du carrousel  en px 

le template twig se contente simplement de d'afficher toutes les images via une boucle for. Les images du carrousel sont enregistrées dans web/bundles/phporchestrasite/carrousel 
 
Le code source du carrousel provient du site : http://www.jssor.com/ . 
Le lien du carrousel choisie est le suivant  : http://www.jssor.com/demos/simple-fade-slideshow.html 

4 News 
------------

Le bloc News permettra de d’afficher les contenues de type "news" qui auront un status "published". La requête récupérant les news est getAllNews(), elle se trouve dans CMSBunble/Model/ContentRepository. 

II) Note générale sur les blocs 
===============================
Tout les blocs disposent de deux fonction dans leur contrôleur : 
- une fonction showAction() : qui gère l’affichage en front-office. 
- une fonction ShowBackAction() : qui gère l’affichage en Back-office. 










