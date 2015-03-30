# I/ Description du protocole utilisé

Pour gérer la connexion à l'api, nous nous basons sur le protocole Oauth2

Pour cela, definissons tout d'abord les différents acteurs : 

 - Les utilisateurs : les utilisateurs finaux de l'application
 - L'application : nommé client dans la suite de la documentation
 - Le token : chaine de caractères à passer dans la query string
 - Les identifiants client : un couple clé/secret lié à un client

Lors d'une connexion, un token est lié à : 

 - Un client
 - Éventuellement un utilisateur

# II/ Les clients

Un listing des clients pouvant utiliser l'api est à disposition dans le backoffice de l'application.

L'ajout se fait directement par le formulaire d'ajout, le couple clé/secret étant généré automatiquement par le serveur

# III/ La création d'un token

## I/ Introduction

Le protocole Oauth2 décrit 5 stratégies pour obtenir un token, nous en avons implémenté 2 au sein de l'api d'openOrchestra.

## II/ Client credentials

Cette stratégie permet d'obtenir un token lié uniquement à un client.

Pour l'obtenir envoyez la requête :

    /oauth/access_token?grant_type=client_credentials

Avec pour en-tête HTTP:

    Authorization: Basic base64encode(clé/secret)

Vous obtiendrez un token pour accéder à l'api.

## III/ Resource owner password

Cette stratégie permet d'obtenir un token lié à un client et à un utilisateur.

Pour l'obtenir envoyez la requête :

    /oauth/access_token?grant_type=password&username=username&password=password

Avec pour en-tête HTTP:

    Authorization: Basic base64encode(clé/secret)

Vous obtiendrez un token pour accéder à l'api connecté avec l'utilisateur en question.

## IV/ Utilisation

Pour pouvoir utiliser l'api, ajoutez le paramètre access_token=token dans votre query string directement.

# III/ Mise en place des firewalls

## I/Cas nominal

Dans un cas nominal, l'api doit être stateless, donc liée à aucune session.
Cela se configure dans le fichier security.yml.

Ajoutez les lignes pour créer un firewall:

    api:
        pattern: ^/api/
        oauth2: ~
        anonymous: false
        security: true
        stateless: true

Ce faisant, l'api sera sécurisée en utilisant le protocole oauth2 et sera stateless

## II/ Fonctionnement global

Dans le cas du fonctionnement avec le backoffice, il est essentiel de pouvoir faire des requêtes sur l'api
 en étant déjà authentifié sur le reste de l'application.

Pour cela, l'api ne peut plus être stateless.
Il faut par ailleurs que le context de sécurité soit partagé entre les deux firewall symfony.

Ajoutez les lignes pour créer 2 firewalls :

    api:
        pattern: ^/api/
        oauth2: ~
        anonymous: false
        security: true
        context: openorchestra
    main:
        pattern: ^/
        form_login:
            provider: fos_userbundle
            csrf_provider: form.csrf_provider
        anonymous: true
        context: openorchestra
        logout:
            path:   /logout
            target: /admin

Ce faisant, l'api est accessible soit par un accès en oauth2, soit en utilisant la connexion depuis le backoffice.
