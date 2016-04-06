# CHANGELOG for 1.1.0-RC

Url to see changes : 

 - [Cms bundle](https://github.com/open-orchestra/open-orchestra-cms-bundle/compare/v1.1.0-beta...v1.1.0-RC)
 - [Display bundle](https://github.com/open-orchestra/open-orchestra-display-bundle/compare/v1.1.0-beta...v1.1.0-RC)
 - [BBCode bundle](https://github.com/open-orchestra/open-orchestra-bbcode-bundle/compare/v1.1.0-beta...v1.1.0-RC)
 - [Model bundle](https://github.com/open-orchestra/open-orchestra-model-bundle/compare/v1.1.0-beta...v1.1.0-RC)
 - [Model interface](https://github.com/open-orchestra/open-orchestra-model-interface/compare/v1.1.0-beta...v1.1.0-RC)
 - [Front bundle](https://github.com/open-orchestra/open-orchestra-front-bundle/compare/v1.1.0-beta...v1.1.0-RC)
 - [Base bundle](https://github.com/open-orchestra/open-orchestra-base-bundle/compare/v1.1.0-beta...v1.1.0-RC)
 - [Base api bundle](https://github.com/open-orchestra/open-orchestra-base-api-bundle/compare/v1.1.0-beta...v1.1.0-RC)
 - [Base api model bundle](https://github.com/open-orchestra/open-orchestra-base-api-mongo-model-bundle/compare/v1.1.0-beta...v1.1.0-RC)
 - [Media bundle](https://github.com/open-orchestra/open-orchestra-media-bundle/compare/v1.1.0-beta...v1.1.0-RC)
 - [User bundle](https://github.com/open-orchestra/open-orchestra-user-bundle/compare/v1.1.0-beta...v1.1.0-RC)
 - [Theme bundle](https://github.com/open-orchestra/open-orchestra-theme-bundle/compare/v1.1.0-beta...v1.1.0-RC)
 - [Workflow function bundle](https://github.com/open-orchestra/open-orchestra-worflow-function-bundle/compare/v1.1.0-beta...v1.1.0-RC)
 - [Media admin bundle](https://github.com/open-orchestra/open-orchestra-media-admin-bundle/compare/v1.1.0-beta...v1.1.0-RC)
 - [Orchestra libs](https://github.com/open-orchestra/open-orchestra-libs/compare/v1.1.0-beta...v1.1.0-RC)
 - [Orchestra Mongo libs](https://github.com/open-orchestra/open-orchestra-mongo-libs/compare/v1.1.0-beta...v1.1.0-RC)
 - [Media file bundle](https://github.com/open-orchestra/open-orchestra-media-file-bundle/compare/v1.1.0-beta...v1.1.0-RC)
 - [Elastica bundle](https://github.com/open-orchestra/open-orchestra-elastica-bundle/compare/v1.1.0-beta...v1.1.0-RC)


## New features

- Test on mandatory main alias in site form [#1542](https://github.com/open-orchestra/open-orchestra-cms-bundle/pull/1542)
- Remove permanently a entity in trash can [#1539](https://github.com/open-orchestra/open-orchestra-cms-bundle/pull/1539)
- Enhance area form in template, node and area [#1537](https://github.com/open-orchestra/open-orchestra-cms-bundle/pull/1537)
- When a content is deleted, it's removed to elastica index [#25](https://github.com/open-orchestra/open-orchestra-elastica-bundle/pull/25)
- When a content is restored, it's added to elastica index [#25](https://github.com/open-orchestra/open-orchestra-elastica-bundle/pull/25)
- A root folder is created when a new website is created [#190](https://github.com/open-orchestra/open-orchestra-media-admin-bundle/pull/190)

## Manual changes
- The BlockContainerInterface has a nex method: removeBlockWithKey [#173](https://github.com/open-orchestra/open-orchestra-model-interface/pull/173)
So if you have implemented this interface, you need to update your class

## Bug fixes

- Fix position of property `validationGroups` in method `isValid` of `BaseApiBundle/Controller/BaseController` [#76](https://github.com/open-orchestra/open-orchestra-base-api-bundle/pull/76)
- Fix transform area from another site as the current site [#1544](https://github.com/open-orchestra/open-orchestra-cms-bundle/pull/1544)
- Unused blocks are now definitely suppressed from DB when deleted from a node and used no more [#1540](https://github.com/open-orchestra/open-orchestra-cms-bundle/pull/1540)
- Fix error type of property ``updateAt`` in content type schema [#24](https://github.com/open-orchestra/open-orchestra-elastica-bundle/pull/24)
- A required oo_media_choice form type is now correctly handled [#195](https://github.com/open-orchestra/open-orchestra-media-admin-bundle/pull/195)
- Remove link constraint on media display block [#194](https://github.com/open-orchestra/open-orchestra-media-admin-bundle/pull/194)
- Method ``testUniquenessInContext`` is now based on ``nodeId`` and not ``name`` [#543](https://github.com/open-orchestra/open-orchestra-model-bundle/pull/543)
- Demo fixtures are updated to present block usage references [#542](https://github.com/open-orchestra/open-orchestra-model-bundle/pull/542)
- Path on node is updated only if node isn't deleted [#541](https://github.com/open-orchestra/open-orchestra-model-bundle/pull/541)

## Other changes

- Get master request in method where it is used and not in a constructor [#150](https://github.com/open-orchestra/open-orchestra-front-bundle/pull/150)

## Possible BC breaker

- The `TrashItem` document has a new property `type` [#541](https://github.com/open-orchestra/open-orchestra-model-bundle/pull/541)
- The `TrashItemInterface` has a new property `type` [#172](https://github.com/open-orchestra/open-orchestra-model-interface/pull/172)
- The `TrashItemRepositoryInterface` has a new method `findByEntity($entityId)` [#172](https://github.com/open-orchestra/open-orchestra-model-interface/pull/172)
