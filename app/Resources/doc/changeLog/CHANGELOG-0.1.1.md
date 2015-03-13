# CHANGELOG for 0.1.1

Url to see changes : 

 - [Cms bundle](https://github.com/itkg/open-orchestra-cms-bundle/compare/v0.1.0...v0.1.1)
 - [Display bundle](https://github.com/itkg/open-orchestra-display-bundle/compare/v0.1.0...v0.1.1)
 - [Model bundle](https://github.com/itkg/open-orchestra-model-bundle/compare/v0.1.0...v0.1.1)
 - [Model interface](https://github.com/itkg/open-orchestra-model-interface/compare/v0.1.0...v0.1.1)
 - [Front bundle](https://github.com/itkg/open-orchestra-front-bundle/compare/v0.1.0...v0.1.1)
 - [Base bundle](https://github.com/itkg/open-orchestra-base-bundle/compare/v0.1.0...v0.1.1)
 - [Media bundle](https://github.com/itkg/open-orchestra-media-bundle/compare/v0.1.0...v0.1.1)
 - [Translation bundle](https://github.com/itkg/open-orchestra-translation-bundle/compare/v0.1.0...v0.1.1)
 - [User bundle](https://github.com/itkg/open-orchestra-user-bundle/compare/v0.1.0...v0.1.1)
 - [Theme bundle](https://github.com/itkg/open-orchestra-theme-bundle/compare/v0.1.0...v0.1.1)
 - [Indexation bundle](https://github.com/itkg/open-orchestra-indexation-bundle/compare/v0.1.0...v0.1.1)

## Possible BC breaker

 - [Suppress dynamic routing maganement](https://trello.com/c/0da29mg0/628-1-etq-u-je-vois-une-erreur-404-lorsque-j-essaie-d-acceder-a-une-page-ou-un-site-qui-n-existe-pas)

## Bug fixes
 - [Keywords field opened in a block form is now correctly closed when closing the form](https://trello.com/c/gnqUFELt/634-1-etq-ubo-quand-j-edite-un-block-avec-des-keywords-et-que-je-ferme-la-popup-sans-fermer-le-listing-des-keyword-il-ne-se-retrouve)
 - [Media > crop on an image larger than screen now works correctly](https://trello.com/c/qZ5OoKVd/610-2-bo-mediatheque-resize-d-une-image-trop-grande)
 - [Preview link](https://trello.com/c/shYgNwkg/613-1-etq-ubo-je-peux-utiliser-la-preview)
 - [render_esi on blocks fixed when used with varnish](https://trello.com/c/OBRAyIeO/648-0-5-etq-ufront-je-recupere-le-siteid-par-l-url-quand-j-affiche-un-block)
 - [Blocks Menu and SubMenu deal with dynamic node pattern](https://trello.com/c/LJxf5nje/623-1-etq-fo-le-bloc-submenu-ne-plante-pas-avec-le-message-error-call-to-a-member-function-getnodeid-on-a-non-object)
 - [BO > F5 on media edit now works](https://trello.com/c/VAitrnjq/641-2-etq-bo-lorsque-je-fais-f5-sur-la-page-d-edition-d-un-media-celle-ci-se-rafraichit-correctement)
 - [Separation of DisplayBundle and MediaBundle](https://trello.com/c/dpP1TBpJ/695-0-5-etq-dev-je-vois-les-strategies-header-medialist-et-gallery-dans-le-mediabundle)

## New features

 - [Route pattern starting with "/" are absolute](https://trello.com/c/jaU88Adl/632-1-etq-ubo-si-je-mets-un-en-debut-de-route-pattern-je-ne-fait-pas-de-completion-avec-le-pattern-du-parent)
 - ReverseProxy cache : [Open Orchestra now uses httpfoscachebundle](https://trello.com/c/cfswEacm/635-2-poc-sur-foshttpcachebundle)
 - [Blocks can have specific tags used as cache keys](https://trello.com/c/9fUNhgGn/660-3-etq-dev-chaque-bloc-peut-ajouter-des-tags-specifiques)
 - [Node cache has specific tags](https://trello.com/c/brTwfwaK/654-0-5-etq-ufront-le-node-en-cache-a-comme-tags-systematiques-le-nodeid-le-siteid-et-la-langue)

## Other changes

 - [Content can have a personal template](https://trello.com/c/1YrjTd58/615-1-etq-ubo-je-peux-avoir-un-template-personnalise-wysiwyg-sur-l-affichage-d-un-block-content)
 - [BO > Mediatheque is redesigned and have a better interface](https://trello.com/c/duBO39lq/572-2-etq-ubo-je-ne-vois-qu-un-seul-btn-save-dans-la-mediatheque-crop-ou-override)
 - [Add test behat and provision it](https://trello.com/c/KC19uTkl/636-8-je-realise-un-test-behat-avec-un-navigateur-et-celui-s-execute-sur-travis)
 - [Provision a cron task](https://trello.com/c/mAhTr951/639-0-5-etq-dev-je-provisionne-la-vm-avec-une-tache-cron-quotidienne-pour-la-generation-des-sitemap-xml-et-une-autre-pour-les-robots) to generate sitemap.xml and robots.txt
 - [Add an example of varnish usage](https://trello.com/c/gx3EwdkA/649-3-etq-ufront-lorsque-je-visualise-le-front-je-passe-par-varnish)

## Deprecated method


## Suppressed method
