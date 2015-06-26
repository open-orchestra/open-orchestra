# CHANGELOG for 0.2.12

Url to see changes : 

 - [Cms bundle](https://github.com/open-orchestra/open-orchestra-cms-bundle/compare/v0.2.11...v0.2.12)
 - [Display bundle](https://github.com/open-orchestra/open-orchestra-display-bundle/compare/v0.2.11...v0.2.12)
 - [Model bundle](https://github.com/open-orchestra/open-orchestra-model-bundle/compare/v0.2.11...v0.2.12)
 - [Model interface](https://github.com/open-orchestra/open-orchestra-model-interface/compare/v0.2.11...v0.2.12)
 - [Front bundle](https://github.com/open-orchestra/open-orchestra-front-bundle/compare/v0.2.11...v0.2.12)
 - [Base bundle](https://github.com/open-orchestra/open-orchestra-base-bundle/compare/v0.2.11...v0.2.12)
 - [Base api bundle](https://github.com/open-orchestra/open-orchestra-base-api-bundle/compare/v0.2.11...v0.2.12)
 - [Media bundle](https://github.com/open-orchestra/open-orchestra-media-bundle/compare/v0.2.11...v0.2.12)
 - [User bundle](https://github.com/open-orchestra/open-orchestra-user-bundle/compare/v0.2.11...v0.2.12)
 - [Theme bundle](https://github.com/open-orchestra/open-orchestra-theme-bundle/compare/v0.2.11...v0.2.12)
 - [Worflow function bundle](https://github.com/open-orchestra/open-orchestra-worflow-function-bundle/compare/v0.2.11...v0.2.12)

## Possible BC breaker
 - The namespace of trait `ListStatus` is now `OpenOrchestra\ApiBundle\Controller\ControllerTrait`

## Bug fixes
 - [Node preview has been fixed, see configuration changes for more info](https://trello.com/c/RtRaYALE/1090-2-etq-ubo-je-peux-voir-les-previsu-fr-en-fr)

## New features

## Other changes

## Deprecated method

 - Most part of ``ContentTypeRepository``, ``ContentRepository``, ``Site Repository`` and ``PaginateAndSearchFilterTrait`` methods are deprecated to use new methods with ``FinderConfiguration``
 - 
 - 
## Suppressed method

 - All the display block classes from the MediaBundle have been removed
 - ``findOneByContentTypeIdAndVersion`` and ``findOneByContentTypeIdAndVersionfrom`` from  ``ContentTypeRepositoryInterface``
 - ``findByContentTypeInLastVersion`` from ``ContentRepositoryInterface``
 - ``findOneByParendIdAndRoutePatternAndSiteId`` from ``NodeRepositoryInterface``

## Configuration changes
 - In order to get the new routing conf, Back Office configuration requires to be updated. In app/config/routing.yml of your back application, add the following lines :

    open_orchestra_base:
        resource: "@OpenOrchestraBaseBundle/Resources/config/routing.yml"

 - The front configuration must also be updated. In app/config/routing.yml of your front application, add the following lines :

    open_orchestra_base:
        resource: "@OpenOrchestraBaseBundle/Resources/config/routing.yml"

    open_orchestra_front_preview:
        resource: "@OpenOrchestraFrontBundle/Resources/config/preview_routing.yml"
