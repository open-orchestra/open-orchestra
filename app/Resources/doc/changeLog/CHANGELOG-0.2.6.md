# CHANGELOG for 0.2.6

Url to see changes : 

 - [Cms bundle](https://github.com/open-orchestra/open-orchestra-cms-bundle/compare/v0.2.5...v0.2.6)
 - [Display bundle](https://github.com/open-orchestra/open-orchestra-display-bundle/compare/v0.2.5...v0.2.6)
 - [Model bundle](https://github.com/open-orchestra/open-orchestra-model-bundle/compare/v0.2.5...v0.2.6)
 - [Model interface](https://github.com/open-orchestra/open-orchestra-model-interface/compare/v0.2.5...v0.2.6)
 - [Front bundle](https://github.com/open-orchestra/open-orchestra-front-bundle/compare/v0.2.5...v0.2.6)
 - [Base bundle](https://github.com/open-orchestra/open-orchestra-base-bundle/compare/v0.2.5...v0.2.6)
 - [Base api bundle](https://github.com/open-orchestra/open-orchestra-base-api-bundle/compare/v0.2.5...v0.2.6)
 - [Media bundle](https://github.com/open-orchestra/open-orchestra-media-bundle/compare/v0.2.5...v0.2.6)
 - [User bundle](https://github.com/open-orchestra/open-orchestra-user-bundle/compare/v0.2.5...v0.2.6)
 - [Theme bundle](https://github.com/open-orchestra/open-orchestra-theme-bundle/compare/v0.2.5...v0.2.6)
 - [Worflow function bundle](https://github.com/open-orchestra/open-orchestra-worflow-function-bundle/compare/v0.2.5...v0.2.6)

## Possible BC breaker

 - Symfony version has been upgraded to 2.7.0

## Bug fixes

 - [Fix broken sitemaps generation](https://trello.com/c/7X4nEDb2/980-3-fo-la-commande-de-generation-de-sitemap-plante)

## New features
 - added DataTable Colvis to Bower and Grunt to enable column choice visibility in dataTable
 - added possibility to manage right on content and node change status
 - [new custom types options can be added in the app/config.yml](https://trello.com/c/OVJGTlNM/922-1-bo-creation-d-un-content-attribute-possibilite-de-creer-de-nouvelles-options)

## Other changes
 - [Refacto on the grunt tasks](https://trello.com/c/UmvUjjsD/947-2-etq-dev-je-ne-suis-pas-oblige-de-chercher-les-mises-a-jour-du-gruntfile-quand-mon-bo-plante)

## Deprecated method

 - The method `eventElligible` from the `AbstractSubscriber` in the `BaseApi` is replaced by `isEventEligible`

## Suppressed method

## Configuration changes
The grunt tasks managment has been changed to be more user friendly in case of Open Orchestra updates
and/or application specific modifications. Tasks and configuration are now splitted into multiples
files placed in OpenOrchestraBundle for the generic ones and in CmsBundle for the specific ones. To
be compatible with that change, projects must update their actual grunt files. The gruntfile must be
updated. The folder grunt_tasks must be created and the tasks it's containing must be added. See
(https://github.com/open-orchestra/open-orchestra/pull/492) for more information.

As new npm modules are required, a npm install must also be done.
