set :application, "OpenOrchestra"

# multiple stages
set :stages,                ["inte", "prod"]
set :default_stage,         "inte"
set :stage_dir,             "app/config/deploy"
require 'capistrano/ext/multistage'

set :domain,      "open_orchestra_backoffice_inte"
set :app_path,    "app"

set :repository,  "git@github.com:open-orchestra/open-orchestra.git"
set :scm,         :git
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`

set :model_manager, "doctrine"
# Or: `propel`

# composer settings
set :composer_bin,      "/usr/local/bin/composer"
set :use_composer,      true
set :update_vendors,    false
set :composer_options,  "--dev"

set :shared_files,      ["app/config/parameters.yml"]
set :shared_children,     [app_path + "/logs", "vendor", "node_modules", "bower_components"]

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server

set  :keep_releases,  3
set  :use_sudo,       false
set :writable_dirs,         ["app/cache", "app/logs"]
set :webserver_user,        "www-data"
set :use_set_permissions,   true

# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL

# deployment tasks
after "symfony:composer:install", "npm:install"
after "npm:install", "grunt:generate"
after "deploy", "deploy:cleanup"
after "symfony:composer:install", "symfony:assets:update_version"

before "orchestra:behat", "orchestra:selenium:start"
after "orchestra:behat", "orchestra:selenium:stop"

namespace :npm do
    desc "Install npm packages"
    task :install do
        capifony_pretty_print "--> Install npm packages"
        run "cd #{latest_release} && npm install"
        capifony_puts_ok
    end
end

namespace :grunt do
    desc "Generate all assets with grunt"
    task :generate do
        capifony_pretty_print "--> Generating all assets with grunt"
        run "cd #{latest_release} && ./node_modules/grunt-cli/bin/grunt"
        capifony_puts_ok
    end
end

namespace :orchestra do
    desc "Check the consistency of the nodes"
    task :check do
        capifony_pretty_print "--> Check all nodes"
        result = capture("cd #{latest_release} && php app/console -e=prod orchestra:check --nodes")
        puts result
    end

    desc "Run behat test"
    task :behat do
        capifony_pretty_print "--> load fixtures test"
        run "cd #{latest_release} && php app/console doctrine:mongodb:fixtures:load -e=test"
        capifony_puts_ok
        capifony_pretty_print "--> Run behat tests"
        result = capture("cd #{latest_release} && ./bin/behat")
        puts result
    end

    namespace :selenium do
        desc "Run selenium"
        task :start do
            capifony_pretty_print "--> Run Xvfb"
            run "sudo /etc/init.d/Xvfb start"
            capifony_puts_ok
            capifony_pretty_print "--> Wait 2 second"
            run "sleep 2"
            capifony_puts_ok
            capifony_pretty_print "--> Run selenium server"
            run "sudo /etc/init.d/selenium start"
            capifony_puts_ok
            capifony_pretty_print "--> Wait 5 second"
            run "sleep 5"
            capifony_puts_ok
        end

        desc "Stop Xvfb"
        task :stop do
            capifony_pretty_print "--> Close selenium server"
            run "sudo /etc/init.d/selenium stop"
            capifony_puts_ok
            capifony_pretty_print "--> Close xvfb"
            run "sudo /etc/init.d/Xvfb start"
            capifony_puts_ok
        end
    end
end
