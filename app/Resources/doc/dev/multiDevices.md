# I/ Ajouter des moteurs de template

 Si vous utilisez un autre moteur de template que Twig, surchargez la classe qui permet d'afficher les templates.
 
 Pour Twig nous avons surchargé TwigEngine et TimedTwigEngine :
 
    FrontBundle\Twig\OrchestraTimedTwigEngine
    FrontBundle\Twig\OrchestraTwigEngine
 
 Appelez le trait `FrontBundle\Twig\Renderable` qui surcharge la méthode `render()` et ajouter l'extension de votre moteur de template dans la méthode `replaceTemplateExtension()` :

    if (strstr($name, 'twig'))
    {
        return str_replace('html.twig', $device . '.html.twig', $name);
    }

 ## Déclarer la classe en tant que service
 
 Pour déclarer la classe qui surcharge le moteur de template en tant que service :
 
     #FrontBundle\Resources\config\twig.yml
     
     parameters:
         open_orchestra_front.twig.orchestra_twig_engine.class: OpenOrchestra\FrontBundle\Twig\OrchestraTwigEngine
     
     services:
         open_orchestra_front.twig.orchestra_twig_engine:
             class: %open_orchestra_front.twig.orchestra_twig_engine.class%
             arguments:
                 - @twig
                 - @templating.name_parser
                 - @templating.locator
                 - @request_stack
                 - %open_orchestra_front.devices%

 Récupérez les devices qui sont dans `app\config\config.yml` avec l'argument `%open_orchestra_front.devices%`.
 
 Pour que ce soit votre classe qui soit appelée plutôt que le moteur de template de base utilisez un alias :
 
 Soit dans l'extension du bundle `FrontBundle\DependencyInjection\OpenOrchestraFrontExtension` :

    $container->setAlias('templating', 'open_orchestra_front.twig.orchestra_twig_engine');

 Soit dans lorsque vous déclarez votre classe en tant que service :

    open_orchestra_front.twig.orchestra_twig_engine:
        class: %open_orchestra_front.twig.orchestra_twig_engine.class%
        arguments:
            - @twig
            - @templating.name_parser
            - @templating.locator
            - @request_stack
            - %open_orchestra_front.devices%
        alias: templating
