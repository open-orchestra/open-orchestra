server 'open_orchestra_backoffice_stable', roles: %w{web app db env}
set :repo_url, 'git@github.com:open-orchestra/open-orchestra.git'
set :deploy_to, '/var/www/stable-backoffice-open-orchestra'
set :branch, '1.0'
set :application, 'OpenOrchestraStable'
