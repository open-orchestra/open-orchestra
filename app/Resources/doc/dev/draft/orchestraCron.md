# I/ Tâche cron

 Nous provisionnons des tâches cron pour éxecuter régulièrement des commandes.

# II/ Creation d'une tâche cron

 Pour ajouter des tâches cron, créez un ficher du nom de votre tâche dans `provisioning/roles/orchestraCron/tasks`.
 Dans votre fichier utilisez la commande ansible cron :
 
    cron: name="description de la tache" min="minutes" hour="heure" day="day" month="month" job="tâche"

 Pour plus de précision sur la commande cron allez voir la documentation [ansible cron module](http://docs.ansible.com/cron_module.html)

 Ajouter votre tâche dans le fichier `provisioning/roles/orchestraCron/tasks/main.yml`

    - include: tache.yml

 Les variables utilisées sont dans `provisioning/roles/orchestraCron/vars/main.yml`

# III/ Tâches cron du projet

## Sitemap
 La tâche sitemap génère automatiquement le sitemap.xml de tous les sites. Cette tâche est lancé tous les jour à 2h du matin.

## Robots
 La tâche robots génère automatiquement le robots.txt de tous les sites. Cette tâche est lancé tous les jour à 2h du matin.

 Pour plus d'information sur la commande qui génère le sitemap.xml voir la doc sitemapAndRobotsFiles

 Pour modifier le moment où chaque tâche sera éxecuté, modifiez les variables dans `provisioning/roles/orchestraCron/vars/main.yml`
