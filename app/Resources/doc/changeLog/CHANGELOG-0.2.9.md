# CHANGELOG for 0.2.9

Url to see changes : 

 - [Cms bundle](https://github.com/open-orchestra/open-orchestra-cms-bundle/compare/v0.2.8...v0.2.9)
 - [Display bundle](https://github.com/open-orchestra/open-orchestra-display-bundle/compare/v0.2.8...v0.2.9)
 - [Model bundle](https://github.com/open-orchestra/open-orchestra-model-bundle/compare/v0.2.8...v0.2.9)
 - [Model interface](https://github.com/open-orchestra/open-orchestra-model-interface/compare/v0.2.8...v0.2.9)
 - [Front bundle](https://github.com/open-orchestra/open-orchestra-front-bundle/compare/v0.2.8...v0.2.9)
 - [Base bundle](https://github.com/open-orchestra/open-orchestra-base-bundle/compare/v0.2.8...v0.2.9)
 - [Base api bundle](https://github.com/open-orchestra/open-orchestra-base-api-bundle/compare/v0.2.8...v0.2.9)
 - [Media bundle](https://github.com/open-orchestra/open-orchestra-media-bundle/compare/v0.2.8...v0.2.9)
 - [User bundle](https://github.com/open-orchestra/open-orchestra-user-bundle/compare/v0.2.8...v0.2.9)
 - [Theme bundle](https://github.com/open-orchestra/open-orchestra-theme-bundle/compare/v0.2.8...v0.2.9)
 - [Worflow function bundle](https://github.com/open-orchestra/open-orchestra-worflow-function-bundle/compare/v0.2.8...v0.2.9)

## Possible BC breaker
 - In ContentRepositoryInterface and FieldAutoGenerableRepositoryInterface the method testUnicityInContext is rename by testUniquenessInContext

## Bug fixes

 - [Content versions van be naviguated through and created](https://trello.com/c/SxiViJWk/1009-2-bug-etq-ubo-je-peux-changer-de-version)
 - [Current site can be switched to a site created in the Back Office, not only in the fixtures](https://trello.com/c/XIfOxq4G/1040-hot-issue-le-site-switcher-du-bo-ne-fonctionne-pas-pour-les-sites-dont-l-id-est-de-type-string-en-gros-des-qu-on-cree-un-site-da)
 - [Content type can be deleted](https://trello.com/c/Vgw5oPlC/1028-1-etq-ubo-je-peux-supprimer-un-content-type)
 - [The deleted contents are not visible in the list](https://trello.com/c/ioIi4KI3/1029-0-5-bo-lorsque-je-supprime-un-content-il-n-apparait-plus-dans-la-liste)
 - [The media folder are now visible if they are not linked to a website](https://trello.com/c/GnnBizGK/1042-0-5-bug-etq-ubo-le-site-d-appartenance-d-un-folder-est-optionnel-y-compris-dans-la-modale-pas-de-site-tous-les-sites)
 - [The media folder can be editable](https://trello.com/c/CgOw48np/1041-1-bug-etq-ubo-je-peux-modifier-un-folder-de-mediatheque-et-sauvegarder)
 - In the content submission, the order in which the transformer are used has been changed (for the reverseTransformation)

## New features
 - [Wysiwyg blocks have a button to add image from Media Library to content](https://trello.com/c/vXStLA3i/638-3-etq-ubo-je-peux-inserer-un-media-de-la-mediatheque-dans-le-wysiwyg-tinymce-et-il-s-affiche-correctement-en-front)
 - [A content can be linked to the current website](https://trello.com/c/A1QrgMlg/957-5-etq-ubo-le-contenu-au-sens-type-de-contenu-que-je-cree-doit-etre-lie-a-un-et-un-seul-site)
 - [Some properties and content attributes can be the always the same on all content](https://trello.com/c/A1QrgMlg/957-5-etq-ubo-le-contenu-au-sens-type-de-contenu-que-je-cree-doit-etre-lie-a-un-et-un-seul-site)

## Other changes
 - Method findLastPublishedVersionByContentIdAndLanguage of ContentRepositoryInterface is moved in ReadContentRepositoryInterface
 - [Remove all deprecated calls related to Symfony 2.7](https://trello.com/c/Lk2pITZd/1008-suite-au-passage-de-symfony-en-2-7-plusieurs-methodes-utilisees-dans-orchestra-sont-tagguees-deprecated)

## Deprecated method

## Suppressed method

## Configuration changes

 - In the `ModelBundle` the class definition is under the `document` entry
