# CHANGELOG for 0.3.4

Url to see changes : 

 - [Cms bundle](https://github.com/open-orchestra/open-orchestra-cms-bundle/compare/v0.3.3...v0.3.4)
 - [Display bundle](https://github.com/open-orchestra/open-orchestra-display-bundle/compare/v0.3.3...v0.3.4)
 - [Model bundle](https://github.com/open-orchestra/open-orchestra-model-bundle/compare/v0.3.3...v0.3.4)
 - [Model interface](https://github.com/open-orchestra/open-orchestra-model-interface/compare/v0.3.3...v0.3.4)
 - [Front bundle](https://github.com/open-orchestra/open-orchestra-front-bundle/compare/v0.3.3...v0.3.4)
 - [Base bundle](https://github.com/open-orchestra/open-orchestra-base-bundle/compare/v0.3.3...v0.3.4)
 - [Base api bundle](https://github.com/open-orchestra/open-orchestra-base-api-bundle/compare/v0.3.3...v0.3.4)
 - [Base api model bundle](https://github.com/open-orchestra/open-orchestra-base-api-mongo-model-bundle/compare/v0.3.3...v0.3.4)
 - [Media bundle](https://github.com/open-orchestra/open-orchestra-media-bundle/compare/v0.3.3...v0.3.4)
 - [User bundle](https://github.com/open-orchestra/open-orchestra-user-bundle/compare/v0.3.3...v0.3.4)
 - [Theme bundle](https://github.com/open-orchestra/open-orchestra-theme-bundle/compare/v0.3.3...v0.3.4)
 - [Worflow function bundle](https://github.com/open-orchestra/open-orchestra-worflow-function-bundle/compare/v0.3.3...v0.3.4)

## Possible BC breaker

- `ContentInterface`, `NodeInterface` extend `TrashCanDisplayableInterface`
- `ContentTypeInterface`, `SiteInterface` extend `SoftDeleteableInterface`
- The method  `getDeleted` of `ContentInterface`, `ContentTypeInterface` `NodeInterface` is removed and replace by method `isDeleted` of `SoftDeleteableInterface`
- In `ApiBundle` `DeletedController` is replaced by `TrashCanController`

## Bug fixes

- Image cropping has been fixed

## New features

## Other changes

 - you can now use search and pagination in trash can 
 - add `TrashCanListener` which creates a trashItem when a document which implements `TrashCanDisplayableInterface` is deleted
 - The Api errors are display in a smart notification box 
 - SuperAdmin can always acces to Group and Workflow

## Deprecated method

- The method `findAllDeleted` of `ContentRepositoryInterface` is deprecated and will be removed in 0.3.5.
- The method `findDeletedInLastVersionBySiteId` of `NodeRepositoryInterface` is deprecated and will be removed in 0.3.5.

## Suppressed method

- The constraint `PreventSavedPublishedDocument` will be removed, you should use the `AuthorizeEditionManager`
  instead.
- The listener `SavePublishedDocumentListener` will be removed, you should use the `AuthorizeEditionManager`
  instead
- The method `findLastVersionByDeletedAndSiteId` of `NodeRepositoryInterface` is removed.

## Configuration changes

 - [The gruntfile.js has been refactored](https://trello.com/c/H2W9iYDR/1259-2-gruntfile-revoir-le-loadconfig-pour-enlever-la-limitation-sur-l-ajout-de-taches-dans-des-bundles-externes-rencontree-par-nicot)
 to enhance its capabilities and ease its usage. He presents now two functions to load a single
 config file or a full config dir. The task options files do not have anymore limitation on their
 formats. You can read the doc for further information.

 Important: to be compatible with the MediaAdminBundle v0.3.4, you must update the gruntfile.js
