# CHANGELOG for 0.3.3

Url to see changes : 

 - [Cms bundle](https://github.com/open-orchestra/open-orchestra-cms-bundle/compare/v0.3.2...v0.3.3)
 - [Display bundle](https://github.com/open-orchestra/open-orchestra-display-bundle/compare/v0.3.2...v0.3.3)
 - [Model bundle](https://github.com/open-orchestra/open-orchestra-model-bundle/compare/v0.3.2...v0.3.3)
 - [Model interface](https://github.com/open-orchestra/open-orchestra-model-interface/compare/v0.3.2...v0.3.3)
 - [Front bundle](https://github.com/open-orchestra/open-orchestra-front-bundle/compare/v0.3.2...v0.3.3)
 - [Base bundle](https://github.com/open-orchestra/open-orchestra-base-bundle/compare/v0.3.2...v0.3.3)
 - [Base api bundle](https://github.com/open-orchestra/open-orchestra-base-api-bundle/compare/v0.3.2...v0.3.3)
 - [Base api model bundle](https://github.com/open-orchestra/open-orchestra-base-api-mongo-model-bundle/compare/v0.3.2...v0.3.3)
 - [Media bundle](https://github.com/open-orchestra/open-orchestra-media-bundle/compare/v0.3.2...v0.3.3)
 - [User bundle](https://github.com/open-orchestra/open-orchestra-user-bundle/compare/v0.3.2...v0.3.3)
 - [Theme bundle](https://github.com/open-orchestra/open-orchestra-theme-bundle/compare/v0.3.2...v0.3.3)
 - [Worflow function bundle](https://github.com/open-orchestra/open-orchestra-worflow-function-bundle/compare/v0.3.2...v0.3.3)

## Possible BC breaker

 - The api authentication strategies should only return either a `FacadeInterface` or a `ConstraintViolationListInterface` object.
   The serialization of the result is done through the same subscriber every other api request
- configuration files are rename to snake case. exemple : ``oauth2touter`` become ``oauth2_router``

## Bug fixes

## New features

## Other changes

## Deprecated method

## Suppressed method

## Configuration changes
