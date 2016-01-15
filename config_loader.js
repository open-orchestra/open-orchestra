module.exports = {

  loadDir: function(path) {
    var glob = require('glob');
    var merge = require('merge');
    var dirConfig = {};
    var that = this;

    glob.sync('*', {cwd: path}).forEach(function(filename) {
      var fileConfig = that.loadFile(path, filename);
      dirConfig = merge.recursive(true, dirConfig, fileConfig);
    });

    return dirConfig;
  },

  loadFile: function(path, filename) {
    var keys =  filename.replace(/\.js$/, '').split('.');

    return this.buildFromFile(keys, path + filename);
  },

  buildFromFile: function(keys, filepath) {
    if (keys.length == 0) {

      return require(filepath);
    } else {
      var subArray = {};
      var index = keys[0];
      keys.shift();
      subArray[index] = this.buildFromFile(keys, filepath);

      return subArray;
    }
  }
};
