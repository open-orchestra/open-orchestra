# CHANGELOG for 1.1.0-alpha4

Url to see changes : 

 - [Cms bundle](https://github.com/open-orchestra/open-orchestra-cms-bundle/compare/v1.1.0-alpha3...v1.1.0-alpha4)
 - [Display bundle](https://github.com/open-orchestra/open-orchestra-display-bundle/compare/v1.1.0-alpha3...v1.1.0-alpha4)
 - [BBCode bundle](https://github.com/open-orchestra/open-orchestra-bbcode-bundle/compare/v1.1.0-alpha3...v1.1.0-alpha4)
 - [Model bundle](https://github.com/open-orchestra/open-orchestra-model-bundle/compare/v1.1.0-alpha3...v1.1.0-alpha4)
 - [Model interface](https://github.com/open-orchestra/open-orchestra-model-interface/compare/v1.1.0-alpha3...v1.1.0-alpha4)
 - [Front bundle](https://github.com/open-orchestra/open-orchestra-front-bundle/compare/v1.1.0-alpha3...v1.1.0-alpha4)
 - [Base bundle](https://github.com/open-orchestra/open-orchestra-base-bundle/compare/v1.1.0-alpha3...v1.1.0-alpha4)
 - [Base api bundle](https://github.com/open-orchestra/open-orchestra-base-api-bundle/compare/v1.1.0-alpha3...v1.1.0-alpha4)
 - [Base api model bundle](https://github.com/open-orchestra/open-orchestra-base-api-mongo-model-bundle/compare/v1.1.0-alpha3...v1.1.0-alpha4)
 - [Media bundle](https://github.com/open-orchestra/open-orchestra-media-bundle/compare/v1.1.0-alpha3...v1.1.0-alpha4)
 - [User bundle](https://github.com/open-orchestra/open-orchestra-user-bundle/compare/v1.1.0-alpha3...v1.1.0-alpha4)
 - [Theme bundle](https://github.com/open-orchestra/open-orchestra-theme-bundle/compare/v1.1.0-alpha3...v1.1.0-alpha4)
 - [Workflow function bundle](https://github.com/open-orchestra/open-orchestra-worflow-function-bundle/compare/v1.1.0-alpha3...v1.1.0-alpha4)
 - [Media admin bundle](https://github.com/open-orchestra/open-orchestra-media-admin-bundle/compare/v1.1.0-alpha3...v1.1.0-alpha4)
 - [Orchestra libs](https://github.com/open-orchestra/open-orchestra-libs/compare/v1.1.0-alpha3...v1.1.0-alpha4)
 - [Orchestra Mongo libs](https://github.com/open-orchestra/open-orchestra-mongo-libs/compare/v1.1.0-alpha3...v1.1.0-alpha4)
 - [Media file bundle](https://github.com/open-orchestra/open-orchestra-media-file-bundle/compare/v1.1.0-alpha3...v1.1.0-alpha4)

## Possible BC breaker
 - ``NodeGroupRoleTransformer`` implements now ``TransformerWithGroupInterface``
 - Method ``reverseTransform`` of ``NodeGroupRoleTransformer`` is removed and replaced by ``reverseTransformWithGroup``
 - Before ``composer install|update`` it's recommanded to removed ``nodes_modules`` and ``bower_components`` folders of your application and ``bower.json`` and ``package.json`` files. Remove also symlink in ``web/fonts`` 
 - You can move your bower and npm dependencies in ``composer.json`` of your project or bundle

## Bug fixes
 - The Back Office is compatible again with Internet Explorer 9. See Configurations changes for more info
 - Fix a bug when a site declared in Apache conf but not in Orchestra was accessed by a client

## New features
 - You can specify your bower and npm dependencies directly in the composer.json, futher information in the [documentation](https://github.com/open-orchestra/open-orchestra-docs/blob/master/en/developer_guide/assets_bower_npm.rst)
  - Selector version of node tranverse is removed
  - Duplicate button of node tranverse is removed
  - Delete button of node tranverse is removed

## Other changes
 - PHP requirement has been updated to 5.5 
 - Version of ``symfony/symfony`` is updated to 2.8.1
 - Version of ``twig/twig`` is updated to ~1.23
 - Version of ``friendsofsymfony/http-cache-bundle`` is updated to 1.3.6
 - Flow.js dependency has been moved from CmsBundle to MediaAdminBundle
 - Media alternatives files (mainly images) have new auto-generated names

## Deprecated method

## Suppressed method

## Configuration changes
  - ``pace.js`` is removed and replace by a custom component ``OpenOrchestra.AjaxLoader.AjaxLoaderView``
  - To get the Back Office compatible again with Internet Explorer 9, some grunt tasks have been rewrote. Be
   sure to update your Open Orchestra tasks according to [these Pull Request](https://github.com/open-orchestra/open-orchestra/pull/791/files)
  - ``gridstack.js `` is removed
  - ``lodash.js`` is removed