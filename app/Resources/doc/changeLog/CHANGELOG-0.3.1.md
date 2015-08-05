# CHANGELOG for 0.3.1

Url to see changes : 

 - [Cms bundle](https://github.com/open-orchestra/open-orchestra-cms-bundle/compare/v0.3.0...v0.3.1)
 - [Display bundle](https://github.com/open-orchestra/open-orchestra-display-bundle/compare/v0.3.0...v0.3.1)
 - [Model bundle](https://github.com/open-orchestra/open-orchestra-model-bundle/compare/v0.3.0...v0.3.1)
 - [Model interface](https://github.com/open-orchestra/open-orchestra-model-interface/compare/v0.3.0...v0.3.1)
 - [Front bundle](https://github.com/open-orchestra/open-orchestra-front-bundle/compare/v0.3.0...v0.3.1)
 - [Base bundle](https://github.com/open-orchestra/open-orchestra-base-bundle/compare/v0.3.0...v0.3.1)
 - [Base api bundle](https://github.com/open-orchestra/open-orchestra-base-api-bundle/compare/v0.3.0...v0.3.1)
 - [Base api model bundle](https://github.com/open-orchestra/open-orchestra-base-api-mongo-model-bundle/compare/v0.3.0...v0.3.1)
 - [Media bundle](https://github.com/open-orchestra/open-orchestra-media-bundle/compare/v0.3.0...v0.3.1)
 - [User bundle](https://github.com/open-orchestra/open-orchestra-user-bundle/compare/v0.3.0...v0.3.1)
 - [Theme bundle](https://github.com/open-orchestra/open-orchestra-theme-bundle/compare/v0.3.0...v0.3.1)
 - [Worflow function bundle](https://github.com/open-orchestra/open-orchestra-worflow-function-bundle/compare/v0.3.0...v0.3.1)

## Possible BC breaker

 - In DisplayBlockInterface `getTags` is renamed to `getCacheTags`.
 - A `BaseApiModelBundle` has been added, this way you can use the `BaseApiBundle` with no relation to mongo

## Bug fixes

## New features

 - [Possibility to custom field default value in content attribute](https://trello.com/c/w8EXOG08/1166-3-bo-contenttype-je-peux-ajouter-des-fields-par-defaut-au-choice-sans-casser-l-affichage-en-datatable)
 - [Possibility to define a tempalte wysiwyg for the block configurable content](https://trello.com/c/CFX1aopU/856-0-5-etq-ubo-je-peux-definir-un-template-par-wysiwyg-pour-le-bloc-configurablecontent)
 - [Custom pages for 503 errors are now availables in Back Office](https://trello.com/c/vWmk60YN/548-3-etq-ufront-je-vois-une-page-d-attente-dont-l-url-est-parametree-en-bo-avec-code-http-503-quand-le-site-est-mis-en-maintenance-)
 - [Custom pages for 404 errors are now availables in Back Office](https://trello.com/c/DDpDAQNC/1195-2-etq-ufront-je-vois-une-page-404-contribuee-dans-le-bo)

## Other changes

 - `getContentType` has been moved from `ContentInterface` to `ReadContentInterface`
 - add datatables-bootstrap3, lodash and gridstack to bower.json
 - [FosHttpCacheBundle requirement has been changed to 1.3.2](https://trello.com/c/ur1o05Ol/1030-2-update-de-version-foshttpcachebundle)
 - [Update smartadmin to 1.6.1] (https://trello.com/c/ly16tT52/1231-3-etq-ubo-je-vois-la-derniere-version-de-smartadmin-utilisee)
 - Update bootstrap to 3.3.4 in bower.json
 - You could add an external media domain

## Deprecated method

 - ``GaufretteManager`` is deprecated and will be removed in 0.3.2 , used ``UploadMediaManager``
 
## Suppressed method

- ``ModelBundle/Repository/AbstractRepository`` is suppressed
 - The trait ``TranslatedValueFilter`` is suppressed
 - The interface ``VersionnableInterface`` is suppressed, use ``VersionableInterface`` instead
 - ``ModelInterface/Model/NodeInterface/getInFooter`` is suppressed, use ``ModelInterface/Model/NodeInterface/isInFooter`` instead
 - ``ModelInterface/Model/NodeInterface/getInMenu`` is suppressed, use ``ModelInterface/Model/NodeInterface/isInMenu`` instead
 - ``ModelInterface/Model/SiteInterface/getDeleted`` is suppressed, use ``ModelInterface/Model/SiteInterface/isDeleted`` instead
 - ``ModelInterface/Repository/ContentTypeRepositoryInterface/findAllByDeletedInLastVersion`` is suppressed,
    use ``ModelInterface/Repository/ContentTypeRepositoryInterface/findAllNotDeletedInLastVersion`` instead
 - ``ModelInterface/Repository/ContentTypeRepositoryInterface/findAllByDeletedInLastVersionForPaginateAndSearch`` is suppressed,
    use ``ModelInterface/Repository/ContentTypeRepositoryInterface/findAllNotDeletedInLastVersionForPaginate`` instead
 - ``ModelInterface/Repository/NodeRepositoryInterface/findOneByNodeIdAndLanguageAndSiteIdAndLastVersion`` is suppressed, 
    use ``ModelInterface/Repository/NodeRepositoryInterface/findOneByNodeIdAndLanguageAndSiteIdInLastVersion`` instead
 - ``ModelInterface/Repository/NodeRepositoryInterface/findChildsByPathAndSiteIdAndLanguage`` is suppressed, 
    use ``ModelInterface/Repository/NodeRepositoryInterface/findChildrenByPathAndSiteIdAndLanguage`` instead
 - ``ModelInterface/Repository/NodeRepositoryInterface/findOneByNodeIdAndLanguageAndVersionAndSiteId`` is suppressed, 
    use ``ModelInterface/Repository/NodeRepositoryInterface/findOneByNodeIdAndLanguageAndSiteIdAndVersion`` instead
 - `` ModelInterface/Repository/ReadNodeRepositoryInterface/findOneByNodeIdAndLanguageWithPublishedAndLastVersionAndSiteId`` is suppressed, 
    use ``ModelInterface/Repository/ReadNodeRepositoryInterface/findOnePublishedByNodeIdAndLanguageAndSiteIdInLastVersion`` instead
 - ``ModelBundle/Document/Area/setClasses`` is suppressed, use ``ModelBundle/Document/Area/setHtmlClass`` instead
 - ``ModelBundle/Document/Area/getClasses`` is suppressed, use ``ModelBundle/Document/Area/getHtmlClass`` instead
 - ``ModelBundle/Repository/ContentRepository/findByContentTypeInLastVersion`` is suppressed, 
    use ``ModelBundle/Repository/ContentRepository/findByContentTypeInLastVersionForPaginate`` instead
 - `` ModelBundle/Repository/ContentTypeRepository/createAggregateQueryByDeletedAndLastVersion`` is suppressed, 
     use `` ModelBundle/Repository/ContentTypeRepository/createAggregateQueryNotDeletedInLastVersion`` instead

## Configuration changes

 - Activate the `BaseApiModelBundle` : `new OpenOrchestra\BaseApiModelBundle\OpenOrchestraBaseApiModelBundle()`
