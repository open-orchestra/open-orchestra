# I/ Behat

 Behat est utilisé pour tester fonctionnellement notre application OpenOrchestra. Vous pouvez lancer behat sur votre local, la vagrant 
 et sur le serveur d'intégration. Les tests sur votre machine locale lanceront un navigateur où vous pourrez visualiser le déroulement des tests.
 
# II/ Behat en local

 Pour lancer les tests behat il vous faut d'abord [selenium serveur](http://selenium-release.storage.googleapis.com/2.44/selenium-server-standalone-2.44.0.jar).
 Téléchargez selenium à l'adresse : http://selenium-release.storage.googleapis.com/2.44/selenium-server-standalone-2.44.0.jar

 Pour lancez les tests behat avec google chrome téléchargez [chromedriver](http://chromedriver.storage.googleapis.com/2.9/chromedriver_linux64.zip)
 
 Lancez le serveur selenium :

    java -jar selenium-server-standalone-2.44.0.jar

 Avec chrome :

    java -jar selenium-server-standalone-2.44.0.jar -Dwebdriver.chrome.driver={{path}}/chromedriver



Concernant firefox, les versions supérieures à la 34 ne sont pas supportées par selenium.

# III/ Behat sur la vagrant

 Sur la vagrant le provisionning télécharge un navigateur google-chrome et firefox ansi que xvfb qui nous permet de lancer
 les navigateur sur la vagrant.

 Le chemin du jar selenium est :

    /usr/local/lib/selenium-server-standalone-2.44.0.jar

 Le provisionning devrait lancer Xvfb et selenium, mais il est possible de les arrêter avec les commandes :

    sudo /etc/init.d/Xvfb stop
    sudo /etc/init.d/selenium stop
 
 Ou de les lancer avec un start

# IV/ Behat sur le serveur d'intégration

 Vous pouvez lancer les tests behat avec la commande

    cap orchestra:behat
 
 Cette commande lancera xvfb et selenium, chargera les fixtures en test, lancera les tests behat et arrêtera selenium et xvfb.
 
 Pour lancer et arréter selenium et xvfb utilisez :

    cap orchestra:selenium:start
    cap orchestra:selenium:stop
 
 Pour ne pas avoir à entrer de mot de passe, éditez le fichier `/etc/sudoers.tmp`.

 Connectez vous sur le serveur d'intégration et utilisez :

    visudo
 
 Rajoutez ces lignes :

    open_orchestra_backoffice_inte ALL=(ALL) NOPASSWD: /etc/init.d/Xvfb
    open_orchestra_backoffice_inte ALL=(ALL) NOPASSWD: /etc/init.d/selenium

# V/ Lancer les tests

 Pour changer le navigateur utilisé, changez la variable browser_name dans behat.yml :

    default:
        extensions:
            Behat\Symfony2Extension:
            Behat\MinkExtension:
                default_session: selenium2
                base_url: 'http://openorchestra.test/app_test.php'
                browser_name: chrome
                selenium2:
                    capabilities: { "browser": "firefox", "version": "34"}

 Pour lancer les tests behat en locale ou sur la vagrant utilisez :

    ./bin/behat

 Sur le serveur d'intégration utilisez :

    cap orchestra:behat
