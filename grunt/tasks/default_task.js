module.exports = function(grunt) {
  grunt.registerTask(
    'default',
    'Main default Open Orchestra task',
    [
      'clean:built',
      'clean:symlinks',
      'commands:assets_install',
      'symlink',
      'css',
      'javascript',
      'javascriptProd',
      'commands:assetic_dump'
    ]
  );
};
