module.exports = function(grunt) {
  var merge = require('merge');
  var appConfig = require('./grunt/app_config.js');
  var configLoader = require('./config_loader.js');
  var config = {
    pkg: grunt.file.readJSON('package.json'),
    env: process.env
  };

  require('load-grunt-tasks')(grunt);

  for (var i= 0; i < appConfig.tasksDir.length; i++) {
    grunt.loadTasks(appConfig.tasksDir[i]);
  }

  for (var i= 0; i < appConfig.targetsDir.length; i++) {
    config = merge.recursive(true, config, configLoader.loadDir(appConfig.targetsDir[i]));
  }

  grunt.initConfig(config);
};
