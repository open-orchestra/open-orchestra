# CHANGELOG for 0.1.1

Url to see changes : 

 - [Cms bundle](https://github.com/open-orchestra/open-orchestra-cms-bundle/compare/v0.1.0...v0.1.1)
 - [Display bundle](https://github.com/open-orchestra/open-orchestra-display-bundle/compare/v0.1.0...v0.1.1)
 - [Model bundle](https://github.com/open-orchestra/open-orchestra-model-bundle/compare/v0.1.0...v0.1.1)
 - [Model interface](https://github.com/open-orchestra/open-orchestra-model-interface/compare/v0.1.0...v0.1.1)
 - [Front bundle](https://github.com/open-orchestra/open-orchestra-front-bundle/compare/v0.1.0...v0.1.1)
 - [Base bundle](https://github.com/open-orchestra/open-orchestra-base-bundle/compare/v0.1.0...v0.1.1)
 - [Media bundle](https://github.com/open-orchestra/open-orchestra-media-bundle/compare/v0.1.0...v0.1.1)
 - [User bundle](https://github.com/open-orchestra/open-orchestra-user-bundle/compare/v0.1.0...v0.1.1)
 - [Theme bundle](https://github.com/open-orchestra/open-orchestra-theme-bundle/compare/v0.1.0...v0.1.1)

## Possible BC breaker

 - [Suppress dynamic routing maganement](https://trello.com/c/0da29mg0/628-1-etq-u-je-vois-une-erreur-404-lorsque-j-essaie-d-acceder-a-une-page-ou-un-site-qui-n-existe-pas)
 - [Strategies header, mediaList and Gallery have been moved](https://trello.com/c/dpP1TBpJ/695-0-5-etq-dev-je-vois-les-strategies-header-medialist-et-gallery-dans-le-mediabundle)

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
 - [User are related to a group for the right](https://trello.com/c/upLhlVle/674-5-etq-utilisateur-bo-je-peux-gerer-les-groupes-d-utilisateurs-creation-modification-suppression)
 - [Content preview is now handled by a fake object](https://trello.com/c/ZCFLwsmb/644-2-et-ubo-lorsque-je-previsualise-un-block-qui-attend-un-parametre-dans-l-url-content-celui-ci-affiche-un-contenu-bidon)
 - [You can create users group](https://trello.com/c/hmQYFjMt/675-5-etq-utilisateur-bo-je-peux-gerer-les-utilisateurs-creation-modification-suppression)
 - [User are now related to groups](https://trello.com/c/upLhlVle/674-5-etq-utilisateur-bo-je-peux-gerer-les-groupes-d-utilisateurs-creation-modification-suppression)

## Other changes

 - [Content can have a personal template](https://trello.com/c/1YrjTd58/615-1-etq-ubo-je-peux-avoir-un-template-personnalise-wysiwyg-sur-l-affichage-d-un-block-content)
 - [BO > Mediatheque is redesigned and have a better interface](https://trello.com/c/duBO39lq/572-2-etq-ubo-je-ne-vois-qu-un-seul-btn-save-dans-la-mediatheque-crop-ou-override)
 - [Add test behat and provision it](https://trello.com/c/KC19uTkl/636-8-je-realise-un-test-behat-avec-un-navigateur-et-celui-s-execute-sur-travis)
 - [Provision a cron task](https://trello.com/c/mAhTr951/639-0-5-etq-dev-je-provisionne-la-vm-avec-une-tache-cron-quotidienne-pour-la-generation-des-sitemap-xml-et-une-autre-pour-les-robots) to generate sitemap.xml and robots.txt
 - [Add an example of varnish usage](https://trello.com/c/gx3EwdkA/649-3-etq-ufront-lorsque-je-visualise-le-front-je-passe-par-varnish)
 - [Add an asterisk if field are required](https://trello.com/c/IK5LraBb/689-1-etq-ubo-je-vois-les-champs-obligatoires-des-formulaires-accompagnes-d-une-asterisque)
 - [Add help for form fields](https://trello.com/c/pETcYNlk/690-2-etq-ubo-je-vois-une-aide-pour-les-champs-des-formulaires-au-format-smartadmin-un-point-d-interrogation-dans-le-input)
 - [DataGrid have bootstrap button](https://trello.com/c/oa1V3CHH/677-1-etq-utilisateur-bo-les-listes-datagrid-utilisent-des-boutons-bootstrap-pour-les-actions-add-edit-remove)
 - [Block can specify cache management properties](https://trello.com/c/cEnsoyLl/651-1-etq-ubo-lorsque-j-edite-un-block-je-peux-surcharger-les-valeurs-de-cache-max-age)
 - [Move the Group document into a new Group Bundle](https://trello.com/c/2A3vWfsM/735-2-etq-dev-je-vois-le-document-group-du-bobundle-dans-le-groupbundle)

## Deprecated method


## Suppressed method
