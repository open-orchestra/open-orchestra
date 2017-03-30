server 'open_orchestra_bo_inte_demo', roles: %w{web app db env}
set :repo_url, 'https://github.com/open-orchestra/open-orchestra.git'
set :deploy_to, '/home/wwwroot/openorchestra/back'
set :branch, 'master'
set :application, 'OpenOrchestra'
