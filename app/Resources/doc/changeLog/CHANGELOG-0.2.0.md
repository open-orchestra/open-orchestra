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

## New features

## Other changes
 - [Content Type List block now have a generic template](https://trello.com/c/BwV1cldJ/859-2-etq-ufront-je-vois-un-block-contentlist-avec-un-template-generique)

## Deprecated method

 - In the contentRepositoryInterface, the method findAllNews is deprecated and will be suppressed in 0.2.1

## Suppressed method

## Configuration changes

 - Activate new bundles for the backoffice :
    - `new OpenOrchestra\UserAdminBundle\OpenOrchestraUserAdminBundle(),`
    - `new OpenOrchestra\MediaAdminBundle\OpenOrchestraMediaAdminBundle(),`
 - Load the routing for those bundles
 - Do not use the UserBundle routes
