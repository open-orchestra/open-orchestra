# CHANGELOG for 0.2.3

Url to see changes : 

 - [Cms bundle](https://github.com/open-orchestra/open-orchestra-cms-bundle/compare/v0.2.2...v0.2.3)
 - [Display bundle](https://github.com/open-orchestra/open-orchestra-display-bundle/compare/v0.2.2...v0.2.3)
 - [Model bundle](https://github.com/open-orchestra/open-orchestra-model-bundle/compare/v0.2.2...v0.2.3)
 - [Model interface](https://github.com/open-orchestra/open-orchestra-model-interface/compare/v0.2.2...v0.2.3)
 - [Front bundle](https://github.com/open-orchestra/open-orchestra-front-bundle/compare/v0.2.2...v0.2.3)
 - [Base bundle](https://github.com/open-orchestra/open-orchestra-base-bundle/compare/v0.2.2...v0.2.3)
 - [Media bundle](https://github.com/open-orchestra/open-orchestra-media-bundle/compare/v0.2.2...v0.2.3)
 - [User bundle](https://github.com/open-orchestra/open-orchestra-user-bundle/compare/v0.2.2...v0.2.3)
 - [Theme bundle](https://github.com/open-orchestra/open-orchestra-theme-bundle/compare/v0.2.2...v0.2.3)

## Possible BC breaker

  - In the ContentRepositoryInterface, the parameters of these methods are change (default value are deleted) :
    - findLastPublishedVersionByContentIdAndLanguage
    - findByContentIdAndLanguage
    - findOneByContentIdAndLanguageAndVersion
  - In the FolderRepositoryInterface, the parameter of findAllRootFolderBySiteId are change (add siteId parameter)
  - In the NodeRepositoryInterface, the parameters of these methods are change (default value are deleted) :
    - findByParentIdAndSiteId
    - findOneByNodeIdAndLanguageAndSiteIdAndLastVersion
    - findByNodeIdAndLanguageAndSiteId
    - findByNodeIdAndLanguageAndSiteIdAndPublishedOrderedByVersion
    - findLastVersionBySiteId
    - findLastVersionByDeletedAndSiteId
    - findByNodeIdAndSiteId
    - findOneByNodeIdAndLanguageAndVersionAndSiteId
  - In the ReadNodeRepositoryInterface, the parameters of these methods are change (default value are deleted) :
    - findOneByNodeIdAndLanguageWithPublishedAndLastVersionAndSiteId

## Bug fixes

## New features

## Other changes

## Deprecated method

 - In the ReadContentRepositoryInterface, the method findByContentTypeAndChoiceTypeAndKeywords is deprecated
 - In the FolderRepositoryInterface, the method setCurrentSiteManager is deprecated
 - In the NodeRepositoryInterface, these methods are deprecated :
    - findChildsByPath
    - findByParentIdAndRoutePatternAndNotNodeId
 - In the ReadNodeRepositoryInterface, these methods are deprecated :
    - getFooterTree
    - getMenuTree
    - getSubMenu
 - In the TokenFacade, the parameters expiresIn has been renamed
 - The DisplayedElementCollectionTransformer is deprecated, the _translate link is replace by translation in data attribute data-translated-header in template.
 - The TranslateController is deprecated.

## Suppressed method

## Configuration changes
