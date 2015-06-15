set :deploy_config_path, "deployment/deploy.rb"
set :stage_config_path, "deployment/stages/"

# Load DSL and Setup Up Stages
require 'capistrano/setup'

# Includes default deployment tasks
require 'capistrano/deploy'
require 'capistrano/composer'
require 'capistrano/npm'

# Loads custom tasks from `lib/capistrano/tasks' if you have any defined.
Dir.glob('deployment/tasks/*.cap').each { |r| import r }
