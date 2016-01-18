module.exports = function(grunt) {
  var appConfig = require('./grunt/app_config.js');
  var GruntConfigBuilder = require(appConfig.GruntConfigBuilder);

  GruntConfigBuilder.init(grunt, appConfig);
};
