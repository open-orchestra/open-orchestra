# CHANGELOG for 0.1.2

Url to see changes : 

 - [Cms bundle](https://github.com/open-orchestra/open-orchestra-cms-bundle/compare/v0.1.1...v0.1.2)
 - [Display bundle](https://github.com/open-orchestra/open-orchestra-display-bundle/compare/v0.1.1...v0.1.2)
 - [Model bundle](https://github.com/open-orchestra/open-orchestra-model-bundle/compare/v0.1.1...v0.1.2)
 - [Model interface](https://github.com/open-orchestra/open-orchestra-model-interface/compare/v0.1.1...v0.1.2)
 - [Front bundle](https://github.com/open-orchestra/open-orchestra-front-bundle/compare/v0.1.1...v0.1.2)
 - [Base bundle](https://github.com/open-orchestra/open-orchestra-base-bundle/compare/v0.1.1...v0.1.2)
 - [Media bundle](https://github.com/open-orchestra/open-orchestra-media-bundle/compare/v0.1.1...v0.1.2)
 - [User bundle](https://github.com/open-orchestra/open-orchestra-user-bundle/compare/v0.1.1...v0.1.2)
 - [Theme bundle](https://github.com/open-orchestra/open-orchestra-theme-bundle/compare/v0.1.1...v0.1.2)

## Possible BC breaker

 - [All interfaces have been split into Interfaces and ReadInterfaces](https://trello.com/c/LTW12l5I/680-2-split-des-interfaces-de-document)

## Bug fixes

- [Status creation](https://trello.com/c/WUhokb8A/702-0-5-creation-d-un-status)

## New features

- [Concerned caches banned on Node/Content status changes](https://trello.com/c/y514TduH/685-3-etq-ubo-la-publication-d-un-node-d-un-contenu-entraine-le-decache-des-tags-correspondant)
- [Multi devices](https://trello.com/c/l6dczoPt/86-1-etq-fo-je-peux-voir-un-template-different-entre-le-web-et-le-mobile-si-le-template-mobile-existe)
- [Blocks cache are tagged according their content](https://trello.com/c/xxdxxEbc/657-2-etq-dev-je-repasse-sur-tous-les-blocks-pour-mettre-a-jour-les-tags-et-les-status-de-cache)
- [Check twig syntax error in contents templates](https://trello.com/c/CTTIJVod/714-1-etq-ubo-je-vois-une-erreur-quand-mon-template-twig-n-est-pas-valide)
- [Add new specific tags to blocks](https://trello.com/c/A520Wqxr/712-0-5-bo-modif-d-un-bloc-ban-du-cache-varnish-du-bloc-a-mettre-en-place)
- [Oauth2 authentication on the api](https://trello.com/c/G5BWkEY4/661-8-5-delier-la-connexion-a-l-api-de-la-connexion-au-bo)
- [Translate media's title and alt](https://trello.com/c/wCVDdf1N/681-1-etq-utilisateur-bo-je-peux-traduire-le-titre-et-le-contenu-alt-des-medias)

## Other changes

- [Rename Editorial/template.html.twig into form.html.twig](https://trello.com/c/s4OfBV2g/715-1-renommer-le-fichier-editorial-template-html-twig)
- [Move blocks constants into blocks strategies](https://trello.com/c/rvRcW0fd/699-2-refacto-la-displayblockinterface-ne-devrait-pas-porter-l-exhaustivite-des-blocks)

## Deprecated method


## Suppressed method

## Configuration modification

 - The interface split modify the `resolve_target_documents`, you need to put the new read interfaces instead
 - [Change the firewall configuration for the api connexion](https://github.com/open-orchestra/open-orchestra/blob/master/app/Resources/doc/dev/draft/apiConnexion.md)
