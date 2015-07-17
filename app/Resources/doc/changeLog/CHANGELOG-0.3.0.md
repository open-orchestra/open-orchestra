# CHANGELOG for 0.3.0

Url to see changes : 

 - [Cms bundle](https://github.com/open-orchestra/open-orchestra-cms-bundle/compare/v0.2.12...v0.3.0)
 - [Display bundle](https://github.com/open-orchestra/open-orchestra-display-bundle/compare/v0.2.12...v0.3.0)
 - [Model bundle](https://github.com/open-orchestra/open-orchestra-model-bundle/compare/v0.2.12...v0.3.0)
 - [Model interface](https://github.com/open-orchestra/open-orchestra-model-interface/compare/v0.2.12...v0.3.0)
 - [Front bundle](https://github.com/open-orchestra/open-orchestra-front-bundle/compare/v0.2.12...v0.3.0)
 - [Base bundle](https://github.com/open-orchestra/open-orchestra-base-bundle/compare/v0.2.12...v0.3.0)
 - [Base api bundle](https://github.com/open-orchestra/open-orchestra-base-api-bundle/compare/v0.2.12...v0.3.0)
 - [Media bundle](https://github.com/open-orchestra/open-orchestra-media-bundle/compare/v0.2.12...v0.3.0)
 - [User bundle](https://github.com/open-orchestra/open-orchestra-user-bundle/compare/v0.2.12...v0.3.0)
 - [Theme bundle](https://github.com/open-orchestra/open-orchestra-theme-bundle/compare/v0.2.12...v0.3.0)
 - [Worflow function bundle](https://github.com/open-orchestra/open-orchestra-worflow-function-bundle/compare/v0.2.12...v0.3.0)

## Possible BC breaker
 - Add four methods in ``ContentRepositoryInterface`` :
     - ``getDefaultListable()``
     - ``addDefaultListable($name, $value)``
     - ``removeDefaultListable($name)``
     - ``setDefaultListable(array $defaultListable)``

## Bug fixes

## New features
 - [Possibility to hide the default columns in the dataTable](https://trello.com/c/1XZeixzR/1143-2-etq-ubo-je-peux-specifier-quels-sont-les-colonnes-que-je-veux-afficher-dans-les-content-champs-de-base-pas-les-attributs)
 - [Content attributes from other format than string can be display on datatable thanks to transformer](https://trello.com/c/kfPjUfqP/1099-5-bo-datatable-les-attributs-complexes-dont-la-value-est-un-array-ou-autre-ne-sont-pas-rendus-correctement-dans-la-liste-array-p)

## Other changes
 - [site 1 (front site) is removed of fixtures](https://trello.com/c/a4qKLD2V/542-1-etq-dev-je-n-ai-plus-de-test-qui-porte-sur-le-site-1-des-fixtures)

## Deprecated method

## Suppressed method
 - ``AddLinearize`` method and ``linearize`` attribute from ``ContentFacade`` are removed
 
## Configuration changes
