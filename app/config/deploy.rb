set :application, "PhpOrchestra-front-bundle"
set :domain,      "php_orchestra_backoffice_inte"
set :deploy_to,   "/var/www/backoffice-phporchestra"
set :app_path,    "app"
set :user,        "root"

set :repository,  "git@github.com:itkg/phporchestra.git"
set :scm,         :git
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`

set :model_manager, "doctrine"
# Or: `propel`

# composer settings
set :composer_bin,      "/usr/local/bin/composer"
set :use_composer,      true
set :update_vendors,    true

set :shared_files,      ["app/config/parameters.yml"]
set :shared_children,     [app_path + "/logs", web_path + "/uploads", "vendor", "node_modules", "bower_components"]

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server

set  :keep_releases,  3
set  :use_sudo,       false
set :writable_dirs,         ["app/cache", "app/logs"]
set :webserver_user,        "www-data"
set :use_set_permissions,   true

# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL
