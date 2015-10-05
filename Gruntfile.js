module.exports = function(grunt) {
    require('load-grunt-tasks')(grunt);
    grunt.loadTasks('./grunt_tasks');
    grunt.loadTasks('./vendor/open-orchestra/open-orchestra-cms-bundle/GruntTasks');
    grunt.loadTasks('./vendor/open-orchestra/open-orchestra-media-admin-bundle/GruntTasks');

    var merge = require('merge');
    var config = {
        pkg: grunt.file.readJSON('package.json'),
        env: process.env
    };
    config = merge.recursive(true, config, loadDirConfig('./grunt_tasks/options/'));
    config = merge.recursive(true, config, loadDirConfig('./vendor/open-orchestra/open-orchestra-cms-bundle/GruntTasks/Options/'));
    config = merge.recursive(true, config, loadDirConfig('./vendor/open-orchestra/open-orchestra-media-admin-bundle/GruntTasks/Options/'));

    grunt.initConfig(config);
};

function loadDirConfig(path) {
    var glob = require('glob');
    var merge = require('merge');
    var dirConfig = {};

    glob.sync('*', {cwd: path}).forEach(function(filename) {
        var fileConfig = loadFileConfig(path, filename);
        dirConfig = merge.recursive(true, dirConfig, fileConfig);
    });

    return dirConfig;
}

function loadFileConfig(path, filename) {
    var keys =  filename.replace(/\.js$/,'').split('.');

    var buildFileConfig = function(keys, filepath) {
        if (keys.length == 0) {
            return require(filepath);
        } else {
            var subArray = {};
            var index = keys[0];
            keys.shift();
            subArray[index] = buildFileConfig(keys, filepath);
            return subArray;
        }
    };

    return buildFileConfig(keys, path + filename);
}
