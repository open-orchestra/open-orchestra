# CHANGELOG for 0.0.6

Url to see changes : 

 - [Cms bundle](https://github.com/open-orchestra/phporchestra-cms-bundle/compare/v0.0.5...v0.0.6)
 - [Display bundle](https://github.com/open-orchestra/phporchestra-display-bundle/compare/v0.0.5...v0.0.6)
 - [Model bundle](https://github.com/open-orchestra/phporchestra-model-bundle/compare/v0.0.5...v0.0.6)
 - [Model interface](https://github.com/open-orchestra/phporchestra-model-interface/compare/v0.0.5...v0.0.6)
 - [Front bundle](https://github.com/open-orchestra/phporchestra-front-bundle/compare/v0.0.5...v0.0.6)
 - [Base bundle](https://github.com/open-orchestra/phporchestra-base-bundle/compare/v0.0.5...v0.0.6)
 - [Media bundle](https://github.com/open-orchestra/phporchestra-media-bundle/compare/v0.0.5...v0.0.6)
 - [User bundle](https://github.com/open-orchestra/phporchestra-user-bundle/compare/v0.0.5...v0.0.6)
 - [Theme bundle](https://github.com/open-orchestra/phporchestra-theme-bundle/compare/v0.0.5...v0.0.6)

## Possible BC breaker

 - [Modify the way route are created and analyzed](https://trello.com/c/V4qUttd6/547-5-etq-ufront-je-vois-l-url-comprenant-le-pattern-du-node-ainsi-que-la-concatenation-des-pattern-de-tous-ses-parents-dans-la-dern)
 - [The website has multiple alias](https://trello.com/c/320DdPIj/561-2-etq-ubo-tous-les-alias-d-un-site-n-ont-qu-une-langue-et-un-prefix-possiblement-vide)
 - [Each website alias can provide an url prefix](https://trello.com/c/320DdPIj/561-2-etq-ubo-tous-les-alias-d-un-site-n-ont-qu-une-langue-et-un-prefix-possiblement-vide)

## Bug fixes

 - [BO left menu is now operationnal after an automatic refresh](https://trello.com/c/X72fvY4d/530-2-etq-ubo-les-ne-disparaissent-pas-apres-un-rechargement-du-left-menu)
 - [The crop preview is now disable](https://trello.com/c/c0EuDFjM/521-0-5-etq-ubo-je-ne-vois-plus-la-preview-dans-la-mediatheque)

## New features

 - [Validation on the routePattern creation](https://trello.com/c/T2Y3fQl5/535-2-etq-ufront-une-url-pointe-sur-un-seul-node-dans-une-seule-langue-quelque-soit-la-version-pour-un-host-donne)
 - [Display the site name in the log table](https://trello.com/c/TuJrzEjV/558-1-etq-ubo-dans-le-listing-de-log-je-vois-le-site-courant-utilise-au-moment-de-la-creation-du-log)
 - [Start to use Wreqr to dispatch event in Js](https://trello.com/c/SI1nGWb6/438-3-event-en-javascript)
 
## Other changes

 - Apc is not anymore required by baseBundle

## Deprecated method

 - NodeRepositoryInterface : [findOneByParendIdAndAliasAndSiteId](https://github.com/open-orchestra/phporchestra-model-interface/blob/master/ModelInterface/Repository/NodeRepositoryInterface.php#L19)
