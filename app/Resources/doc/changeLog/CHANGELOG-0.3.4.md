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

## Bug fixes

- Image are cropping is fix

## New features

## Other changes

- The Api errors are display in a smart notification box 
- SuperAdmin can always acces to Group and Workflo

## Deprecated method

## Suppressed method

- The constraint `PreventSavedPublishedDocument` will be removed, you should use the `AuthorizeEditionManager`
  instead.
- The listener `SavePublishedDocumentListener` will be removed, you should use the `AuthorizeEditionManager`
  instead

## Configuration changes
 - [The gruntfile.js has been refactored](https://trello.com/c/H2W9iYDR/1259-2-gruntfile-revoir-le-loadconfig-pour-enlever-la-limitation-sur-l-ajout-de-taches-dans-des-bundles-externes-rencontree-par-nicot)
 to enhance its capabilities and ease its usage. He presents now two functions to load a single
 config file or a full config dir. The task options files do not have anymore limitation on their
 formats. You can read the doc for further information.

 Important: to be compatible with the MediaAdminBundle v0.3.4, you must update the gruntfile.js
