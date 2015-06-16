server 'open_orchestra_com_back_prod', roles: %w{web app db}
set :repo_url, 'git@github.com:open-orchestra/open-orchestra.git'
set :deploy_to, '/var/www/admin-open-orchestra-com'
