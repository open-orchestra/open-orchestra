# CHANGELOG for 0.2.0

Url to see changes : 

 - [Cms bundle](https://github.com/open-orchestra/open-orchestra-cms-bundle/compare/v0.1.4...v0.2.0)
 - [Display bundle](https://github.com/open-orchestra/open-orchestra-display-bundle/compare/v0.1.4...v0.2.0)
 - [Model bundle](https://github.com/open-orchestra/open-orchestra-model-bundle/compare/v0.1.4...v0.2.0)
 - [Model interface](https://github.com/open-orchestra/open-orchestra-model-interface/compare/v0.1.4...v0.2.0)
 - [Front bundle](https://github.com/open-orchestra/open-orchestra-front-bundle/compare/v0.1.4...v0.2.0)
 - [Base bundle](https://github.com/open-orchestra/open-orchestra-base-bundle/compare/v0.1.4...v0.2.0)
 - [Media bundle](https://github.com/open-orchestra/open-orchestra-media-bundle/compare/v0.1.4...v0.2.0)
 - [User bundle](https://github.com/open-orchestra/open-orchestra-user-bundle/compare/v0.1.4...v0.2.0)
 - [Theme bundle](https://github.com/open-orchestra/open-orchestra-theme-bundle/compare/v0.1.4...v0.2.0)

## Possible BC breaker

 - [Creation of UserAdminBundle](https://trello.com/c/sJljqlue/740-3-etq-dev-j-ai-acces-a-un-useradminbundle-mediaadminbundle-dans-le-cms-bundle)
 - [Creation of MediaAdminBundle](https://trello.com/c/sJljqlue/740-3-etq-dev-j-ai-acces-a-un-useradminbundle-mediaadminbundle-dans-le-cms-bundle)

## Bug fixes
 - [Car content type fixtures are functionnal](https://trello.com/c/4VASdtmr/835-1-etq-ubo-je-peux-editer-les-car-des-fixtures)
 - AccessToken was linked to the `User` document, it is now linked to the `UserInterface`
 - AccessToken was linked to the `ApiClient` document, it is now linked to the `ApiClientInterface`
 - [Content type with content field which have not options are functionnal](https://trello.com/c/J9VMmP8e/842-0-5-bo-content-type-parametrage-content-attribute-option-necessaire-sinon-plantage)

## New features
 - Possibility of using fullname (bundle:controller:twig) for underscore template in coffee
 - [Application developpers can now add new custom content attributes](https://trello.com/c/1Yn20BSP/846-2-etq-ubo-je-peux-ajouter-des-contents-attributs-specifique)

## Other changes
 - [Content Type List block now have a generic template](https://trello.com/c/BwV1cldJ/859-2-etq-ufront-je-vois-un-block-contentlist-avec-un-template-generique)
 - [In the back office / mediatheque, the media format tab is shown only for images, not for pdfs or videos](https://trello.com/c/YAQFAdN4/839-1-etq-ubo-je-vois-l-onglet-crop-uniquement-pour-les-images)
 - [In the creation of a site form, by default the index parameter and the follow parameter are checked](https://trello.com/c/T4qUcjsp/855-0-5-etq-ubo-lors-de-la-creation-d-un-site-index-follow-true-par-defaut)
 - [Content Type have no status](https://trello.com/c/tDfjsN1z/836-0-5-etq-ubo-je-ne-peux-pas-mettre-de-status-sur-les-contenttypes)

## Deprecated method

 - In the contentRepositoryInterface, the method findAllNews is deprecated and will be suppressed in 0.2.1
 - In the contentTypeRepositoryInterface, the method findOneByContentTypeIdAndVersion is deprecated and will be suppressed in 0.2.1

## Suppressed method

## Configuration changes

 - Activate new bundles for the backoffice :
    - `new OpenOrchestra\UserAdminBundle\OpenOrchestraUserAdminBundle(),`
    - `new OpenOrchestra\MediaAdminBundle\OpenOrchestraMediaAdminBundle(),`
 - Load the routing for those bundles

        open_orchestra_user_admin:
            resource: "@OpenOrchestraUserAdminBundle/Controller/Admin"
            type: annotation
            prefix: /admin

        open_orchestra_media_admin:
            resource: "@OpenOrchestraMediaAdminBundle/Controller/Admin"
            type: annotation
            prefix: /admin

        open_orchestra_user_api:
            resource: "@OpenOrchestraUserAdminBundle/Controller/Api"
            type: annotation
            prefix: /api

        open_orchestra_media_api:
            resource: "@OpenOrchestraMediaAdminBundle/Controller/Api"
            type: annotation
            prefix: /api

 - Do not use the UserBundle routes
 - Add the relation to the `UserInterface` :
    - `Symfony\Component\Security\Core\User\UserInterface: OpenOrchestra\UserBundle\Document\User`
 - Add the relation to the `ApiClientInterface` :
    - `OpenOrchestra\UserBundle\Model\ApiClientInterface: OpenOrchestra\UserBundle\Document\ApiClient`
 - We use a new bundle to use aggregation query with mongodb, activate the bundle :
    - `new Solution\MongoAggregationBundle\SolutionMongoAggregationBundle(),`
