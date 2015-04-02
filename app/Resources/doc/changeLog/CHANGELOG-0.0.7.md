# CHANGELOG for 0.0.7

Url to see changes : 

 - [Cms bundle](https://github.com/open-orchestra/phporchestra-cms-bundle/compare/v0.0.6...v0.0.7)
 - [Display bundle](https://github.com/open-orchestra/phporchestra-display-bundle/compare/v0.0.6...v0.0.7)
 - [Model bundle](https://github.com/open-orchestra/phporchestra-model-bundle/compare/v0.0.6...v0.0.7)
 - [Model interface](https://github.com/open-orchestra/phporchestra-model-interface/compare/v0.0.6...v0.0.7)
 - [Front bundle](https://github.com/open-orchestra/phporchestra-front-bundle/compare/v0.0.6...v0.0.7)
 - [Base bundle](https://github.com/open-orchestra/phporchestra-base-bundle/compare/v0.0.6...v0.0.7)
 - [Media bundle](https://github.com/open-orchestra/phporchestra-media-bundle/compare/v0.0.6...v0.0.7)
 - [User bundle](https://github.com/open-orchestra/phporchestra-user-bundle/compare/v0.0.6...v0.0.7)
 - [Theme bundle](https://github.com/open-orchestra/phporchestra-theme-bundle/compare/v0.0.6...v0.0.7)

## Possible BC breaker

## Bug fixes

 - [Sitemap Generation is operationnal again](https://trello.com/c/rljOEviq/589-etq-ufront-je-peux-avoir-la-generation-du-sitemap)
 - [Provisionning fixed](https://trello.com/c/mjNqr6uy/566-2-etq-dev-je-peux-provisionner-ma-machine)
 - [Keywords are now selectables in form that require it](https://trello.com/c/gUPgOx5B/575-1-bo-bloc-contentlist-choix-du-mot-cle-masque)
 - [Change the block form generation](https://trello.com/c/XJi3yUQ3/533-5-etq-ubo-je-peux-utiliser-des-bouton-de-type-radio-dans-les-formulaires-de-blocks)

## New features

 - [Redirection are stored in the database to feed the front router](https://trello.com/c/KiZmddVh/536-etq-ufront-si-j-accede-a-une-url-d-un-node-qui-n-est-plus-publie-je-recois-une-redirection-301-sur-le-node-publie-6)
 - [Ability to define a template to display a content](https://trello.com/c/UtJuPz5R/567-3-etq-ubo-j-ai-acces-a-un-champ-de-type-wysiwyg-dans-le-block-contentlist-permettant-de-definir-le-template-a-utiliser-pour-affi)
 - [Scheme of sites and pages is now configurable (used only on BO preview for now)](https://trello.com/c/Y0cCzHg7/555-1-etq-ubo-je-peux-acceder-a-la-preview-en-https-si-specifier-comme-tel-dans-le-site-ou-le-node)

## Other changes

 - Back Office > [Open sans font familly is now loaded via Bower](https://trello.com/c/4ioDDQLt/484-0-5-etq-que-dev-j-ai-fonts-googleapis-dans-bower)
 - Back Office > [In node edition, only allowed blocks for the current site are availables](https://trello.com/c/feVdcqK9/482-1-etq-ubo-je-prends-en-compte-la-liste-des-blocks-dispo-pour-le-site-courant-quand-je-construit-la-liste-des-blocks-sur-la-colon)
 - Back Office > [Mediatheque : thumbnail formats are exploited a new way](https://trello.com/c/GUJnf6Mo/523-2-etq-ubo-lorsque-je-crop-l-image-doit-tenir-dans-le-rectangle-defini-il-peut-y-avoir-du-vide-autour)
 - Back Office > Mediatheque : contribution interface is a bit more friendly user
 - Back Office > Logs : [Add current site name in logs](https://trello.com/c/TuJrzEjV/558-1-etq-ubo-dans-le-listing-de-log-je-vois-le-site-courant-utilise-au-moment-de-la-creation-du-log)
 - Back Office > Mediathèque : [Remove media preview](https://trello.com/c/c0EuDFjM/521-0-5-etq-ubo-je-ne-vois-plus-la-preview-dans-la-mediatheque)
 - [Update to symfony 2.6.4](https://github.com/open-orchestra/phporchestra-base-bundle/pull/20)

## Deprecated method

 - NodeRepositoryInterface::findOneByParendIdAndRoutePatternAndSiteId()
 - PhpOrchestraUrlGenerator::dynamicGenerate()
 - DynamicRoutingManager::getRouteParameterFromRequestPathInfo()
 - DynamicRoutingSubscriber::onKernelException()

## Suppressed method

 - NodeInterface::getAlias()
 - NodeInterface::setAlias()
 - NodeRepositoryInterface::findOneByParendIdAndAliasAndSiteId()
