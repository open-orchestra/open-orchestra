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

## Bug fixes

 - The node drag'n'drop has been updated to wait for user's confirmation before sending datas

## New features
 
 - Possibility to add custom fields for search in the DataTable, further information in [documentation](https://github.com/open-orchestra/open-orchestra-docs/blob/master/en/developer_guide/entity_list_ajax_pagination.rst)
 - New Backbone view generic ``DataTableView`` for create a list with DataTable, used by ``TableViewCollection``
 - The build of the full project has been moved to the travis container build
 - Every facades returned by the API are now configurable and can be defined in bundles
 configuration, further information in [documentation](https://github.com/open-orchestra/open-orchestra-docs/blob/master/en/developer_guide/bundle_configuration.rst)
 - The `RoleCollector` has been split into a collector for the front office and the backoffice
 - To prevent `Status` suppression, the `StatusUsageFinder` has been created to check in every document using `Status` if
   they are using it
 
## Other changes

  - DataTable is updated to version 1.1.0

## Deprecated method

 - `NodeGroupRoleVoter` has been moved in the `Backoffice` folder
 - `GroupSiteVoter` has been moved in the `Backoffice` folder
 - The `AuthorizeEditionManager` has been deprecated, and all strategies has been transformed has roles
 - The `VersionableSaver` has been moved in the `Saver` folder
 - The role constant `ROLE_ACCESS_GENERAL_NODE` has been replaced by `ROLE_ACCESS_TREE_GENERAL_NODE`

## Suppressed method

## Configuration changes
