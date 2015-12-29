# CHANGELOG for 1.1.0-alpha3

Url to see changes : 

 - [Cms bundle](https://github.com/open-orchestra/open-orchestra-cms-bundle/compare/v1.1.0-alpha2...v1.1.0-alpha3)
 - [Display bundle](https://github.com/open-orchestra/open-orchestra-display-bundle/compare/v1.1.0-alpha2...v1.1.0-alpha3)
 - [BBCode bundle](https://github.com/open-orchestra/open-orchestra-bbcode-bundle/compare/v1.1.0-alpha2...v1.1.0-alpha3)
 - [Model bundle](https://github.com/open-orchestra/open-orchestra-model-bundle/compare/v1.1.0-alpha2...v1.1.0-alpha3)
 - [Model interface](https://github.com/open-orchestra/open-orchestra-model-interface/compare/v1.1.0-alpha2...v1.1.0-alpha3)
 - [Front bundle](https://github.com/open-orchestra/open-orchestra-front-bundle/compare/v1.1.0-alpha2...v1.1.0-alpha3)
 - [Base bundle](https://github.com/open-orchestra/open-orchestra-base-bundle/compare/v1.1.0-alpha2...v1.1.0-alpha3)
 - [Base api bundle](https://github.com/open-orchestra/open-orchestra-base-api-bundle/compare/v1.1.0-alpha2...v1.1.0-alpha3)
 - [Base api model bundle](https://github.com/open-orchestra/open-orchestra-base-api-mongo-model-bundle/compare/v1.1.0-alpha2...v1.1.0-alpha3)
 - [Media bundle](https://github.com/open-orchestra/open-orchestra-media-bundle/compare/v1.1.0-alpha2...v1.1.0-alpha3)
 - [User bundle](https://github.com/open-orchestra/open-orchestra-user-bundle/compare/v1.1.0-alpha2...v1.1.0-alpha3)
 - [Theme bundle](https://github.com/open-orchestra/open-orchestra-theme-bundle/compare/v1.1.0-alpha2...v1.1.0-alpha3)
 - [Workflow function bundle](https://github.com/open-orchestra/open-orchestra-worflow-function-bundle/compare/v1.1.0-alpha2...v1.1.0-alpha3)
 - [Media admin bundle](https://github.com/open-orchestra/open-orchestra-media-admin-bundle/compare/v1.1.0-alpha2...v1.1.0-alpha3)
 - [Orchestra libs](https://github.com/open-orchestra/open-orchestra-libs/compare/v1.1.0-alpha2...v1.1.0-alpha3)
 - [Orchestra Mongo libs](https://github.com/open-orchestra/open-orchestra-mongo-libs/compare/v1.1.0-alpha2...v1.1.0-alpha3)

## Possible BC breaker
 
 - Plugin ``Colvis`` of DataTable is replaced by the ``Buttons extension`` 
 - ``UploadedFileManager`` is moved from ``MediaBundle`` to ``MediaFileBundle``
 -  Class of ``BBcode`` folder are moved from ``MediaBundle`` folder to ``Media`` folder
 -  Service ``open_orchestra_media.manager.uploaded_media`` is renamed by ``open_orchestra_media_file.manager.storage``
 -  Application ``open-orchestra-media-demo`` no longer requires this bundles :
   - ``DoctrineMongoDBBundle``
   - ``OpenOrchestraBaseBundle``
   - ``OpenOrchestraMediaModelBundle``
   - ``OpenOrchestraMongoBundle``
   - ``OpenOrchestraModelBundle``
   - ``SolutionMongoAggregationBundle``
 -  Application ``open-orchestra-media-demo`` requires `MediaFileBundle``
 -  Route ``open_orchestra_media_get`` is now in ``MediaController`` in ``MediaFileBundle``
 - Class moved from ``MediaBundle`` to ``MediaAdminBundle`` :
    - ``FolderEvent`` 
    - ``ImagickEvent``
    - ``MediaEvent`` 
    - `DeleteMediaSubscriber``
    - ``GenerateImageSubscriber``
    - ``UploadImageSubscriber``
    -  ``FolderEvents``
    -  ``OrchestraImagick``
    -  ``OrchestraImagickFactory``
    -  ``OrchestraImagickFactoryInterface``
    -  ``OrchestraImagickInterface``
    -  ``ImageResizerManager``
    -  ``MediaEvents``
    -  ``ImageToThumbnailManager``
    -  ``PdfToImageManager``
    -  ``VideoToImageManager``
    -  ``ThumbnailInterface``
    -  ``ThumbnailManager``
    -  ``FFmpegVideoManager``
    -  ``VideoManagerInterface``
    -  ``SaveMediaManager``
    -  ``SaveMediaManagerInterface``
 
## Bug fixes

 - The node drag'n'drop has been updated to wait for user's confirmation before sending datas
 - Fix errors on template creating
 - Clean redirection and route on unpublished node
 - Fixes on Dashboard, action buttons, order ...

## New features
 
 - Possibility to add custom fields for search in the DataTable, further information in [documentation](https://github.com/open-orchestra/open-orchestra-docs/blob/master/en/developer_guide/entity_list_ajax_pagination.rst)
 - New Backbone view generic ``DataTableView`` for create a list with DataTable, used by ``TableViewCollection``
 - The build of the full project has been moved to the travis container build
 - Every facades returned by the API are now configurable and can be defined in bundles
 configuration, further information in [documentation](https://github.com/open-orchestra/open-orchestra-docs/blob/master/en/developer_guide/bundle_configuration.rst)
 - The `RoleCollector` has been split into a collector for the front office and the backoffice
 - To prevent `Status` suppression, the `StatusUsageFinder` has been created to check in every document using `Status` if
   they are using it
 - Install smartadmin Datepicker
 - Datatable preferences saving
 - Add embedded entity to content attributs
 - New bundle MediaFileBundle used to managed media files with Gaufrette 
 - Adding of upload stategies to manage all alternatives of media like thumbnail, futher information in the [documentation](https://github.com/open-orchestra/open-orchestra-docs/blob/master/en/developer_guide/media_gaufrette.rst)
 
## Other changes

  - DataTable is updated to version 1.1.0
  - Version of doctrine/cache is fixed to 1.5.*
  - Version of doctrine/commmon is fixed to 2.5.*

## Deprecated method

 - `NodeGroupRoleVoter` has been moved in the `Backoffice` folder
 - `GroupSiteVoter` has been moved in the `Backoffice` folder
 - The `AuthorizeEditionManager` has been deprecated, and all strategies has been transformed has roles
 - The `VersionableSaver` has been moved in the `Saver` folder
 - The role constant `ROLE_ACCESS_GENERAL_NODE` has been replaced by `ROLE_ACCESS_TREE_GENERAL_NODE`

## Suppressed method

## Configuration changes
