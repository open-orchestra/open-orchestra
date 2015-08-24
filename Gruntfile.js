module.exports = function(grunt) {
    require('load-grunt-tasks')(grunt);
    grunt.loadTasks('./grunt_tasks');
    grunt.loadTasks('./vendor/open-orchestra/open-orchestra-cms-bundle/OpenOrchestra/GruntTasks');
    grunt.loadTasks('./vendor/open-orchestra/open-orchestra-media-admin-bundle/OpenOrchestra/GruntTasks');

    var merge = require('merge');
    var config = {
        pkg: grunt.file.readJSON('package.json'),
        env: process.env
    };
    config = merge.recursive(true, config, loadConfig('./grunt_tasks/options/'));
    config = merge.recursive(true, config, loadConfig('./vendor/open-orchestra/open-orchestra-cms-bundle/OpenOrchestra/GruntTasks/Options/'));
    config = merge.recursive(true, config, loadConfig('./vendor/open-orchestra/open-orchestra-media-admin-bundle/OpenOrchestra/GruntTasks/Options/'));

    grunt.initConfig(config);
};

function loadConfig(path) {
    var glob = require('glob');
    var merge = require('merge');
    var object = {};

    glob.sync('*', {cwd: path}).forEach(function(filename) {
        var config = require(path + filename);
        var stringOfKeys = filename.replace(/\.js$/,'');
        var keys =  stringOfKeys.split('.');
        var index = 'object';

        keys.forEach(function(key) {
            index += "['" + key + "']";
            eval("if (!" + index + ") " + index + " = {};");
        });

        eval(index + "= merge.recursive(true, " + index + ", config);");
    });

    return object;
}
