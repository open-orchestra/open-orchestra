module.exports = function(grunt) {
  grunt.registerTask(
    'css',
    'Main project task to generate stylesheets',
    [
      'less:discovering',
      'less',
      'concat:lib_css',
      'concat:lib_patches_css',
      'concat:orchestra_css',
      'concat:media_css',
      'concat:all_css',
      'cssmin'
    ]
  );
};
