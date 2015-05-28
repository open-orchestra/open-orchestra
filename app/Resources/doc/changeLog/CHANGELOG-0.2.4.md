# CHANGELOG for 0.2.4

Url to see changes : 

 - [Cms bundle](https://github.com/open-orchestra/open-orchestra-cms-bundle/compare/v0.2.3...v0.2.4)
 - [Display bundle](https://github.com/open-orchestra/open-orchestra-display-bundle/compare/v0.2.3...v0.2.4)
 - [Model bundle](https://github.com/open-orchestra/open-orchestra-model-bundle/compare/v0.2.3...v0.2.4)
 - [Model interface](https://github.com/open-orchestra/open-orchestra-model-interface/compare/v0.2.3...v0.2.4)
 - [Front bundle](https://github.com/open-orchestra/open-orchestra-front-bundle/compare/v0.2.3...v0.2.4)
 - [Base bundle](https://github.com/open-orchestra/open-orchestra-base-bundle/compare/v0.2.3...v0.2.4)
 - [Media bundle](https://github.com/open-orchestra/open-orchestra-media-bundle/compare/v0.2.3...v0.2.4)
 - [User bundle](https://github.com/open-orchestra/open-orchestra-user-bundle/compare/v0.2.3...v0.2.4)
 - [Theme bundle](https://github.com/open-orchestra/open-orchestra-theme-bundle/compare/v0.2.3...v0.2.4)

## Possible BC breaker

 - The form type `open_orchestra_user.type.user` has been renamed to `open_orchestra_user_admin.type.user`
 - The entities `AccessToken` and `ApiClient` have been moved from the `UserBundle` to the `BaseApiBundle`.
 Please check with us directly to help you migrate

## Bug fixes
 - [In Back Office, restore broken translations](https://trello.com/c/1oMQI2mk/948-1-etq-ubo-je-vois-tous-les-libelles-traduits)
 - [In Back Office, restore mybg.png](https://trello.com/c/SbGB3K4k/949-0-5-bo-404-sur-mybg-png)
 - [In Back Office, the title of a newly created blocks is translated](https://trello.com/c/6ZE1YnjY/959-1-etq-ubo-je-vois-le-libelle-du-bloc-dans-la-toolbar-lorsque-je-cree-un-nouveau-bloc)
 - [In the vagrant box, the bug with the binding on localhost is fixed](https://trello.com/c/7TYFS8WG/771-2-le-provisionning-n-ajoute-pas-toujours-le-bind-127-0-0-1-localhost-openorchestra-dans-le-fichier-hosts)

## New features

 - There is a new entry in the left menu for the workflow function

## Other changes

 - Symfony has been upgraded to the 2.6.7 version

## Deprecated method

 - The constant `NodeInterface::TYPE_GENERAL` as been rename `TYPE_TRANSVERSE`
 - The Form Type `OrchestraColorChoiceType` will be suppressed, a configuration `available_color` will allow
 the integrator to setUp the colors
 - The class `AbstractBlockContentTypeSubscriber` will be renamed as `AbstractModulableTypeSubscriber`

## Suppressed method

 - In the ReadContentRepositoryInterface, the method findByContentTypeAndChoiceTypeAndKeywords is suppressed
 - In the FolderRepositoryInterface, the method setCurrentSiteManager is suppressed
 - In the NodeRepositoryInterface, these methods are suppressed :
    - findChildsByPath
    - findByParentIdAndRoutePatternAndNotNodeId
 - In the ReadNodeRepositoryInterface, these methods are suppressed :
    - getFooterTree
    - getMenuTree
    - getSubMenu
 - The DisplayedElementCollectionTransformer is suppressed.
 - The TranslateController is suppressed.

## Configuration changes

 - If you want to use the workflow function, you need to enable the following bundles : 
 
        new OpenOrchestra\WorkflowFunctionAdminBundle\OpenOrchestraWorkflowFunctionAdminBundle(),
        new OpenOrchestra\WorkflowFunctionBundle\OpenOrchestraWorkflowFunctionBundle(),
