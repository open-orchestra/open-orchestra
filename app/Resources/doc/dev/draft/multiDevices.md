# I/ Le multi device

 Lorsque la Request contient 'X-UA-Device' et le nom d'un device par exemple mobile, nous cherchons alors les templates qui ont le nom du device dans leurs noms.

 Pour activer le multi device ajoutez dans `app/config/config.yml` de votre projet front, les noms des devices.
 
 Par exemple :
 
    #app\config\config.yml
    
    open_orchestra_front:
        devices:
            web: ~
            tablet:
                parent: web
            phone:
                parent: web
            android:
                parent: phone

 Ainsi nous avons le device par défaut web, le device tablet, le device phone et le device android.
 
 Nous définissons les parents des devices, si un template pour un device n'est pas trouvé alors le template du parent sera pris.
 
 Créez les templates pour chaque device que vous ajoutez, par exemple pour le bloc contentList nous avons deux templates :
 
    DisplayBundle\Resources\views\Block\ContentList\show.html.twig
    DisplayBundle\Resources\views\Block\ContentList\show.phone.html.twig

 Le template `show.phone.html.twig` sera chargé lorsque le device sera phone ou android (s'il n'y a pas de template show.android.html.twig').
