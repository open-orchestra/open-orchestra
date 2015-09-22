# CHANGELOG for 1.0.0-RC-1

Url to see changes : 

 - [Cms bundle](https://github.com/open-orchestra/open-orchestra-cms-bundle/compare/v0.3.4...v1.0.0-RC1)
 - [Display bundle](https://github.com/open-orchestra/open-orchestra-display-bundle/compare/v0.3.4...v1.0.0-RC1)
 - [Model bundle](https://github.com/open-orchestra/open-orchestra-model-bundle/compare/v0.3.4...v1.0.0-RC1)
 - [Model interface](https://github.com/open-orchestra/open-orchestra-model-interface/compare/v0.3.4...v1.0.0-RC1)
 - [Front bundle](https://github.com/open-orchestra/open-orchestra-front-bundle/compare/v0.3.4...v1.0.0-RC1)
 - [Base bundle](https://github.com/open-orchestra/open-orchestra-base-bundle/compare/v0.3.4...v1.0.0-RC1)
 - [Base api bundle](https://github.com/open-orchestra/open-orchestra-base-api-bundle/compare/v0.3.4...v1.0.0-RC1)
 - [Base api model bundle](https://github.com/open-orchestra/open-orchestra-base-api-mongo-model-bundle/compare/v0.3.4...v1.0.0-RC1)
 - [Media bundle](https://github.com/open-orchestra/open-orchestra-media-bundle/compare/v0.3.4...v1.0.0-RC1)
 - [User bundle](https://github.com/open-orchestra/open-orchestra-user-bundle/compare/v0.3.4...v1.0.0-RC1)
 - [Theme bundle](https://github.com/open-orchestra/open-orchestra-theme-bundle/compare/v0.3.4...v1.0.0-RC1)
 - [Worflow function bundle](https://github.com/open-orchestra/open-orchestra-worflow-function-bundle/compare/v0.3.4...v1.0.0-RC1)

## Possible BC breaker

 - ``open_orchestra_model.annotation_reader`` is renamed by ``open_orchestra.annotation_reader`
 - ``open_orchestra_base.annotation_search_reader`` is moved to orchestra-libs and renamed by ``open_orchestra.annotation_search_reader``
 - Adding new bundle (OpenOrchestraMongoBundle)
 - The parameter ``descriptionEntity`` in ``FinderConfiguration`` is now composed of array (``Array("key" => "", "field" => "", "type" => "")`` futher information [documentation] (https://github.com/open-orchestra/open-orchestra-docs/blob/master/en/developer_guide/entity_list_ajax_pagination.rst)

## Bug fixes

- [Search with hidden columns in dataTable](https://trello.com/c/LrDN9srA/1285-1-etq-ubo-je-peux-faire-une-recherche-sur-la-bonne-colonne-dans-le-datatable-lorsque-qu-une-colonne-est-cache)

## New features

- You can describe the mapping for search in Yaml and XMl, futher information in [documentation] (https://github.com/open-orchestra/open-orchestra-docs/blob/master/en/developer_guide/entity_list_ajax_pagination.rst) 
- [A BBcode bundle is introduced to allow you to extend the rich text editor](https://trello.com/c/7ZaSD82H/1289-3-etq-dev-j-ai-acces-a-un-bundle-qui-wrap-la-lib-jbbcode)
- [A new BBcode tag is available for media](https://trello.com/c/xS32c3Rd/1326-3-ajout-des-tags-du-mediabundle)
- add new interface and command line to allow all, unit or functionnal tests loading

## Other changes

 - Mongo-odm requirement is updated to 1.0.1
 - Remove MongoDBMigrationsBundle
 - [A refacto has been made to simplify the navigation](https://trello.com/c/7oj9DRod/1347-2-faire-une-mecanique-de-strategie-pour-les-liens-de-niveau-0-du-menu-de-navigation)
 - Upgrade to mongo-odm 1.0.2, mongo-odm-bundle 3.0.1
 - Acces Token no more revoked
 - Upgrade to symfony 2.7.4
 - Upgrade to twig/extensions 1.3.0
 - Upgrade to symfony/assetic-bundle 2.7.0
 - Upgrade to friendsofsymfony/http-cache-bundle 1.3.3
 - Upgrade to phpunit/phpunit 4.8.8
 
## Deprecated method

## Suppressed method

## Configuration changes

 - The `LogBundle` has been split for the model, add the `ModelLogBundle` in the `AppKernel`
