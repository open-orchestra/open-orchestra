module.exports = function(grunt) {
    require('load-grunt-tasks')(grunt);
    grunt.loadTasks('./grunt_tasks');
    grunt.loadTasks('./vendor/open-orchestra/open-orchestra-cms-bundle/OpenOrchestra/GruntTasks');

    var config = {
        pkg: grunt.file.readJSON('package.json'),
        env: process.env
    };
    grunt.util._.extend(config, loadConfig('./grunt_tasks/options/'));
    grunt.util._.extend(config, loadConfig('./vendor/open-orchestra/open-orchestra-cms-bundle/OpenOrchestra/GruntTasks/Options/'));

    grunt.initConfig(config);
};

function loadConfig(path) {
    var glob = require('glob');
    var object = {};
    var key;

    glob.sync('*', {cwd: path}).forEach(function(option) {
        key = option.replace(/\.js$/,'');
        keys =  key.split('.');
        if (1 == keys.length) {
            object[keys[0]] = require(path + option);
        } else {
            if (!object[keys[0]]) {
                object[keys[0]] = {};
            }
            object[keys[0]][keys[1]] = require(path + option);
        }
    });

    return object;
}
