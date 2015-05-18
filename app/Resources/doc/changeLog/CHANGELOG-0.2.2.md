# CHANGELOG for 0.2.2

Url to see changes : 

 - [Cms bundle](https://github.com/open-orchestra/open-orchestra-cms-bundle/compare/v0.2.1...v0.2.2)
 - [Display bundle](https://github.com/open-orchestra/open-orchestra-display-bundle/compare/v0.2.1...v0.2.2)
 - [Model bundle](https://github.com/open-orchestra/open-orchestra-model-bundle/compare/v0.2.1...v0.2.2)
 - [Model interface](https://github.com/open-orchestra/open-orchestra-model-interface/compare/v0.2.1...v0.2.2)
 - [Front bundle](https://github.com/open-orchestra/open-orchestra-front-bundle/compare/v0.2.1...v0.2.2)
 - [Base bundle](https://github.com/open-orchestra/open-orchestra-base-bundle/compare/v0.2.1...v0.2.2)
 - [Media bundle](https://github.com/open-orchestra/open-orchestra-media-bundle/compare/v0.2.1...v0.2.2)
 - [User bundle](https://github.com/open-orchestra/open-orchestra-user-bundle/compare/v0.2.1...v0.2.2)
 - [Theme bundle](https://github.com/open-orchestra/open-orchestra-theme-bundle/compare/v0.2.1...v0.2.2)

## Possible BC breaker

 - The ApiBundle has been split in ApiBundle and BaseApiBundle

## Bug fixes

 - [Blocks js & css files are now correctly loaded](https://trello.com/c/lEJM8l6C/868-3-fo-chargement-autonome-des-css-de-blocs-le-chargement-semble-ne-fonctionner-que-pour-le-premier-bloc-de-la-page-et-il-est-igno)
 - [Missing BO assets are fixed](https://trello.com/c/K7nZSGMu/906-0-5-bo-erreur-500-sur-fontawesome)

## New features

 - In the BackOffice, adding new form type (choice, hidden, money and date) for the contentType.
 - [Content type fields list can now be extended in app config](https://trello.com/c/1Yn20BSP/846-2-etq-ubo-je-peux-ajouter-des-contents-attributs-specifique)
 - [The content type field definition has changed](https://trello.com/c/vWPgkOOz/897-1-refacto-definition-yaml-des-field-types-content-attributes)

## Other changes

 - In the BackOffice, we modified the way we interact with the blocks and area (js and css modification only). 
 - In the Backoffice, all the display strategies should be tagged with `open_orchestra_backoffice.display_block.strategy`

## Deprecated method

 - The `VersionnableInterface` and `Versionnable` trait have been renamed to `VersionableInterface` and
`Versionable` respectively

## Suppressed method

 - The following class have been removed from the ApiBundle : 
   - GroupContext
   - Annotation\Serializer
   - Annotation\Group
   - BaseController
   - TransformerManaer
   - AbstractTransformer
   - TransformerInterface
   - AbstractFacade
   - FacadeInterface
   - ApiException
   - HttpException\ApiException

## Configuration changes
