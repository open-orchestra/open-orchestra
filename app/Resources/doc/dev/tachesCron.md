# I/ Tâche cron

 Nous provisionnons des tâches cron pour exécuter régulièrement des commandes.

# II/ Creation d'une tâche cron

 Pour ajouter des tâches cron, créez un ficher du nom de votre tâche dans `provisioning/roles/orchestraCron/tasks`.
 Dans votre fichier utilisez la commande ansible cron :
 
    cron: name="description de la tâche" min="minutes" hour="heure" day="day" month="month" job="tâche"

 Pour plus de précisions sur la commande cron allez voir la documentation [ansible cron module](http://docs.ansible.com/cron_module.html)

 Ajouter votre tâche dans le fichier `provisioning/roles/orchestraCron/tasks/main.yml`

    - include: tache.yml

 Les variables utilisées sont dans `provisioning/roles/orchestraCron/vars/main.yml`
