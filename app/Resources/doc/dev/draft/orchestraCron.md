# I/ Tâches cron du projet

## Sitemap
 La tâche sitemap génère automatiquement le sitemap.xml de tous les sites. Cette tâche est lancée tous les jours à 2h du matin.

## Robots
 La tâche robots génère automatiquement le robots.txt de tous les sites. Cette tâche est lancée tous les jours à 2h du matin.

 Pour plus d'informations sur la commande qui génère le sitemap.xml et le robots.txt voir la doc [sitemapAndRobotsFiles](https://github.com/itkg/open-orchestra/blob/master/app/Resources/doc/dev/draft/sitemapAndRobotsFiles.md)

 Pour modifier le moment où chaque tâche sera exécutée, modifiez les variables dans `provisioning/roles/orchestraCron/vars/main.yml`
