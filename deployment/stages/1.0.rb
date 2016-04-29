server 'open_orchestra_bo_inte_1-0', roles: %w{web app db env}
set :repo_url, 'git@github.com:open-orchestra/open-orchestra.git'
set :deploy_to, '/var/www/backoffice-open-orchestra'
set :branch, '1.0'
set :application, 'OpenOrchestraStable'
set :update_dir, 'update-vendor-back-inte'
