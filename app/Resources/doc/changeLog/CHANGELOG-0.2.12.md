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
