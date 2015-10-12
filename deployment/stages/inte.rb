server 'open_orchestra_backoffice_inte', roles: %w{web app db env}
set :repo_url, 'git@github.com:open-orchestra/open-orchestra.git'
set :deploy_to, '/var/www/backoffice-open-orchestra'
set :application, 'OpenOrchestra'
