# CHANGELOG for 0.3.2

Url to see changes : 

 - [Cms bundle](https://github.com/open-orchestra/open-orchestra-cms-bundle/compare/v0.3.1...v0.3.2)
 - [Display bundle](https://github.com/open-orchestra/open-orchestra-display-bundle/compare/v0.3.1...v0.3.2)
 - [Model bundle](https://github.com/open-orchestra/open-orchestra-model-bundle/compare/v0.3.1...v0.3.2)
 - [Model interface](https://github.com/open-orchestra/open-orchestra-model-interface/compare/v0.3.1...v0.3.2)
 - [Front bundle](https://github.com/open-orchestra/open-orchestra-front-bundle/compare/v0.3.1...v0.3.2)
 - [Base bundle](https://github.com/open-orchestra/open-orchestra-base-bundle/compare/v0.3.1...v0.3.2)
 - [Base api bundle](https://github.com/open-orchestra/open-orchestra-base-api-bundle/compare/v0.3.1...v0.3.2)
 - [Base api model bundle](https://github.com/open-orchestra/open-orchestra-base-api-mongo-model-bundle/compare/v0.3.1...v0.3.2)
 - [Media bundle](https://github.com/open-orchestra/open-orchestra-media-bundle/compare/v0.3.1...v0.3.2)
 - [User bundle](https://github.com/open-orchestra/open-orchestra-user-bundle/compare/v0.3.1...v0.3.2)
 - [Theme bundle](https://github.com/open-orchestra/open-orchestra-theme-bundle/compare/v0.3.1...v0.3.2)
 - [Worflow function bundle](https://github.com/open-orchestra/open-orchestra-worflow-function-bundle/compare/v0.3.1...v0.3.2)

## Possible BC breaker

 - The `Api\Serialize()` annotation should be given to the full class now
 - Reference to ``LeftPanel`` in class are replace by ``NavigationPanel``
 - You can use the annotation `OpenOrchestra\Mapping\Annotations\Search` for the mapping your entity for the dataTable search, [futher informations in the documentation](https://github.com/open-orchestra/open-orchestra-docs/blob/add_doc_server_search_list/en/developer_guide/entity_list_ajax_pagination.rst)
 - The annotation `OpenOrchestra\ModelInterface\Mapping\Annotations\Document` is moved to `open-orchestra-libs` (`OpenOrchestra\Mapping\Annotations\Document`)
 - `OpenOrchestra\ModelInterface\Exceptions\MethodNotFoundException` is moved to `Mapping\Exceptions\MethodNotFoundException`
 - `OpenOrchestra\ModelInterface\Exceptions\PropertyNotFoundException` is moved to `Mapping\Exceptions\PropertyNotFoundException`

## Bug fixes

## New features

## Other changes

 - You can now duplicate the node version you want
 - You can duplicate the current version of the node
 - I can specify that you have the workflow right on the content you have created

## Deprecated method

 - In the `NodeInterface`, the methode `isEditable` has been replaced by the `AuthorizeEditionManager`

## Suppressed method

## Configuration changes
