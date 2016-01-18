module.exports = function(grunt) {
  grunt.registerTask(
    'javascript',
    'Main project task to generate javascripts',
    [
      'coffee:discovering',
      'coffee:compile',
      'concat:smartadmin_js',
      'concat:lib_js',
      'concat:orchestra_js',
      'concat:media_js',
      'concat:all_js'
    ]
  );
};
