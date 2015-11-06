# CHANGELOG for 1.1.0-alpha2

Url to see changes : 

 - [Cms bundle](https://github.com/open-orchestra/open-orchestra-cms-bundle/compare/v1.0.0...v1.1.0-alpha2)
 - [Display bundle](https://github.com/open-orchestra/open-orchestra-display-bundle/compare/v1.0.0...v1.1.0-alpha2)
 - [Model bundle](https://github.com/open-orchestra/open-orchestra-model-bundle/compare/v1.0.0...v1.1.0-alpha2)
 - [Model interface](https://github.com/open-orchestra/open-orchestra-model-interface/compare/v1.0.0...v1.1.0-alpha2)
 - [Front bundle](https://github.com/open-orchestra/open-orchestra-front-bundle/compare/v1.0.0...v1.1.0-alpha2)
 - [Base bundle](https://github.com/open-orchestra/open-orchestra-base-bundle/compare/v1.0.0...v1.1.0-alpha2)
 - [Base api bundle](https://github.com/open-orchestra/open-orchestra-base-api-bundle/compare/v1.0.0...v1.1.0-alpha2)
 - [Base api model bundle](https://github.com/open-orchestra/open-orchestra-base-api-mongo-model-bundle/compare/v1.0.0...v1.1.0-alpha2)
 - [Media bundle](https://github.com/open-orchestra/open-orchestra-media-bundle/compare/v1.0.0...v1.1.0-alpha2)
 - [User bundle](https://github.com/open-orchestra/open-orchestra-user-bundle/compare/v1.0.0...v1.1.0-alpha2)
 - [Theme bundle](https://github.com/open-orchestra/open-orchestra-theme-bundle/compare/v1.0.0...v1.1.0-alpha2)
 - [Workflow function bundle](https://github.com/open-orchestra/open-orchestra-worflow-function-bundle/compare/v1.0.0...v1.1.0-alpha2)
 - [Media admin bundle](https://github.com/open-orchestra/open-orchestra-media-admin-bundle/compare/v1.0.0...v1.1.0-alpha2)

## Possible BC breaker

 - The name of `OpenOrchestra\BackofficeBundle\Form\Type\AreaType` is now `oo_area`
 - The name of `OpenOrchestra\BackofficeBundle\Form\Type\BlockChoiceType` is now `oo_block_choice`
 - The name of `OpenOrchestra\BackofficeBundle\Form\Type\BlockType` is now `oo_block`
 - The name of `OpenOrchestra\BackofficeBundle\Form\Type\ExistingBlockChoiceType` is now `oo_existing_block`
 - The name of `OpenOrchestra\BackofficeBundle\Form\Type\NodeType` is now `oo_node`

## Bug fixes

 - User is now able to delete a media folder when the last media is deleted, without having to refresh the page.

## New features

 - Adding roles for nodes (CREATE, UPDATE, MOVE, DELETE)
 - Adding roles for content types (CREATE, UPDATE, DELETE)
 - Adding roles for keywords (CREATE, UPDATE, DELETE)
 - Adding roles for redirections (CREATE, UPDATE, DELETE)
 - Adding roles for trashcan (RESTORE)
 - Adding roles for api accesses (CREATE, UPDATE, DELETE)
 - Adding roles for contents (CREATE, UPDATE, DELETE)
 - Adding roles for medias (CREATE, UPDATE, DELETE)
 - Adding roles for roles (CREATE, UPDATE, DELETE)
 - Adding roles for sites (CREATE, UPDATE, DELETE)
 - Adding roles for users (CREATE, UPDATE, DELETE)
 - Adding roles for transverse nodes (UPDATE)
 - Adding roles for workflow status (CREATE, UPDATE, DELETE)
 - Adding roles for workflow functions (CREATE, UPDATE, DELETE)


## Other changes
  
  - In differents dataTable, the global search is disabled. To reactivate it, you can use the data attribute ``display-global-search=true`` in the link in navigation panel.
  
## Deprecated method

## Suppressed method

## Configuration changes
