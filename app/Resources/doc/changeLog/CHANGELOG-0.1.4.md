# CHANGELOG for 0.1.4

Url to see changes : 

 - [Cms bundle](https://github.com/open-orchestra/open-orchestra-cms-bundle/compare/v0.1.3...v0.1.4)
 - [Display bundle](https://github.com/open-orchestra/open-orchestra-display-bundle/compare/v0.1.3...v0.1.4)
 - [Model bundle](https://github.com/open-orchestra/open-orchestra-model-bundle/compare/v0.1.3...v0.1.4)
 - [Model interface](https://github.com/open-orchestra/open-orchestra-model-interface/compare/v0.1.3...v0.1.4)
 - [Front bundle](https://github.com/open-orchestra/open-orchestra-front-bundle/compare/v0.1.3...v0.1.4)
 - [Base bundle](https://github.com/open-orchestra/open-orchestra-base-bundle/compare/v0.1.3...v0.1.4)
 - [Media bundle](https://github.com/open-orchestra/open-orchestra-media-bundle/compare/v0.1.3...v0.1.4)
 - [User bundle](https://github.com/open-orchestra/open-orchestra-user-bundle/compare/v0.1.3...v0.1.4)
 - [Theme bundle](https://github.com/open-orchestra/open-orchestra-theme-bundle/compare/v0.1.3...v0.1.4)

## Possible BC breaker
- The ContactController in the DisplayBundle has been removed. Therefore there are no more controller in
  this bundle so any reference to it in the routing file should be removed.
 - We have moved the FieldAutoGenerableRepositoryInterface from the model-bundle to the model-interface

## Bug fixes
- [Blocks contentList and configurable content displays the lastest content published in the language considered](https://trello.com/c/soVPYDii/763-2-etq-ufront-lorsque-je-liste-les-contents-je-ne-prends-que-les-derniers-content-publie-dans-la-langue-considere)
- [Fix pdf and video media preview](https://trello.com/c/Nl6I3Eej/818-2-dans-la-mediatheque-il-n-y-a-pas-la-preview-des-pdf-et-les-noms-de-fichiers-longs-depassent-du-cadre)

## New features
- [BO Content Edit forms can now be personalized by Content Type](https://trello.com/c/m5DCUGSd/769-2-psa-caen-possibilite-de-personnalisation-du-template-d-affichage-d-un-formulaire-de-contenu)

## Other changes
- [Delete media with gaufrette](https://trello.com/c/2gS8iiT4/732-check-lors-de-la-suppression-d-un-media-est-ce-que-gaufrette-fait-une-action-de-delete-sur-le-repertoire-distant)
- [I don't see header in the query string](https://trello.com/c/GVlPZ9Md/719-1-etq-ufront-je-ne-vois-pas-de-header-dans-la-querystring)
- [UserBundle is now required in FrontDemo](https://trello.com/c/mez7LKvJ/791-0-5-les-fixtures-du-model-bundle-creent-une-page-avec-un-bloc-login-mais-il-n-y-a-pas-de-strategie-login-dans-le-projet-front-de)
- [Suppress cid in widget](https://trello.com/c/yeVDAiug/646-3-suppression-des-cid-sur-le-modele-du-tableview)

## Deprecated method


## Suppressed method

## Configuration changes
- The controller reference under the `open_orchestra_display` key in the routing should not be used
  as there is no more controller in this bundle.
