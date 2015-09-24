# CHANGELOG for 1.0.0-RC2

Url to see changes : 

 - [Cms bundle](https://github.com/open-orchestra/open-orchestra-cms-bundle/compare/v1.0.0-RC1...v1.0.0-RC2)
 - [Display bundle](https://github.com/open-orchestra/open-orchestra-display-bundle/compare/v1.0.0-RC1...v1.0.0-RC2)
 - [Model bundle](https://github.com/open-orchestra/open-orchestra-model-bundle/compare/v1.0.0-RC1...v1.0.0-RC2)
 - [Model interface](https://github.com/open-orchestra/open-orchestra-model-interface/compare/v1.0.0-RC1...v1.0.0-RC2)
 - [Front bundle](https://github.com/open-orchestra/open-orchestra-front-bundle/compare/v1.0.0-RC1...v1.0.0-RC2)
 - [Base bundle](https://github.com/open-orchestra/open-orchestra-base-bundle/compare/v1.0.0-RC1...v1.0.0-RC2)
 - [Base api bundle](https://github.com/open-orchestra/open-orchestra-base-api-bundle/compare/v1.0.0-RC1...v1.0.0-RC2)
 - [Base api model bundle](https://github.com/open-orchestra/open-orchestra-base-api-mongo-model-bundle/compare/v1.0.0-RC1...v1.0.0-RC2)
 - [Media bundle](https://github.com/open-orchestra/open-orchestra-media-bundle/compare/v1.0.0-RC1...v1.0.0-RC2)
 - [User bundle](https://github.com/open-orchestra/open-orchestra-user-bundle/compare/v1.0.0-RC1...v1.0.0-RC2)
 - [Theme bundle](https://github.com/open-orchestra/open-orchestra-theme-bundle/compare/v1.0.0-RC1...v1.0.0-RC2)
 - [Worflow function bundle](https://github.com/open-orchestra/open-orchestra-worflow-function-bundle/compare/v1.0.0-RC1...v1.0.0-RC2)

## Possible BC breaker
  
  - In ``NodeManager``, parameter ``siteRepository`` must implement ``ReadSiteRepositoryInterface``
  - In ``LanguageListStrategy``, parameter ``siteRepository`` must implement ``ReadSiteRepositoryInterface``
  - In ``KernelExceptionSubscriber``, parameter ``siteRepository`` must implement ``ReadSiteRepositoryInterface``
  - In ``DatabaseRouteLoader``, parameter ``siteRepository`` must implement ``ReadSiteRepositoryInterface``
  - In ``RedirectionLoader``, parameter ``siteRepository`` must implement  ``ReadSiteRepositoryInterface``

## Bug fixes

## New features
 
 - [ SaveMediaManager can upload multiple files](https://trello.com/c/C3PQxhLm/1297-1-etq-ubo-je-peux-uploader-plusieurs-fichier-en-meme-temps) 
 
## Other changes
 
 - ``SiteRepositoryInterface`` is split in ``SiteRepositoryInterface`` and ``ReadSiteRepositoryInterface``
 - [The Back Office navigation pannel mechanism has been refactored to allow the creation of level 1 strategies](https://trello.com/c/7oj9DRod/1347-2-faire-une-mecanique-de-strategie-pour-les-liens-de-niveau-0-du-menu-de-navigation)
 
## Deprecated method

## Suppressed method

## Configuration changes
