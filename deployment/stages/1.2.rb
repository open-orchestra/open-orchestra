server 'open_orchestra_bo_inte_1-2', roles: %w{web app db env}
set :repo_url, 'https://github.com/open-orchestra/open-orchestra.git'
set :update_dir, 'update-vendor-back-inte'
set :git_project_dir, 'open-orchestra'
set :deploy_to, '/home/wwwroot/openorchestra/back'
set :branch, 'master'
set :application, 'OpenOrchestra'
