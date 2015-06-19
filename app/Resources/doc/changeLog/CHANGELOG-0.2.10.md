# CHANGELOG for 0.2.10

Url to see changes : 

 - [Cms bundle](https://github.com/open-orchestra/open-orchestra-cms-bundle/compare/v0.2.9...v0.2.10)
 - [Display bundle](https://github.com/open-orchestra/open-orchestra-display-bundle/compare/v0.2.9...v0.2.10)
 - [Model bundle](https://github.com/open-orchestra/open-orchestra-model-bundle/compare/v0.2.9...v0.2.10)
 - [Model interface](https://github.com/open-orchestra/open-orchestra-model-interface/compare/v0.2.9...v0.2.10)
 - [Front bundle](https://github.com/open-orchestra/open-orchestra-front-bundle/compare/v0.2.9...v0.2.10)
 - [Base bundle](https://github.com/open-orchestra/open-orchestra-base-bundle/compare/v0.2.9...v0.2.10)
 - [Base api bundle](https://github.com/open-orchestra/open-orchestra-base-api-bundle/compare/v0.2.9...v0.2.10)
 - [Media bundle](https://github.com/open-orchestra/open-orchestra-media-bundle/compare/v0.2.9...v0.2.10)
 - [User bundle](https://github.com/open-orchestra/open-orchestra-user-bundle/compare/v0.2.9...v0.2.10)
 - [Theme bundle](https://github.com/open-orchestra/open-orchestra-theme-bundle/compare/v0.2.9...v0.2.10)
 - [Worflow function bundle](https://github.com/open-orchestra/open-orchestra-worflow-function-bundle/compare/v0.2.9...v0.2.10)

## Possible BC breaker

 - Backbone model `site`, `block`, `Node`, `Template`, `VersionviewModel` are rename by
 `SiteModel`, `BlockModel`, `NodeMode`, `TemplateModel` and `VersionModel`
 - Backbone Collection `TableviewCollection` is deleted,
 Backbone model `NodeCollectionElement`, `TableviewElement`, `VersionviewElement` are deleted
 - The mongo `group_document` collection have been renamed into `users_group`

## Bug fixes

 - Do not force a string for the linearized attributes
 - In tinyMCE media modal, adding original format image work  

## New features

 - Add the name as key in the `ContentFacade` for the `ContentAttributeFacade` 

## Other changes

- Database fixture contains more credible content

## Deprecated method

## Suppressed method

## Configuration changes
