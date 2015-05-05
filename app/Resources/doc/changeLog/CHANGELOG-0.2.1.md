# CHANGELOG for 0.2.1

Url to see changes : 

 - [Cms bundle](https://github.com/open-orchestra/open-orchestra-cms-bundle/compare/v0.2.0...v0.2.1)
 - [Display bundle](https://github.com/open-orchestra/open-orchestra-display-bundle/compare/v0.2.0...v0.2.1)
 - [Model bundle](https://github.com/open-orchestra/open-orchestra-model-bundle/compare/v0.2.0...v0.2.1)
 - [Model interface](https://github.com/open-orchestra/open-orchestra-model-interface/compare/v0.2.0...v0.2.1)
 - [Front bundle](https://github.com/open-orchestra/open-orchestra-front-bundle/compare/v0.2.0...v0.2.1)
 - [Base bundle](https://github.com/open-orchestra/open-orchestra-base-bundle/compare/v0.2.0...v0.2.1)
 - [Media bundle](https://github.com/open-orchestra/open-orchestra-media-bundle/compare/v0.2.0...v0.2.1)
 - [User bundle](https://github.com/open-orchestra/open-orchestra-user-bundle/compare/v0.2.0...v0.2.1)
 - [Theme bundle](https://github.com/open-orchestra/open-orchestra-theme-bundle/compare/v0.2.0...v0.2.1)

## Possible BC breaker


## Bug fixes

## New features

## Other changes

## Deprecated method

 - The Statusable trait was in the model-bundle, it has been moved to model-interface

## Suppressed method

## Configuration changes

 - There are now only relations on interfaces :

        OpenOrchestra\ModelInterface\Model\EmbedStatusInterface: OpenOrchestra\ModelInterface\Model\EmbedStatus
        OpenOrchestra\ModelInterface\Model\RoleInterface: OpenOrchestra\ModelBundle\Model\Role
        OpenOrchestra\ModelInterface\Model\AreaInterface: OpenOrchestra\ModelBundle\Model\Area
        OpenOrchestra\ModelInterface\Model\BlockInterface: OpenOrchestra\ModelBundle\Model\Block
        OpenOrchestra\ModelInterface\Model\StatusInterface: OpenOrchestra\ModelBundle\Model\Status
        OpenOrchestra\ModelInterface\Model\ThemeInterface: OpenOrchestra\ModelBundle\Model\Theme
        OpenOrchestra\ModelInterface\Model\SiteAliasInterface: OpenOrchestra\ModelBundle\Model\SiteAlias
        OpenOrchestra\ModelInterface\Model\ContentAttributeInterface: OpenOrchestra\ModelBundle\Model\ContentAttribute
        OpenOrchestra\ModelInterface\Model\FieldTypeInterface: OpenOrchestra\ModelBundle\Model\FieldType
        OpenOrchestra\ModelInterface\Model\FieldOptionInterface: OpenOrchestra\ModelBundle\Model\FieldOption
