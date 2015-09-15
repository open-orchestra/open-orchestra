# CHANGELOG for 0.3.5

Url to see changes : 

 - [Cms bundle](https://github.com/open-orchestra/open-orchestra-cms-bundle/compare/v0.3.4...v0.3.5)
 - [Display bundle](https://github.com/open-orchestra/open-orchestra-display-bundle/compare/v0.3.4...v0.3.5)
 - [Model bundle](https://github.com/open-orchestra/open-orchestra-model-bundle/compare/v0.3.4...v0.3.5)
 - [Model interface](https://github.com/open-orchestra/open-orchestra-model-interface/compare/v0.3.4...v0.3.5)
 - [Front bundle](https://github.com/open-orchestra/open-orchestra-front-bundle/compare/v0.3.4...v0.3.5)
 - [Base bundle](https://github.com/open-orchestra/open-orchestra-base-bundle/compare/v0.3.4...v0.3.5)
 - [Base api bundle](https://github.com/open-orchestra/open-orchestra-base-api-bundle/compare/v0.3.4...v0.3.5)
 - [Base api model bundle](https://github.com/open-orchestra/open-orchestra-base-api-mongo-model-bundle/compare/v0.3.4...v0.3.5)
 - [Media bundle](https://github.com/open-orchestra/open-orchestra-media-bundle/compare/v0.3.4...v0.3.5)
 - [User bundle](https://github.com/open-orchestra/open-orchestra-user-bundle/compare/v0.3.4...v0.3.5)
 - [Theme bundle](https://github.com/open-orchestra/open-orchestra-theme-bundle/compare/v0.3.4...v0.3.5)
 - [Worflow function bundle](https://github.com/open-orchestra/open-orchestra-worflow-function-bundle/compare/v0.3.4...v0.3.5)

## Possible BC breaker

 - ``open_orchestra_model.annotation_reader`` is renamed by ``open_orchestra.annotation_reader`
 - ``open_orchestra_base.annotation_search_reader`` is moved to orchestra-libs and renamed by ``open_orchestra.annotation_search_reader``

## Bug fixes

- [Search with hidden columns in dataTable](https://trello.com/c/LrDN9srA/1285-1-etq-ubo-je-peux-faire-une-recherche-sur-la-bonne-colonne-dans-le-datatable-lorsque-qu-une-colonne-est-cache)

## New features

## Other changes

 - Mongo-odm requirement is updated to 1.0.1
 - Remove MongoDBMigrationsBundle
 - Add dynamic load on media navigation (change folder repository method)
 
## Deprecated method

## Suppressed method

## Configuration changes

 - The `LogBundle` has been split for the model, add the `ModelLogBundle` in the `AppKernel`
