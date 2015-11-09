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
 - The name of `OpenOrchestra\BackofficeBundle\Form\Type\ApiClientType` is now `oo_api_client`
 - The class `OpenOrchestra\BackofficeBundle\Form\Type\OrchestraColorPickerType` is deleted and replaced by `OpenOrchestra\BackofficeBundle\Form\Type\ColorPickerType`
 - The class `OpenOrchestra\BackofficeBundle\Form\Type\OrchestraChoicesOption` is deleted and replaced by `OpenOrchestra\BackofficeBundle\Form\Type\Component\ChoicesOptionType`
 - The class `OpenOrchestra\BackofficeBundle\Form\Type\OrchestraContentTypeChoiceType` is deleted and replaced by `OpenOrchestra\BackofficeBundle\Form\Type\Component\ContentTypeChoiceType`
 - The class `OpenOrchestra\BackofficeBundle\Form\Type\OrchestraDateWidgetOption` is deleted and replaced by `OpenOrchestra\BackofficeBundle\Form\Type\Component\DateWidgetOptionType`
 - The class `OpenOrchestra\BackofficeBundle\Form\Type\OrchestraFieldChoice` is deleted and replaced by `OpenOrchestra\BackofficeBundle\Form\Type\Component\FieldChoiceType`
 - The class `OpenOrchestra\BackofficeBundle\Form\Type\OrchestraKeywordsType` is deleted and replaced by `OpenOrchestra\BackofficeBundle\Form\Type\Component\KeywordsChoiceType`
 - The class `OpenOrchestra\BackofficeBundle\Form\Type\OrchestraNodeChoiceType` is deleted and replaced by `OpenOrchestra\BackofficeBundle\Form\Type\Component\NodeChoiceType`
 - The class `OpenOrchestra\BackofficeBundle\Form\Type\OrchestraRoleChoiceType` is deleted and replaced by `OpenOrchestra\BackofficeBundle\Form\Type\Component\RoleChoiceType`
 - The class `OpenOrchestra\BackofficeBundle\Form\Type\OrchestraSiteChoiceType` is deleted and replaced by `OpenOrchestra\BackofficeBundle\Form\Type\Component\SiteChoiceType`
 - The class `OpenOrchestra\BackofficeBundle\Form\Type\OrchestraThemeChoiceType` is deleted and replaced by `OpenOrchestra\BackofficeBundle\Form\Type\Component\ThemeChoiceType`
 - The class `OpenOrchestra\BackofficeBundle\Form\Type\OrchestraVideoType` is deleted and replaced `OpenOrchestra\BackofficeBundle\Form\Type\VideoType`
 - The name of `OpenOrchestra\BackofficeBundle\Form\Type\ContentType` is now `oo_content`
 - The name of `OpenOrchestra\BackofficeBundle\Form\Type\ContentTypeType` is now `oo_content_type`
 - The name of `OpenOrchestra\BackofficeBundle\Form\Type\FieldOptionType` is now `oo_field_option`
 - The name of `OpenOrchestra\BackofficeBundle\Form\Type\FieldTypeType` is now `oo_field_type`
 - The name of `OpenOrchestra\BackofficeBundle\Form\Type\GroupType` is now `oo_group`
 - The name of `OpenOrchestra\BackofficeBundle\Form\Type\KeywordType` is now `oo_keyword`
 - The name of `OpenOrchestra\BackofficeBundle\Form\Type\RedirectionType` is now `oo_redirection`
 - The name of `OpenOrchestra\BackofficeBundle\Form\Type\RoleType` is now `oo_role`
 - The name of `OpenOrchestra\BackofficeBundle\Form\Type\SiteAliasType` is now `oo_site_alias`
 - The name of `OpenOrchestra\BackofficeBundle\Form\Type\SiteType` is now `oo_site`
 - The name of `OpenOrchestra\BackofficeBundle\Form\Type\StatusType` is now `oo_status`
 - The name of `OpenOrchestra\BackofficeBundle\Form\Type\TemplateType` is now `oo_template`
 - The name of `OpenOrchestra\BackofficeBundle\Form\Type\ThemeType` is now `oo_theme`
 - The name of `OpenOrchestra\BackofficeBundle\Form\Type\TinymceType` is now `oo_tinymce`
 - The name of `OpenOrchestra\BackofficeBundle\Form\Type\TranslatedValueCollectionType` is now `oo_translated_value_collection`
 - The name of `OpenOrchestra\BackofficeBundle\Form\Type\TranslatedValueType` is now `oo_translated_value`
 - The class `OpenOrchestra\BackofficeBundle\Form\Type\OrchestraGroupType` is deleted and replaced by `OpenOrchestra\GroupBundle\Form\Type\GroupDocumentType`
 - The name of `OpenOrchestra\MediaAdminBundle\Form\Type\FolderType` is now `oo_folder`
 - The name of `OpenOrchestra\MediaAdminBundle\Form\Type\MediaCropType` is now `oo_media_crop`
 - The name of `OpenOrchestra\MediaAdminBundle\Form\Type\MediaMetaType` is now `oo_media_meta`
 - The name of `OpenOrchestra\MediaAdminBundle\Form\Type\MediaType` is now `oo_media`
 - The class `OpenOrchestra\MediaAdminBundle\Form\DataTransformer\OrchestraMediaTransformer` is deleted and replaced by `OpenOrchestra\MediaAdminBundle\Form\DataTransformer\MediaChoiceTransformer`
 - The class `OpenOrchestra\MediaAdminBundle\Form\Type\OrchestraMediaType` is deleted and replaced by `OpenOrchestra\MediaAdminBundle\Form\Type\Component\MediaChoiceType`
 - The class `OpenOrchestra\MediaAdminBundle\Form\Type\OrchestraSiteForFolderChoiceType` is deleted and replaced by `OpenOrchestra\MediaAdminBundle\Form\Type\SiteForFolderChoiceType`

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
