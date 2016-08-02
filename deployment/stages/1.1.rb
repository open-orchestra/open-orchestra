server 'open_orchestra_bo_inte_1-1', roles: %w{web app db env}
set :repo_url, 'https://github.com/open-orchestra/open-orchestra.git'
set :update_dir, 'update-vendor-back-inte'
set :git_project_dir, 'open-orchestra'
set :deploy_to, '/home/wwwroot/openorchestra/backoffice-open-orchestra'
set :branch, '1.1'
set :application, 'OpenOrchestra'
